@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant/manage/'.$tenant_id)}}">{{get_tenant_name($tenant_id)}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Database Backups</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Database Backups</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a href="{{url('/admin/tenant/'.$tenant_id.'/backup/create')}}" class="btn btn-sm btn-secondary btn-icon-text mb-2 mb-md-0">
            <i class="btn-icon-prepend" data-feather="plus"></i>
            Database Backup Configuration
        </a>
    </div>
</div>
<div class="row">
    <div class="col-12 col-12 stretch-card mb-3">
        <div class="card shadow">
            <!-- <div class="card-header">
                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div></div>
                    <div class="btn-group mb-3 mb-md-0" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-sm btn-secondary">Today</button>
                        <button type="button" class="btn btn-secondary d-none d-md-block">Week</button>
                        <button type="button" class="btn btn-sm btn-secondary">Month</button>
                        <button type="button" class="btn btn-sm btn-secondary">Year</button>
                    </div>
                </div>
            </div> -->
            <div class="card-body">
                <div class="table-responsive">
                    <table id="db_backup_list" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Backup Initialization Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                                <td>
                                    <span class="badge badge-pill badge-success">Success</span>
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete Database Backup">
                                        <i class="fas fa-trash text-secondry"></i>
                                    </button>
                                </td>
                            </tr>
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
    var cnt = 1
    $(function() {
        if(cnt>10){
        $('#db_backup_list').DataTable();
        }
    });
</script>
@endpush