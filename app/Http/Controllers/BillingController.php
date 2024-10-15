<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\GeneralSetting;

use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index()
    {
        $users = Consumer::all();  // Fetch all users
        $bills = Bill::with('payment', 'consumer')->where('is_previous',1)
            ->orderBy('created_at', 'asc')  // Order by creation date (oldest first)
            ->get();
        return view('billing.generateBilling', compact('users', 'bills'));
    }

    public function create()
    {
        return view('billing.create');
    }

    public function view($id, $consumer_id)
    {

        $bill = Bill::with('payment', 'consumer')->where('id', $id)->first(); // Use first() to get a single instance

        $consumer_id = $bill->consumer->id;
        $bill_date = $bill->bill_date;
        $total_reading = $bill->current_reading;
        $remarks = $bill->remarks;
        $tariff_dg = $bill->tariff_dg;

        $consumer_details = Consumer::findOrFail($consumer_id);
        // Assume $bill_date is the date you want to 4

        $previous_bill = Bill::with('payment')
            ->where('consumer_id', $consumer_id)
            ->where('bill_date', '<', $bill_date)  // Compare with the given bill_date
            ->orderBy('bill_date', 'desc')  // Get the latest bill before the given bill_date
            ->first();

        // If no previous bill exists, provide static data
        if (!$previous_bill) {
            $previous_bill = (object) [
                'consumer_id' => $consumer_id,
                'reporting_month' => 'Jan ' . \Carbon\Carbon::parse($bill_date)->year,  // Static January for fallback
                'bill_date' => \Carbon\Carbon::parse($bill_date)->subMonth()->format('Y-m-d'),  // Default previous month date
                'bill_due_date' => \Carbon\Carbon::parse($bill_date)->subMonth()->addDays(10)->format('Y-m-d'),  // Default bill due date
                'remarks' => "Previous Record",
                'current_reading' => 0,
                'previous_reading' => 0,
                'current_bill_amount' => 0,
                'previous_due_amount' => 0,
                'tariff_dg' => 0,
               'is_previous' => 1,
            ];
        }

        $general_setting = GeneralSetting::first();
        $present_reading = $total_reading - $previous_bill->current_reading;
        $general_tariff_range = (object) [
            'upto_50' => $general_setting->upto_50,
            'upto_50_150' => $general_setting->upto_50_150,
            'upto_150_300' => $general_setting->upto_150_300,
            'above_300' => $general_setting->above_300
        ];

        $result = $this->calculateBillAmount($present_reading, $general_tariff_range);
        $total_reading_amount = $result['total_amount'];
        $energy_chg_charger = $tariff_dg ? $tariff_dg  * $general_setting->tariff_dg : 0;
        $fixed_charge = $present_reading / 15 * 27;
        if ($present_reading > $general_setting->electricity_upto) {
            $electricity_duty = $general_setting->electricity_upto * $general_setting->electicity_value * 9 / 100
                + ($present_reading - $general_setting->electricity_upto) * $general_setting->electicity_above_value * 12 / 100;
        } else {
            $electricity_duty = $general_setting->electricity_upto * $general_setting->electicity_value * 9 / 100;
        }

        if ($previous_bill) {
            // Check if the related payment exists
            if (is_object($previous_bill) && isset($previous_bill->payment)) {
                // If payment exists, calculate the previous amount
                $previous_amount = $previous_bill->current_bill_amount - $previous_bill->payment->received_amount;
            } else {
                // If no payment exists, use the current bill amount as previous amount
                $previous_amount = $previous_bill->current_bill_amount;
            }
        } else {
            // Handle the case where there are no previous bills
            $previous_amount = 0; // or whatever logic you want to implement here
        }
        $fixed_maintain_charge = $consumer_details->area * $general_setting->maintain_cost;

        $grand_total = $total_reading_amount + $energy_chg_charger + $fixed_charge + $electricity_duty + $previous_amount + $fixed_maintain_charge;
        $reporting_month = \Carbon\Carbon::parse($bill_date)->format('Y-m');
        // Prepare bill dates
        $bill_date = \Carbon\Carbon::parse($bill_date)->format('Y-m-d'); // Full date (e.g., '2024-09-30')
        $bill_due_date = \Carbon\Carbon::parse($bill_date)->addDays(10)->format('Y-m-d');// Example: Due date set 15 days after bill date
        $general_tariff_range = (object) [
            'upto_50' => $general_setting->upto_50,
            'upto_50_150' => $general_setting->upto_50_150,
            'upto_150_300' => $general_setting->upto_150_300,
            'above_300' => $general_setting->above_300
        ];
        // $lateFees = \Carbon\Carbon::parse($bill_due_date)->isPast() ? 100 : 0;
       
        $total_energy_bill = $total_reading_amount+ $energy_chg_charger+$fixed_charge+$electricity_duty+$fixed_maintain_charge;
            
        // Initialize late fees
        $lateFees = 0;
        $current_date = \Carbon\Carbon::now()->format('Y-m-d');

        // Check if the due date is before the current date
        if (\Carbon\Carbon::parse($bill_due_date)->lt(\Carbon\Carbon::parse($current_date))) {
            // If due date has passed, calculate late fees
            $lateFees = ($total_energy_bill * $general_setting->late_percentage) / 100;
        } else {
            // If due date is not passed, late fees remain 0
            $lateFees = 0;
        }

        $total_energy_bill = $total_energy_bill +$lateFees;


        $calculation = (object) [
            'electricity_duty' => $electricity_duty,
            'fixed_maintain_charge' => $fixed_maintain_charge,
            'total_reading_amount' => $total_reading_amount,
            'energy_chg_charger' => $energy_chg_charger,
            'fixed_charge' => $fixed_charge,
            'lateFees' => $lateFees,
            'total_energy_bill' => $total_energy_bill,
        ];

        $rr = $present_reading;

        // Initialize partial readings for each tier
        $upto_50 = 0;
        $upto_150 = 0;
        $upto_300 = 0;
        $above_300 = 0;

        // Calculate charges based on tiers
        if ($rr > 0) {
            // Charge for the first 50 units
            if ($rr >= 50) {
                $upto_50 = 50; // Charge the full 50 units
                $rr -= 50; // Reduce the remaining reading
            } else {
                $upto_50 = $rr; // Charge remaining if less than 50
                $rr = 0; // Reading is exhausted
            }
        }

        if ($rr > 0) {
            // Charge for the next 100 units (51 to 150)
            if ($rr >= 100) {
                $upto_150 = 100; // Charge the full 100 units
                $rr -= 100; // Reduce the remaining reading
            } else {
                $upto_150 = $rr; // Charge remaining if less than 100
                $rr = 0; // Reading is exhausted
            }
        }

        if ($rr > 0) {
            // Charge for the next 150 units (151 to 300)
            if ($rr >= 150) {
                $upto_300 = 150; // Charge the full 150 units
                $rr -= 150; // Reduce the remaining reading
            } else {
                $upto_300 = $rr; // Charge remaining if less than 150
                $rr = 0; // Reading is exhausted
            }
        }

        if ($rr > 0) {
            // Charge for any remaining units above 300
            $above_300 = $rr; // Charge whatever is left
        }

        // Create an array object to store the results
        $partial_readings = [
            'upto_50' => $upto_50,
            'upto_150' => $upto_150,
            'upto_300' => $upto_300,
            'above_300' => $above_300,
        ];

        // Output the results

        $partial_reading = (object) [
            'upto_50' => $general_setting->upto_50,
            'upto_50_150' => $general_setting->upto_50_150,
            'upto_150_300' => $general_setting->upto_150_300,
            'above_300' => $general_setting->above_300
        ];

        return view('billing.view', compact('consumer_details', 'previous_bill', 'general_setting', 'bill', 'general_tariff_range', 'result', 'calculation', 'partial_readings'));
    }

    function calculateBillAmount($reading, $general_setting)
    {
        // Initialize the total amount and amounts for each slab
        $totalAmount = 0;
        $amounts = [
            'upto_50' => 0,
            'upto_50_150' => 0,
            'upto_150_300' => 0,
            'above_300' => 0,
        ];

        // Set the rates from general settings
        $rate_upto_50 = $general_setting->upto_50;
        $rate_upto_50_150 = $general_setting->upto_50_150;
        $rate_upto_150_300 = $general_setting->upto_150_300;
        $rate_above_300 = $general_setting->above_300;

        // Calculate for the first 50 units
        if ($reading > 50) {
            $amounts['upto_50'] = 50 * $rate_upto_50;
            $totalAmount += $amounts['upto_50'];
            $reading -= 50; // Reduce reading by 50
        } else {
            $amounts['upto_50'] = $reading * $rate_upto_50;
            $totalAmount += $amounts['upto_50'];
            return [
                'total_amount' => $totalAmount,
                'breakdown' => $amounts
            ]; // Return the total and breakdown
        }

        // Calculate for the next 100 units (between 50 and 150)
        if ($reading > 100) {
            $amounts['upto_50_150'] = 100 * $rate_upto_50_150;
            $totalAmount += $amounts['upto_50_150'];
            $reading -= 100; // Reduce reading by 100
        } else {
            $amounts['upto_50_150'] = $reading * $rate_upto_50_150;
            $totalAmount += $amounts['upto_50_150'];
            return [
                'total_amount' => $totalAmount,
                'breakdown' => $amounts
            ]; // Return the total and breakdown
        }

        // Calculate for the next 150 units (between 150 and 300)
        if ($reading > 150) {
            $amounts['upto_150_300'] = 150 * $rate_upto_150_300;
            $totalAmount += $amounts['upto_150_300'];
            $reading -= 150; // Reduce reading by 150
        } else {
            $amounts['upto_150_300'] = $reading * $rate_upto_150_300;
            $totalAmount += $amounts['upto_150_300'];
            return [
                'total_amount' => $totalAmount,
                'breakdown' => $amounts
            ]; // Return the total and breakdown
        }

        // Calculate for any units above 300
        if ($reading > 0) {
            $amounts['above_300'] = $reading * $rate_above_300;
            $totalAmount += $amounts['above_300'];
        }

        return [
            'total_amount' => $totalAmount,
            'breakdown' => $amounts
        ];
    }

    public function store(Request $request)
    {

        $request->validate([
            'user_id' => 'required',
            'bill_date' => 'required|date', // Ensure it's a valid date
            'current_reading' => 'required|numeric',
            'remarks' => 'nullable|string',
            'tariff_dg' => 'required|numeric',
        ]);

        $consumer_id = $request->user_id;
        $bill_date = $request->bill_date;
        $total_reading = $request->current_reading;
        $remarks = $request->remarks;
        $tariff_dg = $request->tariff_dg;

        // print_r($bill_date);
        $dateObj = new \DateTime($bill_date);
        // Get the current month and year
         // Get the month and year
        $month = $dateObj->format('m'); // 'm' gives month as a two-digit number
        $year = $dateObj->format('Y');  // 'Y' gives the full year

        // Check if a bill exists for this consumer created this month and year
        $bill_exist = Bill::where('consumer_id', $consumer_id)
            ->whereMonth('bill_date', $month)
            ->whereYear('bill_date', $year)
            ->exists();  // Use exists() to check if a record exists

        if ($bill_exist) {
            // If a bill for this month already exists
            return redirect()->route('billings.index')->with('error', 'A bill for this month has already been created for this consumer.');
        }

        $consumer_details = Consumer::findOrFail($consumer_id);
        // print_r($consumer_details);
        $previous_bill = Bill::with('payment')
            ->where('consumer_id', $consumer_id)
            ->where('bill_date', '<', $bill_date)  // Compare with the given bill_date
            ->orderBy('bill_date', 'desc')  // Get the latest bill before the given bill_date
            ->first();

            if($previous_bill && $previous_bill->current_reading >$total_reading ){
            return redirect()->route('billings.index')->with('error', 'Present Reading can not be Smaller Than Previous Reading ');
            }
        // If no previous bill exists, provide static data
        if (!$previous_bill) {
            $previous_bill = (object) [
                'consumer_id' => $consumer_id,
                'reporting_month' => 'Jan ' . \Carbon\Carbon::parse($bill_date)->year,  // Static January for fallback
                'bill_date' => \Carbon\Carbon::parse($bill_date)->subMonth()->format('Y-m-d'),  // Default previous month date
                'bill_due_date' => \Carbon\Carbon::parse($bill_date)->subMonth()->addDays(10)->format('Y-m-d'),  // Default bill due date
                'remarks' => "Previous Record",
                'current_reading' => 0,
                'previous_reading' => 0,
                'current_bill_amount' => 0,
                'previous_due_amount' => 0,
                'tariff_dg' => 0,
                'is_previous' => 1,
            ];
        }


        $general_setting = GeneralSetting::first();

        // print_r($general_setting);
        if ($total_reading < $previous_bill->current_reading) {
            return redirect()->route('billings.index')->with('error', 'Previous reading should not be greater than current reading.');
        }

        $present_reading = $total_reading - $previous_bill->current_reading;


        $general_tariff_range = (object) [
            'upto_50' => $general_setting->upto_50,
            'upto_50_150' => $general_setting->upto_50_150,
            'upto_150_300' => $general_setting->upto_150_300,
            'above_300' => $general_setting->above_300
        ];

        $result = $this->calculateBillAmount($present_reading, $general_tariff_range);

        $total_reading_amount = $result['total_amount'];
        $energy_chg_charger = $tariff_dg ? $present_reading * $general_setting->tariff_dg : 0;
        $fixed_charge = $present_reading / 15 * 27;
        if ($present_reading > $general_setting->electricity_upto) {
            $electricity_duty = $general_setting->electricity_upto * $general_setting->electicity_value * 9 / 100
                + ($present_reading - $general_setting->electricity_upto) * $general_setting->electicity_above_value * 12 / 100;
        } else {
            $electricity_duty = $general_setting->electricity_upto * $general_setting->electicity_value * 9 / 100;
        }

        if ($previous_bill) {
            // Check if the related payment exists
            if (property_exists($previous_bill, 'payment') && $previous_bill->payment) {
                // If payment exists, calculate the previous amount
                $previous_amount = $previous_bill->current_bill_amount - $previous_bill->payment->received_amount;
            } else {
                // If no payment exists, use the current bill amount as previous amount
                $previous_amount = $previous_bill->current_bill_amount;
            }
        } else {
            // Handle the case where there are no previous bills
            $previous_amount = 0; // or whatever logic you want to implement here
        }

        $fixed_maintain_charge = $consumer_details->area * $general_setting->maintain_cost;

        $grand_total = $total_reading_amount + $energy_chg_charger + $fixed_charge + $electricity_duty + $previous_amount + $fixed_maintain_charge;


        $reporting_month = \Carbon\Carbon::parse($request->bill_date)->format('Y-m');
        // Prepare bill dates
        $bill_date = \Carbon\Carbon::parse($request->bill_date)->format('Y-m-d'); // Full date (e.g., '2024-09-30')
        $bill_due_date = \Carbon\Carbon::parse($request->bill_date)->addDays(10)->format('Y-m-d'); // Example: Due date set 15 days after bill date

        $bill = Bill::create([
            'consumer_id' => $consumer_id,
            'reporting_month' => $reporting_month,
            'bill_date' => $bill_date,
            'bill_due_date' => $bill_due_date,
            'remarks' => $remarks,
            'current_reading' => $total_reading,
            'previous_reading' => $previous_bill->current_reading,
            'current_bill_amount' => $grand_total,
            'previous_due_amount' => $previous_amount,
            'tariff_dg' => $tariff_dg,
        ]);


        return redirect()->route('billings.index')->with('success', 'Bill Has Been Generated');
    }

    public function destroy($id)
    {
        $consumer = Bill::findOrFail($id);
        $consumer->delete();

        return redirect()->route('billings.index')->with('success', 'Bill deleted successfully.');
    }
}
