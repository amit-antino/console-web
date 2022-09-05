@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/organization/settings')}}">Tenants</a></li>
        <li class="breadcrumb-item"><a href="{{url('/organization/backup')}}">Database Backups</a></li>
        <li class="breadcrumb-item active" aria-current="page">Database Backup Configuration</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 stretch-card mb-3">
        <div class="card shadow">
            <form action="{{url('/organization/backup/store')}}" method="POST">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Database Backup Configuration</h4>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="employee_list">Select Employees
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Employees who requries database backup notifications"></i></span>
                            </label>
                            <select name="employee_list" id="employee_list" class="js-example-basic-multiple w-100" multiple="multiple">
                                <option value="">Select Employees</option>
                                <option value=""></option>
                                <option value=""></option>
                                <option value=""></option>
                                <option value=""></option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="time_period">Select Backup Period</label>
                            <select name="time_period" id="time_period" class="form-control">
                                <option value="">Select Backup Period</option>
                                <option value="Daily">Daily</option>
                                <option value="Weekly">Weekly</option>
                                <option value="Monthly">Monthly</option>
                                <option value="Quaterly">Quaterly</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-sm btn-secondary submit">Save</button>
                        <a href="{{url('/organization/backup')}}" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-12 stretch-card mb-3">
        <div class="card shadow">
            <div class="card-header">
                <h4 class="mb-3 mb-md-0">Database Backup Notification List</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="db_backup_notify" class="table table-hover mb-0">
                        <thead>
                            <th>Employee Name</th>
                            <th>Notification Frequency</th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(function() {
        $('#db_backup_notify').DataTable();

        if ($(".js-example-basic-multiple").length) {
            $(".js-example-basic-multiple").select2();
        }
    });
</script>
@endpush