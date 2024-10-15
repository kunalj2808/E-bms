@extends('layouts.app')

@section('content')
    <div class="nk-content-body">
        <div class="nk-block">
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <div class="preview-block">
                        <span class="preview-title-lg overline-title">Edit Consumer Form Preview</span>
                        <form action="{{ route('consumers.update', $consumer->id) }}" method="POST">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="default-01">Consumer Name</label><span class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" placeholder="name"
                                                name="consumer_name" value="{{ $consumer->consumer_name }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="default-01">Mailing Address</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" placeholder="Address"
                                                name="mailing_address" value="{{ $consumer->mailing_address }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label" for="default-05">Flat Number </label> <span class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="flat_number"
                                                value="{{ $consumer->flat_number }}" placeholder="ABC123XXX" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label" for="default-03">Meter Number</label> <span class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="meter_number"
                                                value="{{ $consumer->meter_number }}" placeholder="ABC123XXX" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label" for="default-04">Supply At</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="supply_at"
                                                value="{{ $consumer->supply_at }}" placeholder="XYX 440V">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label" for="default-04">Area</label><span class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="number"  class="form-control" name="area"
                                                value="{{ $consumer->area }}" placeholder="120" required step="any">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label" for="default-04">Previous Reading</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="previous_reading"
                                            value="{{ $bill->current_reading ?? 0 }}" placeholder="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label" for="default-04">Previous Amount</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="previous_amount"
                                            value="{{ $bill->current_bill_amount ?? 0}}" placeholder="00">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label" for="previous_date">Previous Month</label>
                                        <div class="form-control-wrap">
                                            <input type="date" id="previous_date" class="form-control" name="previous_month" value="{{ $bill->bill_date ?? '' }}">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="bill_id" value="{{ $bill->id ?? 0 }}">
                                <div class="d-flex justify-content-end mb-4">
                                    <button type="submit" class="btn btn-md btn-primary">Submit</button>
                                </div>

                            </div>
                        </form>
                    </div><!-- .card-preview -->
                </div><!-- .nk-block -->
            </div>
            <script>
                // Get the current date
                const today = new Date();
                
                // Get the last day of the previous month
                const lastDayPrevMonth = new Date(today.getFullYear(), today.getMonth(), 0);
                
                // Set the minimum date (earliest date allowed) - adjust the year as needed
                const earliestDate = new Date(2000, 0, 1);
                
                // Format the date to YYYY-MM-DD
                const formatDate = (date) => {
                    let day = date.getDate().toString().padStart(2, '0');
                    let month = (date.getMonth() + 1).toString().padStart(2, '0');
                    let year = date.getFullYear();
                    return `${year}-${month}-${day}`;
                };
                
                // Get the input field
                const previousDateInput = document.getElementById('previous_date');
                
                // If there's a predefined value (from PHP), use that date; otherwise, use last day of previous month
                const preDefinedDate = previousDateInput.value ? new Date(previousDateInput.value) : lastDayPrevMonth;
            
                // If $bill->bill_date exists, restrict the input to that month
                if (previousDateInput.value) {
                    const billDate = new Date(previousDateInput.value);
                    const firstDayBillMonth = new Date(billDate.getFullYear(), billDate.getMonth(), 1);
                    const lastDayBillMonth = new Date(billDate.getFullYear(), billDate.getMonth() + 1, 0);
                    
                    // Set the min and max to the first and last days of that month
                    previousDateInput.min = formatDate(firstDayBillMonth);
                    previousDateInput.max = formatDate(lastDayBillMonth);
                } else {
                    // No pre-set bill date, allow selection up to the last day of the previous month
                    previousDateInput.min = formatDate(earliestDate);
                    previousDateInput.max = formatDate(lastDayPrevMonth);
                    
                    // Set the default value to the last day of the previous month
                    previousDateInput.value = formatDate(lastDayPrevMonth);
                }
            </script>
        @endsection
