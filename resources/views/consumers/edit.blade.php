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
                            @method('PUT') <!-- This ensures the form sends a PUT request -->
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
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label" for="default-05">Flat Number </label> <span class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="flat_number"
                                                value="{{ $consumer->flat_number }}" placeholder="ABC123XXX" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label" for="default-03">Meter Number</label> <span class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="meter_number"
                                                value="{{ $consumer->meter_number }}" placeholder="ABC123XXX" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label" for="default-04">Supply At</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="supply_at"
                                                value="{{ $consumer->supply_at }}" placeholder="XYX 440V">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label" for="default-04">Previous Reading</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="previous_reading"
                                            value="{{ $bill->current_reading }}" placeholder="100">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label" for="default-04">Previous Amount</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="previous_amount"
                                            value="{{ $bill->current_bill_amount }}" placeholder="00">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label" for="">Previous Month</label>
                                        <div class="form-control-wrap">
                                            <input type="date" class="form-control" id="supply_at" name="previous_month"  value="{{ $bill->current_bill_amount }}">
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="bill_id" value="{{ $bill->current_bill_amount }}">
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
                
                // Set the minimum date (earliest date allowed) - for example, from January 1, 2000
                const earliestDate = new Date(2000, 0, 1); // You can adjust the year as needed
                
                // Format the date to YYYY-MM-DD
                const formatDate = (date) => {
                    let day = date.getDate().toString().padStart(2, '0');
                    let month = (date.getMonth() + 1).toString().padStart(2, '0');
                    let year = date.getFullYear();
                    return `${year}-${month}-${day}`;
                };
            
                // Set the min and max attributes for the input field
                const supplyAtInput = document.getElementById('supply_at');
                supplyAtInput.min = formatDate(earliestDate); // Earliest date allowed
                supplyAtInput.max = formatDate(lastDayPrevMonth); // Last day of the previous month
                
                // Set the default value to the last day of the previous month
                supplyAtInput.value = formatDate(lastDayPrevMonth);
            </script>
        @endsection
