@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant')}}">Tenants</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant/manage/'.___encrypt($tenant->id))}}">{{$tenant->name}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Menu Group Management</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">{{$tenant->name}} - Menu Group Management</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
       

    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="role_list" class="table table-hover mb-0">
                        <thead>

                            <th>Menu Group Name</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </thead>
                        <tbody>
                            @php 
                                $cnt = count($tenant['tenant_config']['menu_group'])
                            @endphp
                            @if(!empty($tenant['tenant_config']['menu_group']))
                            @php
                            $menu_group = $tenant['tenant_config']['menu_group'];
                            @endphp
                            <tr>

                                <td>{{$menu_group['name']}}</td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" data-url="{{url('/admin/tenant/'.___encrypt($tenant->id).'/role/'.___encrypt($menu_group['id']).'?status='.$menu_group['status'])}}" data-method="DELETE" data-request="ajax-confirm" data-ask="Are you sure you want to change Status?" data-ask_image="warning" id="customSwitch{{___encrypt($menu_group['id'])}}" @if($menu_group['status']=='pending' ) disabled @endif @if($menu_group['status']=='active' ) checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{___encrypt($menu_group['id'])}}"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <!-- <a href="{{ url('/admin/tenant/view')}}" class="btn btn-sm btn-info text-white btn-icon-text" data-toggle="tooltip" data-placement="bottom" title="View Role">
                                        <i class="fas fa-eye"></i>
                                    </a> -->
                                    <a href="{{url('/admin/tenant/'.___encrypt($tenant->id).'/role/'.___encrypt($menu_group['id']).'/edit')}}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Role">
                                        <i class="fas fa-edit text-secondary"></i>
                                    </a>
                                    <!-- <a href="javascript:void(0);" data-url="{{url('admin/tenant/'.___encrypt($tenant->id).'/role/'.___encrypt($menu_group['id']))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete Role">
                                        <i class="fas fa-trash text-secondry"></i>
                                    </a> -->
                                </td>
                            </tr>

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
        if(cnt>10){
        $('#role_list').DataTable();
        }
    });
</script>
@endpush