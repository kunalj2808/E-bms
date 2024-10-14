<?php

namespace App\Http\Controllers;

use App\Models\Consumer;
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
        // dd($request->all());
        // Validate the incoming data
        $request->validate([
            'consumer_name' => 'required|string|max:255',
            'flat_number' => 'nullable|string|max:255',
            'meter_number' => 'required|string|unique:consumers,meter_number|max:255',
            'mailing_address' => 'nullable|string',
            'supply_at' => 'nullable|string',
            'previous_reading' => 'required|numeric',
            'area' => 'required|numeric',
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
        // Format reporting month as YEAR-MONTH
        $reporting_month = \Carbon\Carbon::parse($request->input('previous_month'))->format('Y-m');
    
        // Prepare bill dates
        $bill_date = \Carbon\Carbon::parse($request->input('previous_month'))->format('Y-m-d'); // Full date (e.g., '2024-09-30')
        $bill_due_date = \Carbon\Carbon::parse($request->input('previous_month'))->addDays(10)->format('Y-m-d'); // Example: Due date set 15 days after bill date
        // dd($bill_date);
        // Store the bill data
        if ($request->input('previous_amount') > 0) {
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
            ]);
        } else {
            $bill = Bill::create([
                'consumer_id' => $consumer->id,
                'reporting_month' => $reporting_month,
                'bill_date' => $bill_date,
                'bill_due_date' => $bill_due_date,
                'remarks' => "Previous Record",
                'current_reading' => $request->input('previous_reading'),
                'previous_reading' => 0,
                'current_bill_amount' => 0,
                'previous_due_amount' => 0,
                'tariff_dg' => 0,
            ]);
    
            // Store the payment data
            Payment::create([
                'bill_id' => $bill->id,
                'received_amount' => 0,
                'late_fees' => 0,
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
        $bill = Bill::where('consumer_id', $id)
        ->orderBy('created_at', 'asc')  // Order by created_at in ascending order
        ->first();  // Get the first record (oldest)
        return view('consumers.edit', compact('consumer','bill'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $consumer = Consumer::findOrFail($id);
        $consumer->update($request->all());

         // Prepare bill dates
         $bill_date = \Carbon\Carbon::parse($request->input('previous_month'))->format('Y-m-d'); // Full date (e.g., '2024-09-30')
         $bill_due_date = \Carbon\Carbon::parse($request->input('previous_month'))->addDays(15)->format('Y-m-d'); // Example: Due date set 15 days after bill date
        $bill = Bill::where('consumer_id', $id)
        ->orderBy('created_at', 'asc')  // Order by created_at in ascending order
        ->first();  // Get the first record (oldest)

        // $bill->update($request->all());

        
        // Store the bill data
        if ($request->input('previous_amount') > 0) {
             $bill->update([
                'bill_date' => $bill_date,
                'bill_due_date' => $bill_due_date,
                'current_reading' => $request->input('previous_reading'),
                'current_bill_amount' => $request->input('previous_amount'),
            ]);
        } else {
            $bill->update([
                'bill_date' => $bill_date,
                'bill_due_date' => $bill_due_date,
                'current_reading' => $request->input('previous_reading'),
            ]);
            $payments = Consumer::findOrFail($request->input('bill_id'));
            $payments->delete();
            // Store the payment data
            Payment::create([
                'bill_id' => $bill->id,
                'received_amount' => 0,
                'late_fees' => 0,
            ]);
        }
         // Update user attributes
        $bill ->update([
            'company_name' => $request->input('company_name'),
            'company_address' => $request->input('company_address'),
            'email' => $request->input('admin_email'),
            'name' => $request->input('name'),
            'phone_number' => $request->input('admin_number'),
            'display_name' => $request->input('display_name'),
            'designation' => $request->input('designation'),
        ]);



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
