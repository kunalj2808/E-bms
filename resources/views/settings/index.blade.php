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
                        <span class="preview-title-lg overline-title">Settings Form Preview</span>
                        <form action="{{ route('settings.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                      @method('PUT') <!-- Ensure this is present -->
                           
                            <div class="row gy-4">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="company_name">Company Name</label><span class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="company_name" 
                                                   value="{{ old('company_name', $user->company_name ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="default-01">Company Address</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" placeholder="Company Address"
                                                name="company_address" value="{{ old('company_address',$user->company_address ?? '') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="default-05">Admin Email </label> <span class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="admin_email"
                                                value="{{ old('admin_email',$user->email ?? '') }}" placeholder="admin@admin.com" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="default-04"> Admin Full Name</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="name"
                                                value="{{ old('name',$user->name ?? '') }}" placeholder="ABC">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label" for="default-03">Admin Number</label> <span class="text-danger">*</span>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="admin_number"
                                                value="{{ old('admin_number',$user->phone_number ?? '') }}" placeholder="+91 XXXXXXXXX" >
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label" for="default-04"> Display Name </label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="display_name"
                                                value="{{ old('display_name',$user->display_name ?? '') }}" placeholder="XYZ">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form-label" for="default-04"> Designation</label>
                                        <div class="form-control-wrap">
                                            <input type="text" class="form-control" name="designation"
                                                value="{{ old('designation',$user->designation ?? '') }}" placeholder="Admin">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="admin_image">Admin Image</label>
                                        <div class="form-control-wrap">
                                            <input type="file" class="form-control" name="admin_image">
                                        </div>
                                    </div>
                                </div>
                                <!-- Company Banner -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="company_banner">Company Banner / Logo</label>
                                        <div class="form-control-wrap">
                                            <input type="file" class="form-control" name="company_banner">
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
