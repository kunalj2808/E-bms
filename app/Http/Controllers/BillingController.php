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
        return view('billing.generateBilling',compact('users'));
    }

    public function create()
    {
        return view('billing.create');

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
        print_r($request->all());
        $general_setting = GeneralSetting::first();
        dd($general_setting);
        $general_setting = (object) [
            'upto_50' => $general_setting->upto_50,
            'upto_50_150' => $general_setting->upto_50_150,
            'upto_150_300' => $general_setting->upto_150_300,
            'above_300' => $general_setting->above_300
        ];

        
         $result = $this->calculateBillAmount($request->current_reading, $general_setting);
         dd($result['total_amount']);
        //  echo "Total Bill Amount: ₹" . $result['total_amount'] . "\n";
        //  echo "Breakdown:\n";
        //  foreach ($result['breakdown'] as $slab => $amount) {
        //      echo ucfirst(str_replace('_', ' ', $slab)) . ": ₹" . number_format($amount, 2) . "\n";
        //  }
        $total_reading_amount=$result['total_amount'];
        $fixed_charge=$request->input('current_reading')/15*27;
        if($request->input('current_reading') > $general_setting->electricity_upto){
            $electricity_duty = $general_setting->electricity_upto*$general_setting->electicity_value*9/100 + ($request->input('current_reading')-$general_setting->electricity_upto)*$general_setting->electicity_above_value*12/100;
        }else{
            $electricity_duty= $general_setting->electricity_upto*$general_setting->electicity_value*9/100 ;
        }
        // $electricity_duty = 
         //  Validate the incoming data
         $request->validate([
            'user_id' => 'required',
            'bill_date' => 'required',
            'current_reading' => 'required|numeric|max:255',
        ]);

        $previous_data = Bill::with('payment')->where("consumer_id", $request->user_id)->latest()->first();
        $reporting_month = \Carbon\Carbon::parse($request->bill_date)->format('Y-m');
        // dd($reports);

        if ($previous_data && $previous_data->payment) {
            // Access the related payment through the relationship
            dd($previous_data); // Or any other field from the payment
        } else {
            dd('No payment found for this bill');
        }
        dd($payment);
        if(!$previous_data){
            $previous_reading = $user->current_reading;
            $previous_ = $user->current_reading;
        }
        $billDate = Carbon::parse($request->bill_date);
        $billDueDate = $billDate->addDays(10);  // Add 10 days to the bill date

          //  Store the validated data in the 'consumers' table
          Bill::create([
            'consumer_id' => $request->input('user_id'),
            'reporting_month' => $reporting_month,
            'bill_date' => $billDueDate,
            'remarks' => $request->input('remarks'),
            'current_reading' => $request->input('current_reading'),
            'previous_reading' => $payment->current_reading,
        ]);

        return view('billing.create');

    }
}
