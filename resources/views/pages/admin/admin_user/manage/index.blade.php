@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/admin_users')}}">Admin User</a></li>
        <li class="breadcrumb-item active">Permission Management</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Permission Management</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a href="{{ url('/admin/admin_users/'.___encrypt($user_id).'/manage/create') }}" class="btn btn-sm btn-secondary btn-icon-text mb-2 mb-md-0">
            <i class="btn-icon-prepend" data-feather="user-plus"></i>
            Add Permission
        </a>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="permission_list" class="table table-hover mb-0">
                        <thead>
                            <th>Roles</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </thead>
                        <tbody>
                            @php 
                                $cnt = count($roles)
                            @endphp
                            @if(!empty($roles))
                            @foreach($roles as $user)
                            <tr>
                                <td>{{$user['user_details']['first_name']}} {{$user['user_details']['last_name']}}</td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" data-url="{{url('admin/admin_users/'.___encrypt($user_id).'/manage/'.___encrypt($user['id']).'?status='.$user['status'])}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" class="custom-control-input" id="customSwitch{{___encrypt($user['id'])}}" @if($user['status']=='active' ) checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{___encrypt($user['id'])}}"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        
                                            <a href="{{ url('admin/admin_users/'.___encrypt($user_id).'/manage/'.___encrypt($user['id']).'/edit')}}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Profile">
                                                <i class="fa fa-edit text-secondary"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-url="{{ url('admin/admin_users/'.___encrypt($user_id).'/manage/'.___encrypt($user['id']))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete Employee">
                                                <i class="fas fa-trash  text-secondary"></i>
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
        if(cnt>10){
        $('#permission_list').DataTable();
        }
    });
</script>
@endpush