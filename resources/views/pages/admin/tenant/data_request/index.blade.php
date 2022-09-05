@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item" ><a href="{{url('/admin/tenant')}}">Tenants</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant/manage/'.$tenant_id)}}">{{get_tenant_name($tenant_id)}} Manage</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Request</li>       
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Data Request</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a href="{{ url('/admin/tenant/'.$tenant_id.'/data_request/create') }}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
            <i class="btn-icon-prepend" data-feather="plus"></i>
            Add Data Request
        </a>
        <button type="button" data-url="{{url('/admin/tenant/'.$tenant_id.'/data_request/bulk-delete')}}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0 deletebulk">
            <i class="btn-icon-prepend" data-feather="trash"></i>
            Delete
        </button>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="list" class="table table-hover mb-0">
                        <thead>
                            <th><input type="checkbox" id="example-select-all"></th>
                            <th>Data Request Name</th>
                            <th>Status</th>
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
                                <td><input type="checkbox" value="{{___encrypt($data_request->id)}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{$data_request->name}}</td>
                                <td>
                                    <form action="/admin/data_request/status" method="post">
                                        <input type="hidden" name="data_request_id" value="">
                                        <select data-url="{{url('/admin/tenant/'.$tenant_id.'/data_request/'.___encrypt($data_request->id)) }}" data-method="DELETE" data-request="ajax-confirm-onchange" data-ask_image="warning" name="status{{___encrypt($data_request->id)}}" id="status{{___encrypt($data_request->id)}}" >
                                            <option value="Draft" @if($data_request['status']=='Draft') selected @endif>Draft</option>
                                            <option value="Requested" @if($data_request['status']=='Requested') selected @endif>Requested</option>
                                            <option value="Under Review" @if($data_request['status']=='Under Review') selected @endif>Under Review</option>
                                            <option value="Published" @if($data_request['status']=='Published') selected @endif>Published</option>
                                        </select>
                                    </form>
                                   
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <!-- <a class="btn btn-icon" href="{{url('/admin/data_request/'.___encrypt($data_request->id))}}" data-toggle="tooltip" data-placement="bottom" title="View Tenant">
                                            <i class="fas fa-eye text-secondary"></i>
                                        </a> -->
                                        <a class="btn btn-icon" href="{{url('admin/tenant/'.$tenant_id.'/data_request/'.___encrypt($data_request->id).'/download_csv')}}" data-toggle="tooltip" data-placement="bottom" title="Download .csv">
                                            <i class="fas fa-download text-secondary"></i>
                                        </a>
                                        <a class="btn btn-icon" href="{{url('admin/tenant/'.$tenant_id.'/data_request/'.___encrypt($data_request->id).'/edit')}}" data-toggle="tooltip" data-placement="bottom" title="Edit Data Request">
                                            <i class="fas fa-edit text-secondary"></i>
                                        </a>
                                        <a class="btn btn-icon" href="javascript:void(0);" data-url="{{url('admin/tenant/'.$tenant_id.'/data_request/'.___encrypt($data_request->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger text-white btn-icon-text" data-toggle="tooltip" data-placement="bottom" title="Delete Data Request">
                                            <i class="fas fa-trash text-secondary"></i>
                                        </a>
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
    $(".deletebulk").hide();
    $("#example-select-all").click(function() {
        $('.checkSingle').not(this).prop('checked', this.checked);
        var len = $("[name='select_all[]']:checked").length;
        if (len > 1) {
            $(".deletebulk").show();
        } else {
            $(".deletebulk").hide();
        }
    });

    $('.checkSingle').click(function() {
        if ($('.checkSingle:checked').length == $('.checkSingle').length) {
            $('#example-select-all').prop('checked', true);
        } else {
            $('#example-select-all').prop('checked', false);
        }
        var len = $("[name='select_all[]']:checked").length;
        if (len > 1) {
            $(".deletebulk").show();
        } else {
            $(".deletebulk").hide();
        }
    });
</script>
@endpush