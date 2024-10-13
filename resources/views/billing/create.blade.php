@extends('layouts.app')

@section('content')
    <div class="nk-content-body">
        <div class="nk-block">
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <div class="preview-block">
                        <span class="preview-title-lg overline-title">Consumer Form Preview</span>
                        <form action="{{ route('consumers.store') }}" method="POST">
                            @csrf
                            <div class="row gy-4">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="default-01">Consumer Name</label><span class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" placeholder="name"
                                                name="consumer_name" value="{{ old('consumer_name') }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="default-01">Mailing Address</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" placeholder="Address"
                                                name="mailing_address" value="{{ old('mailing_address') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label" for="default-05">Flat Number </label> <span class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="flat_number"
                                                value="{{ old('flat_number') }}" placeholder="ABC123XXX" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label" for="default-03">Meter Number</label> <span class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="meter_number"
                                                value="{{ old('meter_number') }}" placeholder="ABC123XXX" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label" for="default-04">Supply At</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="supply_at"
                                                value="{{ old('supply_at') }}" placeholder="XYX 440V">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end mb-4">
                                    <button type="submit" class="btn btn-md btn-primary">Submit</button>
                                </div>

                            </div>
                        </form>
                    </div><!-- .card-preview -->
                </div><!-- .nk-block -->
            </div>
        @endsection
