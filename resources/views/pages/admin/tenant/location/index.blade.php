@extends('layout.admin.master')
@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant')}}">Tenants</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant/manage/'.___encrypt($data['tenant_info']['id']))}}">{{$data['tenant_info']['name']}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Location Management</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">{{$data['tenant_info']['name']}} - Location Management</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <!-- <button type="button" class="btn btn-sm btn-outline-info btn-icon-text mr-2 d-none d-md-block">
            <i class="btn-icon-prepend" data-feather="download"></i>
            Import
        </button> -->
        <a href="{{url('/admin/tenant/'.___encrypt($data['tenant_info']['tenant_id']).'/locations')}}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" data-toggle="modal" data-target="#exampleModal">
            <i class="btn-icon-prepend" data-feather="plus"></i>
            Add Location
        </a>
        
        <div class="deletebulk">
          
        <button type="button" data-url="{{url('/admin/tenant/'.___encrypt($data['tenant_info']['id']).'/locations/bulk-delete')}}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
            <i class="btn-icon-prepend" data-feather="trash"></i>
            Delete
        </button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="location_list" class="table table-hover mb-0">
                        <thead>
                            <th><input type="checkbox" id="example-select-all"></th>
                            <th>Location Name</th>
                            <th>City State</th>
                            <th>Country</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </thead>
                        <tbody>
                            @php 
                                $cnt = count($data['location'])
                            @endphp
                            @if(!empty($data['location']))
                            @foreach($data['location'] as $location)
                            <tr>
                                <td><input type="checkbox" value="{{___encrypt($location['id'])}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{$location['location_name']}}</td>
                                <td>{{$location['city']}} , {{$location['state']}}</td>
                                <td>{{$location['country_id']}}</td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" data-url="{{url('/admin/tenant/'.___encrypt($data['tenant_info']['id']).'/locations/'.___encrypt($location['id']).'?status='.$location['status'])}}" data-ask="Are you sure you want to change status?" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" id="customSwitch{{___encrypt($location['id'])}}" @if($location['status']=='pending') disabled @endif
                                        @if($location['status']=='active') checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{___encrypt($location['id'])}}"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    
                                    <a href="javascript:void(0);" data-target="#edit-div" data-tab="#locationeEditModal{{___encrypt($location['id'])}}" data-request="ajax-popup" data-url="{{url('/admin/tenant/'.___encrypt($data['tenant_info']['id']).'/locations/'.___encrypt($location['id']).'/edit')}}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Tenant Location">
                                        <i class="fas fa-edit text-secondry"></i>
                                    </a>
                                    <a href="javascript:void(0);" data-url="{{url('admin/tenant/'.___encrypt($data['tenant_info']['id']).'/locations/'.___encrypt($location['id']))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete Tenant Location">
                                        <i class="fas fa-trash text-secondry"></i>
                                    </a>
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
@include('pages.admin.tenant.location.create')
<div id="edit-div"></div>

@endsection

@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    var cnt = '{{$cnt}}'
    $(function() {
        if(cnt>10){
        $('#location_list').DataTable();
        }
    });
    $(".deletebulk").hide();
    $("#example-select-all").click(function() {
        if ($(this).is(":checked")) {
            $(".deletebulk").show();
        } else {
            $(".deletebulk").hide();
        }
        $('.checkSingle').not(this).prop('checked', this.checked);
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