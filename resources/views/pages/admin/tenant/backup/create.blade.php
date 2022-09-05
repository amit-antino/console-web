@extends('layout.admin.master')

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
    @if($errors->any())
    <h4>{{$errors->first()}}</h4>
    @endif
    <div class="col-md-12 stretch-card mb-3">
        <div class="card shadow">
            <form action="{{url('admin/tenant/'.$tenant_id.'/backup')}}" role="backup" method="POST">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Database Backup Configuration</h4>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-8">
                            <label for="">Custom Frequency</label>
                            <div class="row">
                                <div class="col">
                                    <span class="input-group-text">Minute</span>
                                    <input type="number" name="minute" min="0" max="60" aria-label="Minute" class="form-control">
                                </div>
                                <div class="col">
                                    <span class="input-group-text">Hour</span>
                                    <input type="number" name="hour" min="0" max="12" aria-label="Hour" class="form-control">
                                </div>
                                <div class="col">
                                    <span class="input-group-text">Day - Month</span>
                                    <input type="number" name="day" min="0" max="30" aria-label="Day - Month" class="form-control">
                                </div>
                                <div class="col">
                                    <span class="input-group-text">Month</span>
                                    <input type="number" name="month" min="0" max="12" aria-label="Month" class="form-control">
                                </div>
                                <div class="col">
                                    <span class="input-group-text">Day - Week</span>
                                    <input type="number" name="day_week" min="0" max="12" aria-label="Day - Week" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="backup_period">Select Backup Period</label>
                            <select name="backup_period" id="backup_period" class="form-control">
                                <option value="">Select Backup Period</option>
                                <option value="hourly">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                                <option value="Quaterly">Quaterly</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="backup"]' class="btn btn-sm btn-secondary submit">Save</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{url('admin/tenant/'.$tenant_id)}}" class="btn btn-sm btn-danger">Cancel</a>
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
                            <tr>
                                <th>Notification Frequency</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($backups))
                            @foreach($backups as $backup)
                            <tr>
                                <td>{{$backup->backup_period}}</td>
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