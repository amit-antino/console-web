@extends('layout.admin.master')

@push('plugin-styles')
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/tenant') }}">Tenants</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/tenant/manage/'.$tenant_id) }}">{{get_tenant_name($tenant_id)}} Manage</a></li>
        <li class="breadcrumb-item active" aria-current="page">Experiment </li>
    </ol>
</nav>
<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="card-columns">
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Unit Images - {{$unit_image_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marked fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ url('/admin/tenant/'.$tenant_id.'/experiment/unit_image') }}" data-toggle="tooltip" data-placement="bottom" title="Manage Unit Image" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Condition Master - {{$condition_master_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marked fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ url('/admin/tenant/'.$tenant_id.'/experiment/condition') }}" data-toggle="tooltip" data-placement="bottom" title="Manage Condition Master" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Outcome Master - {{$outcome_master_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marked fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ url('/admin/tenant/'.$tenant_id.'/experiment/outcome') }}" data-toggle="tooltip" data-placement="bottom" title="Manage Outcome Master" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="card-columns">
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Equipment Unit - {{$equipment_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marked fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ url('/admin/tenant/'.$tenant_id.'/experiment/equipment_unit') }}" data-toggle="tooltip" data-placement="bottom" title="Manage Equipment Unit" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Models - {{$model_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marked fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ url('/admin/tenant/'.$tenant_id.'/experiment/models') }}" data-toggle="tooltip" data-placement="bottom" title="Manage Model" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Priority - {{$priority_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marked fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ url('/admin/tenant/'.$tenant_id.'/experiment/priority') }}" data-toggle="tooltip" data-placement="bottom" title="Manage Equipment Unit" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="card-columns">
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Criteria - {{$criteria_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marked fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ url('/admin/tenant/'.$tenant_id.'/experiment/criteria') }}" data-toggle="tooltip" data-placement="bottom" title="Manage Criteria" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Classification - {{$classification_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marked fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ url('/admin/tenant/'.$tenant_id.'/experiment/classification') }}" data-toggle="tooltip" data-placement="bottom" title="Manage Classification" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Category - {{$category_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marked fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ url('/admin/tenant/'.$tenant_id.'/experiment/category') }}" data-toggle="tooltip" data-placement="bottom" title="Manage Category" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="card-columns">
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Models - {{ $model_count }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ url('admin/tenant/'.$tenant_id.'/experiment/models') }}" data-toggle="tooltip" data-placement="bottom" title="Manage" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Dataset - {{ $dataset_count }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ url('admin/tenant/'.$tenant_id.'/experiment/dataset') }}" data-toggle="tooltip" data-placement="bottom" title="Manage" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Data/Model Request - {{ $data_request_count }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ url('admin/tenant/'.$tenant_id.'/experiment/dataset_request') }}" data-toggle="tooltip" data-placement="bottom" title="Manage" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
@endpush

@push('custom-scripts')
<script>

</script>
@endpush