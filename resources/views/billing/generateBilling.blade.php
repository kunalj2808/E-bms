@extends('layouts.app')

@section('content')

<div class="nk-content-body">
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Consumers Lists</h3>
               
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
    <div class="nk-block">
        <div class="card card-bordered card-stretch">
            <div class="card card-bordered card-preview">
                <div class="card-inner">
                    {{-- <table class="datatable-init-export nowrap table" data-export-title="Export">
                        <thead>
                            <tr>
                                <th>Consumer Name</th>
                                <th>Flate Number</th>
                                <th>Meter Number</th>
                                <th>Address</th>
                                <th>Supply_at</th>
                                <th>Created on</th>
                                <th>Action</th>
                                
                            </tr>
                        </thead>
                        @foreach ($consumers as $user)
                            
                        <tbody>
                            <tr>
                                <td>{{$user->consumer_name}}</td>
                                <td>{{$user->flat_number}}</td>
                                <td>{{$user->meter_number}}</td>
                                <td>{{$user->mailing_address}}</td>
                                <td>{{$user->supply_at}}</td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td class="tb-tnx-action">
                                    <div class="dropdown">
                                        <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                            <ul class="link-list-plain">
                                                <li><a href="{{ route('consumers.edit', $user->id) }}">Edit</a></li>
                                               <!-- Delete consumer link with a confirmation -->
                                                <form action="{{ route('consumers.destroy', $user->id) }}" method="POST" style="display:inline;" id="delete-form-{{ $user->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <a  onclick="confirmDelete({{ $user->id }})" class="text-danger">Remove</a>
                                                </form>

                                            </ul>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        @endforeach
                    </table> --}}
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
                <label for="user_id" class="form-label">Select User</label>
                <select name="user_id" id="user_id" class="form-select select2" required>
                    <option value="">Choose a consumer...</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->consumer_name }}</option>
                    @endforeach
                </select>
            </div>
            
  
            <!-- Date Picker for Bill Date -->
            <div class="mb-3">
              <label for="bill_date" class="form-label">Bill Date</label>
              <input type="date" class="form-control" name="bill_date" id="bill_date" value="{{ date('Y-m-d') }}" required>
            </div>
  
            <!-- Current Reading Input -->
            <div class="mb-3">
              <label for="current_reading" class="form-label">Current Reading</label>
              <input type="number" class="form-control" name="current_reading" id="current_reading" placeholder="Enter current reading" required>
            </div>
  
            <!-- Discount Input (Optional) -->
            <div class="mb-3">
              <label for="discount" class="form-label">Discount (if any)</label>
              <input type="number" step="any" class="form-control" name="discount" id="discount" placeholder="Enter discount">
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