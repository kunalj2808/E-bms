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
                        <a href="#" class="btn btn-icon btn-trigger toggle-expand me-n1" data-bs-target="pageMenu"><em
                                class="icon ni ni-menu-alt-r"></em></a>
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#generateBillingModal">
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

        @if (session('error'))
            <!-- Handle custom error messages -->
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <!-- Handle validation errors -->
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
                                    <th>Flat Number</th>
                                    <th>Reporting Month</th>
                                    <th>Current Reading</th>
                                    <th>Total Amount</th>
                                    <th class="noExport">Action</th>
                                    <th class="noExport">Print</th>

                                </tr>
                            </thead>
                            <tbody>
                                    @foreach ($bills as $bill)
                                    <tr>
                                        <td>{{ ucwords($bill->consumer->consumer_name) }}</td>
                                        <td>{{ ucwords($bill->consumer->flat_number) }}</td>
                                        <td>{{ \Carbon\Carbon::createFromFormat('Y-m', $bill->reporting_month)->format('Y - F') }}
                                        </td>
                                        <td><b>{{ $bill->current_reading }}</b></td>
                                        <td>
                                            <b>₹ {{ 
                                                max(0, $bill->current_bill_amount - ($bill->payment->received_amount ?? 0)) 
                                            }}</b>
                                        </td>
                                                                                <td>
                                            {{-- <a onclick="confirmDelete({{ $bill->id }})" class="btn btn-dim btn-sm btn-primary">View</a> --}}
                                            <form action="{{ route('billings.destroy', $bill->id) }}" method="POST" style="display:inline;" id="delete-form-{{ $bill->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <a class="btn btn-dim btn-sm btn-danger"  onclick="confirmDelete({{ $bill->id }})" >Remove</a>
                                            </form>
                                            <a class="btn btn-dim btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#payBillModal"
                                            data-total_amount="{{ max(0, $bill->current_bill_amount - ($bill->payment->received_amount ?? 0))}}" 
                                            data-consumer_name="{{ucwords($bill->consumer->consumer_name )}}" 
                                            data-id="{{ $bill->id }}" 
                                            data-meter_number="{{ $bill->consumer->meter_number }}" 
                                            data-flat_number="{{ $bill->consumer->flat_number }}">Pay Bill</a>
                                        </td>
                                        <td>
                                            <a class="btn btn-dim btn-sm btn-primary" target="_blank"
                                                href="{{ route('billings.view', ['id' => $bill->id, 'consumer_id' => $bill->consumer_id]) }}">Print
                                                bill</a>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                        </table>
                    </div>
                </div><!-- .card-preview -->
            </div><!-- .card -->
        </div><!-- .nk-block -->
    </div>
    <!-- Modal -->
    <div class="modal fade" id="generateBillingModal" tabindex="-1" aria-labelledby="generateBillingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="generateBillingModalLabel">Generate Billing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Form inside the modal -->
                    <form action="{{ route('billings.store') }}" method="POST">
                        @csrf

                        <!-- Users List Dropdown -->
                        <div class="mb-3">
                            <label for="user_id" class="form-label">Select User</label><span class="text-danger">*</span>
                            <select name="user_id" id="user_id" class="form-select js-select2" data-search="on"required>
                                <option value="">Choose a consumer...</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->consumer_name }}</option>
                                @endforeach
                            </select>
                        </div>


                        <!-- Date Picker for Bill Date -->
                        <div class="mb-3">
                            <label for="bill_date" class="form-label">Bill Date</label><span class="text-danger">*</span>
                            <input type="date" class="form-control" name="bill_date" id="bill_date"
                                value="{{ date('Y-m-d') }}" required>
                        </div>

                        <!-- Current Reading Input -->
                        <div class="mb-3">
                            <label for="current_reading" class="form-label">Current Reading</label><span
                                class="text-danger">*</span>
                            <input type="number" class="form-control" name="current_reading" id="current_reading"
                                placeholder="Enter current reading" required>
                        </div>
                         <!-- Tariff Input (Optional) -->
                         <div class="mb-3">
                            <label for="tariff_dg" class="form-label">Tarrif DG</label><span
                            class="text-danger">*</span>
                            <input type="number" step="any" value="0" class="form-control" name="tariff_dg" id="tariff_dg"
                                placeholder="Enter Tariff DG" required>
                        </div>
                         <!-- Tariff Input (Optional) -->
                         <div class="mb-3">
                            <label for="discount_deposite_amount" class="form-label">Deposite Amount</label><span
                            class="text-danger">*</span>
                            <input type="number" step="any" value="0" class="form-control" name="discount_deposite_amount" id="discount_deposite_amount"
                                placeholder="Enter Deposite Amount" required>
                        </div>

                        <!-- Remark Input (Optional) -->
                        <div class="mb-3">
                            <label for="tariff_dg" class="form-label">Remarks(if any)</label>
                            <input type="text" step="any" class="form-control" name="remarks" id="remarks"
                                placeholder="Enter remarks">
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

    <!-- pay model -->
    <!-- Modal Structure -->
<div class="modal fade" id="payBillModal" tabindex="-1" role="dialog" aria-labelledby="payBillModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="payBillModalLabel">Pay Bill for <span id="modalConsumerName"></span><br> Meter No: <span id="modalMeterNumber"></span> - Flat No: <span id="modalFlatNumber"></span></h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('billings.pay') }}" method="POST">
            @csrf
        <div class="modal-body">
            <input type="hidden" id="bill_id" name="bill_id" value="">
            <!-- Non-editable Total Amount -->
            <div class="form-group">
              <label for="totalAmount">Total Amount</label>
              <input type="text" class="form-control" id="totalAmount" value="" readonly>
            </div>
            <!-- Editable Amount to Pay -->
            <div class="form-group">
              <label for="amountToPay">Amount to Pay</label>
              <input type="number" class="form-control" id="amountToPay" step="any" name="pay_amount" placeholder="Enter amount to pay">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Proceed to Pay</button>
        </div>
    </form>
    </div>
    </div>
  </div>

    <script type="text/javascript">
    function confirmDelete(billId) {
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
                document.getElementById('delete-form-' + billId).submit();
            }
        });
    }

       // Get the modal element
    var payBillModal = document.getElementById('payBillModal');

// Event listener when the modal is triggered to open
payBillModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget; // Button that triggered the modal

    // Extract info from data-* attributes
    var totalAmount = button.getAttribute('data-total_amount');
    var consumerName = button.getAttribute('data-consumer_name');
    var meterNumber = button.getAttribute('data-meter_number');
    var flatNumber = button.getAttribute('data-flat_number');
    var Id = button.getAttribute('data-id');

    // Update modal header and input fields with extracted values
    document.getElementById('modalConsumerName').textContent = consumerName;
    document.getElementById('modalMeterNumber').textContent = meterNumber;
    document.getElementById('modalFlatNumber').textContent = flatNumber;
    document.getElementById('totalAmount').value = totalAmount; // Non-editable total amount
    document.getElementById('bill_id').value = Id; // Non-editable total amount
});

</script>


@endsection
