@extends('layout.admin.master')

@push('plugin-styles')

@endpush

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Dashboard</h5>
    </div>
</div>

<div class="card-columns">
    <div class="card border-left-secondary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-3 mb-md-0 text-uppercase font-weight-normal">
                        <small>Total<br></small> Tenants - {{$tenant_count}}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-hotel fa-2x text-secondary text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-left-secondary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-3 mb-md-0 text-uppercase font-weight-normal">
                        <small>Total<br></small> Users - {{$user_count}}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-users fa-2x text-secondary text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-left-secondary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-3 mb-md-0 text-uppercase font-weight-normal">
                        <small>Total Products<br></small>Pure - {{$pure_product_count}}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-flask fa-2x text-secondary text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-left-secondary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-3 mb-md-0 text-uppercase font-weight-normal">
                        <small>Total Products<br></small>Simulated - {{$simulated_product_count}}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-flask fa-2x text-secondary text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-left-secondary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-3 mb-md-0 text-uppercase font-weight-normal">
                        <small>Total Products<br></small>Generic - {{$generic_count}}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-flask fa-2x text-secondary text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-left-secondary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-3 mb-md-0 text-uppercase font-weight-normal">
                        <small>Total Products<br></small>Overall - {{$overall_count}}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-flask fa-2x text-secondary text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-left-secondary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-3 mb-md-0 text-uppercase font-weight-normal">
                        <small>Total<br></small> Process Simulations - {{$process_simulation_count}}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-brain fa-2x text-secondary text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-left-secondary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-3 mb-md-0 text-uppercase font-weight-normal">
                        <small>Total<br></small> Product Systems - {{$product_system_count}}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-tasks fa-2x text-secondary text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-left-secondary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-3 mb-md-0 text-uppercase font-weight-normal">
                        <small>Total<br></small> Experiments - {{$experiment_count}}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-vials fa-2x text-secondary text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-left-secondary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-3 mb-md-0 text-uppercase font-weight-normal">
                        <small>Total<br></small> Reactions - {{$rection_count}}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-atom fa-2x text-secondary text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-left-secondary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-3 mb-md-0 text-uppercase font-weight-normal">
                        <small>Total<br></small> Models - {{$models_count}}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-file-code fa-2x text-secondary text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-left-secondary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-3 mb-md-0 text-uppercase font-weight-normal">
                        <small>Total<br></small> Experiment Reports - {{$experiment_report_count}}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="link-icon text-secondary text-gray-300" data-feather="printer"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-left-secondary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-3 mb-md-0 text-uppercase font-weight-normal">
                        <small>Total<br></small>Process Simulation Reports - {{$process_analysis_report_count}}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="link-icon text-secondary text-gray-300" data-feather="printer"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-left-secondary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-3 mb-md-0 text-uppercase font-weight-normal">
                        <small>Total<br></small>Process Simulation Comparison Reports - {{$process_comparison_report_count}}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="link-icon text-secondary text-gray-300" data-feather="printer"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-left-secondary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-3 mb-md-0 text-uppercase font-weight-normal">
                        <small>Total<br></small>Product System Reports - {{$product_system_report_count}}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="link-icon text-secondary text-gray-300" data-feather="printer"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-left-secondary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="h5 mb-3 mb-md-0 text-uppercase font-weight-normal">
                        <small>Total<br></small>Product System Comparison Reports - {{$product_system_cmp_report_count}}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="link-icon text-secondary text-gray-300" data-feather="printer"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')

@endpush

@push('custom-scripts')
<script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endpush