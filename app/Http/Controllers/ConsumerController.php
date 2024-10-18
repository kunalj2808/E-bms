<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
use App\Models\BillSetting;
use App\Models\GeneralSetting;
use App\Models\Bill;
use App\Models\Payment;
use Illuminate\Http\Request;


class ConsumerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consumers = Consumer::all();
        return view('consumers.index', compact('consumers'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('consumers.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'consumer_name' => 'required|string|max:255',
            'flat_number' => 'nullable|string|max:255',
            'meter_number' => 'required|string|unique:consumers,meter_number|max:255',
            'mailing_address' => 'nullable|string',
            'supply_at' => 'nullable|string',
            'area' => 'required|numeric',
            'previous_reading' => 'required|numeric',
            'previous_amount' => 'required|numeric',
            'previous_month' => 'required|date', // Ensure it's a valid date
        ]);
    
        // Store the consumer data
        $consumer = Consumer::create([
            'consumer_name' => $request->input('consumer_name'),
            'flat_number' => $request->input('flat_number'),
            'meter_number' => $request->input('meter_number'),
            'mailing_address' => $request->input('mailing_address'),
            'supply_at' => $request->input('supply_at'),
            'area' => $request->input('area'),
        ]);

        if($request->input('previous_reading') > 0){
        // Format reporting month as YEAR-MONTH
        $reporting_month = \Carbon\Carbon::parse($request->input('previous_month'))->format('Y-m');
        // Prepare bill dates
        $bill_date = \Carbon\Carbon::parse($request->input('previous_month'))->format('Y-m-d'); // Full date (e.g., '2024-09-30')
        $bill_due_date = \Carbon\Carbon::parse($request->input('previous_month'))->addDays(10)->format('Y-m-d'); // Example: Due date set 15 days after bill date
        // Store the bill data
            $bill = Bill::create([
                'consumer_id' => $consumer->id,
                'reporting_month' => $reporting_month,
                'bill_date' => $bill_date,
                'bill_due_date' => $bill_due_date,
                'remarks' => "Previous Record",
                'current_reading' => $request->input('previous_reading'),
                'previous_reading' => 0,
                'current_bill_amount' => $request->input('previous_amount'),
                'previous_due_amount' => 0,
                'tariff_dg' => 0,
                'is_previous' => 0,
            ]);
            $general_setting = GeneralSetting::first();
            $bill_setting = BillSetting::create([
                'upto_50' => $general_setting->upto_50,
                'upto_50_150' => $general_setting->upto_50_150,
                'upto_150_300' => $general_setting->upto_150_300,
                'above_300' => $general_setting->above_300,
                'tariff_dg' => $general_setting->tariff_dg,
                'service_tax_dg' => $general_setting->service_tax_dg,
                'electricity_upto' => $general_setting->electricity_upto,
                'electicity_value' => $general_setting->electicity_value,
                'electicity_above_value' => $general_setting->electicity_above_value,
                'late_percentage' => $general_setting->late_percentage,
                'maintain_cost' => $general_setting->maintain_cost,
                'qr_image' => $general_setting->qr_image,
                'bill_id' => $bill->id,
            ]);
        }
       
    
      //  Redirect with success message
      return redirect()->route('consumers.index')->with('success', 'Consumer details have been successfully saved.');
    }

   
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $consumer = Consumer::findOrFail($id);
        $bill = Bill::where('consumer_id', $id)->where('is_previous',0)
        ->first();  // Get the first record (oldest)
        // dd($bill);  
        return view('consumers.edit', compact('consumer','bill'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $consumer = Consumer::findOrFail($id);
        $consumer->update($request->all());     
        
        if($request->input('previous_reading') > 0  && $request->input('bill_id') == 0){
            // Format reporting month as YEAR-MONTH
            $reporting_month = \Carbon\Carbon::parse($request->input('previous_month'))->format('Y-m');
            // Prepare bill dates
            $bill_date = \Carbon\Carbon::parse($request->input('previous_month'))->format('Y-m-d'); // Full date (e.g., '2024-09-30')
            $bill_due_date = \Carbon\Carbon::parse($request->input('previous_month'))->addDays(10)->format('Y-m-d'); // Example: Due date set 15 days after bill date
            // Store the bill data
                $bill = Bill::create([
                    'consumer_id' => $consumer->id,
                    'reporting_month' => $reporting_month,
                    'bill_date' => $bill_date,
                    'bill_due_date' => $bill_due_date,
                    'remarks' => "Previous Record",
                    'current_reading' => $request->input('previous_reading'),
                    'previous_reading' => 0,
                    'current_bill_amount' => $request->input('previous_amount'),
                    'previous_due_amount' => 0,
                    'tariff_dg' => 0,
                    'is_previous' => 0,
                ]);
    
            }

            if($request->input('previous_reading') == 0 && $request->input('bill_id') != 0){
                $bill = Bill::findOrFail($request->input('bill_id'));
                $bill->delete();
            }

      
        return redirect()->route('consumers.index')->with('success', 'Consumer details have been updated.');
    }
    /**
     * Remove the specified resource from storage.
     */
    // Delete a consumer
    public function destroy($id)
    {
        $consumer = Consumer::findOrFail($id);
        $consumer->delete();

        return redirect()->route('consumers.index')->with('success', 'Consumer deleted successfully.');
    }
}
