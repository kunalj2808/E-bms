@extends('layouts.app')

@section('content')
    <div class="nk-content-body">
        <div class="nk-block">
            @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <div class="preview-block">
                        <span class="preview-title-lg overline-title">General Settings Form Preview</span>
                        <form action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT') <!-- Ensure this is present -->
                            <b>TARIFF GRID</b>
                            <hr>
                            <div class="row gy-4">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label" for="default-01">UPTO 50</label><span
                                            class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" placeholder="5" name="upto_50"
                                                value="{{ old('upto_50', $general->upto_50 ?? '') }}" step="any" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label" for="default-01">UPTO 50-150</label><span
                                            class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" placeholder="6.5" name="upto_50_150"
                                                value="{{ old('upto_50_150', $general->upto_50_150 ?? '') }}" step="any" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label" for="default-01">UPTO 150-300</label><span
                                            class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" placeholder="7" name="upto_150_300"
                                                value="{{ old('upto_150_300', $general->upto_150_300 ?? '') }}" step="any" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form-label" for="default-01">Above 300</label><span
                                            class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" placeholder="7.5" name="above_300"
                                                value="{{ old('above_300', $general->above_300 ?? '') }}" step="any" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="default-05">TARIFF DG (PER UNIT)</label> <span
                                            class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" name="tariff_dg"
                                                value="{{ old('tariff_dg', $general->tariff_dg ?? '') }}" placeholder="5.00" step="any" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="default-03">SERVICE TAX ON GRID CONSUMPTION</label>
                                        <span class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" name="service_tax_dg"
                                                value="{{ old('service_tax_dg', $general->service_tax_dg ?? '') }}" placeholder="0%" step="any" required>
                                        </div>
                                    </div>
                                </div>
                                <b>ELECTRICITY DUTY</b>
                                <hr>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label" for="default-05">UPTO </label> <span
                                            class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" name="electricity_upto"
                                                value="{{ old('electricity_upto', $general->electricity_upto ?? '') }}" placeholder="100" step="any" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label" for="default-03">AMOUNT</label> <span
                                            class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" name="electicity_value"
                                                value="{{ old('electicity_value', $general->electicity_value ?? '') }}" placeholder="6.5" step="any" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label" for="default-05">ABOVE <span class="above_duty"></span>
                                            AMOUNT</label>
                                        <span class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" name="electicity_above_value"
                                                value="{{ old('electicity_above_value', $general->electicity_above_value ?? '') }}" placeholder="7.0" step="any" required>
                                        </div>
                                    </div>
                                </div>
                                <b>GENRAL</b>
                                <hr>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="default-05">LATE PAYMENT SURCHARGE (IN %) </label> <span
                                            class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" name="late_percentage"
                                                value="{{ old('late_percentage', $general->late_percentage ?? '') }}" placeholder="1.25"  step="any" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="default-05"> FIXED MAINTAINANCE COST </label> <span
                                            class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="number" class="form-control" name="maintain_cost"
                                                value="{{ old('maintain_cost', $general->maintain_cost ?? '') }}" placeholder="1.25"  step="any" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form-label" for="default-05"> PAYMENT QR CODE </label> <span
                                            class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="file" class="form-control" name="payment_qr">
                                        </div>
                                    </div>
                                </div>
                                <div id="imagePreview" style="display: {{ isset($general->qr_image) ? 'block' : 'none' }}">
                                    <img src="{{ asset('images/admin/' . $general->qr_image) }}" alt="Preview Image" style="max-width: 200px; max-height: 200px;"/>
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
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const electricityInput = document.querySelector('input[name="electricity_upto"]');
                const aboveDutySpan = document.querySelector('.above_duty');

                // Update span when the input value changes
                electricityInput.addEventListener('input', function() {
                    aboveDutySpan.textContent = electricityInput.value;
                });
            });
        </script>
