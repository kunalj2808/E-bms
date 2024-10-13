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
                    <a href="{{route('consumers.create')}}" class="btn btn-primary"><em class="icon ni ni-plus"></em>Add Consumer</a>
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
                    <table class="datatable-init-export nowrap table" data-export-title="Export">
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
                    </table>
                </div>
            </div><!-- .card-preview -->
        </div><!-- .card -->
    </div><!-- .nk-block -->
</div>

<script type="text/javascript">
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
</script>


@endsection 