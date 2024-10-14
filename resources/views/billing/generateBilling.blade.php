@extends('layouts.app')

@section('content')

<div class="nk-content-body">
    <div class="nk-block-head nk-block-head-sm">
     
    
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Bills </h3>
               
            </div><!-- .nk-block-head-content -->
           
            <div class="nk-block-head-content">
                <div class="toggle-wrap nk-block-tools-toggle">
                    <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-target="pageMenu"><em class="icon ni ni-menu-alt-r"></em></a>
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#generateBillingModal">
                        <em class="icon ni ni-plus"></em>Generate Billing
                    </a>                    
                </div><!-- .toggle-wrap -->
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        @if (session('error')) <!-- Handle custom error messages -->
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        
        @if ($errors->any())  <!-- Handle validation errors -->
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <div class="nk-block">
        <div class="card card-bordered card-stretch">
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    <table class="datatable-init-export nowrap table" data-export-title="Export">
                        <thead>
                            <tr>
                                <th>Consumer Name</th>
                                <th>Reporting Month</th>
                                <th>Current Reading</th>
                                <th>Total Amount</th>
                                
                                <th>Action</th>
                                
                            </tr>
                        </thead>
                        @foreach ($bills as $bill)
                            
                        <tbody>
                            <tr>
                                <td>{{ucwords($bill->consumer->consumer_name)}}</td>
                                <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $bill->reporting_month)->format('Y - F') }}</td>
                                <td><b>{{$bill->current_reading}}</b></td> 
                                <td><b>₹ {{$bill->current_bill_amount}}</b></td> 
                                <td>
                                    <a href="{{ route('billings.view', ['id' => $bill->id, 'consumer_id' => $bill->consumer_id]) }}">Print bill</a>
                                </td>
                                
                            </tr>
                        </tbody>
                        @endforeach
                    </table>
                </div>
            </div><!-- .card-preview -->
        </div><!-- .card -->
    </div><!-- .nk-block -->
</div>
<!-- Modal -->
<div class="modal fade" id="generateBillingModal" tabindex="-1" aria-labelledby="generateBillingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="generateBillingModalLabel">Generate Billing</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!-- Form inside the modal -->
          <form action="{{route('billings.store')}}" method="POST">
            @csrf
            
            <!-- Users List Dropdown -->
            <div class="mb-3">
                <label for="user_id" class="form-label">Select User</label><span class="text-danger">*</span>
                <select name="user_id" id="user_id" class="form-select select2" required>
                    <option value="">Choose a consumer...</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->consumer_name }}</option>
                    @endforeach
                </select>
            </div>
            
  
            <!-- Date Picker for Bill Date -->
            <div class="mb-3">
              <label for="bill_date" class="form-label">Bill Date</label><span class="text-danger">*</span>
              <input type="date" class="form-control" name="bill_date" id="bill_date" value="{{ date('Y-m-d') }}" required>
            </div>
  
            <!-- Current Reading Input -->
            <div class="mb-3">
              <label for="current_reading" class="form-label">Current Reading</label><span class="text-danger">*</span>
              <input type="number" class="form-control" name="current_reading" id="current_reading" placeholder="Enter current reading" required>
            </div>
  
            <!-- Tariff Input (Optional) -->
            <div class="mb-3">
              <label for="tariff_dg" class="form-label">Remarks(if any)</label>
              <input type="text" step="any" class="form-control" name="remarks" id="remarks" placeholder="Enter remarks">
            </div>
            <!-- Tariff Input (Optional) -->
            <div class="mb-3">
              <label for="tariff_dg" class="form-label">Tarrif DG (if any)</label>
              <input type="number" step="any" class="form-control" name="tariff_dg" id="tariff_dg" placeholder="Enter Tariff DG">
            </div>
  
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Generate Bill</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  
{{-- <script type="text/javascript">
    function confirmDelete(consumerId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + consumerId).submit();
            }
        });
    }
</script> --}}


@endsection 