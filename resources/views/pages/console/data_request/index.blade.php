@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Request</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Data Request</h4>
    </div>

</div>
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                <table id="list" class="table table-hover mb-0">
                        <thead>
                            <th>Data Request Name</th>
                            <th>Updated On</th>
                            <th class="text-center">Actions</th>
                        </thead>
                        <tbody>
                            @php
                            $cnt = 0;
                            @endphp
                            @if(!empty($data_requests))
                            @php
                            $cnt = count($data_requests)
                            @endphp
                            @foreach($data_requests as $data_request)
                            <tr>
                                <td>{{$data_request->name}}</td>
                                <td>
                                {{$data_request->updated_at}}
                                   
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <!-- <a class="btn btn-icon" href="{{url('/admin/data_request/'.___encrypt($data_request->id))}}" data-toggle="tooltip" data-placement="bottom" title="View Tenant">
                                            <i class="fas fa-eye text-secondary"></i>
                                        </a> -->
                                        <a class="btn btn-icon" href="{{url('data_request/'.___encrypt($data_request->id).'/download_csv')}}" data-toggle="tooltip" data-placement="bottom" title="Download .csv">
                                            <i class="fas fa-download text-secondary"></i>
                                        </a>
                                        <!-- <a class="btn btn-icon" href="{{url('admin/data_request/'.___encrypt($data_request->id).'/edit')}}" data-toggle="tooltip" data-placement="bottom" title="Edit Tenant">
                                            <i class="fas fa-edit text-secondary"></i>
                                        </a>
                                        <a class="btn btn-icon" href="javascript:void(0);" data-url="{{url('admin/data_request/'.___encrypt($data_request->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger text-white btn-icon-text" data-toggle="tooltip" data-placement="bottom" title="Delete Data Request">
                                            <i class="fas fa-trash text-secondary"></i>
                                        </a> -->
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    var cnt = '{{$cnt}}'
    $(function() {
        if (cnt > 10) {
            $('#list').DataTable();
        }
    });

</script>
@endpush