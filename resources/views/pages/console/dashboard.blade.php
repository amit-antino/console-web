@extends('layout.console.master')

@section('content')
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Dashboard</h5>
    </div>
</div>

<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="card-columns">
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-3 mb-md-0 text-uppercase font-weight-normal">
                                <small>Products<br></small>Pure - {{$pure_product_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-flask fa-2x text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-3 mb-md-0 text-uppercase font-weight-normal">
                                <small>Products<br></small>Simulated - {{$simulated_product_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-flask fa-2x text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-3 mb-md-0 text-uppercase font-weight-normal">
                                <small>Products<br></small>Generic - {{$generic_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-flask fa-2x text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-3 mb-md-0 text-uppercase font-weight-normal">
                                <small>Products<br></small>Overall - {{$overall_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-flask fa-2x text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                <small>Total<br></small>Process Simulations - {{$processSimulation_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-brain fa-2x text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                <small>Total<br></small>Product Systems - {{$productSystem_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bullseye fa-2x text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-3 mb-md-0 text-uppercase font-weight-normal">
                                <small>Total<br></small>Experiments - {{$processExperiment_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-atom fa-2x text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 mb-3 mb-md-0 text-uppercase font-weight-normal">
                                <small>Total<br></small>Experiment Reports - {{$experiment_report_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="link-icon text-secondary text-gray-300" data-feather="printer"></i>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                <small>Total<br></small>Regulatory Lists - {{$regulatory_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-check fa-2x text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                <small>Total<br></small>Experiment Reports - {{$experiment_report_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="link-icon text-secondary text-gray-300" data-feather="printer"></i>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                <small>Total<br></small>Process Simulation Reports - {{$process_analysis_report_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="link-icon text-secondary text-gray-300" data-feather="printer"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                <small>Total<br></small>Process Simulation Comparison Reports - {{$process_comparison_report_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="link-icon text-secondary text-gray-300" data-feather="printer"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                <small>Total<br></small>Product System Reports - {{$product_system_report_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="link-icon text-secondary text-gray-300" data-feather="printer"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
    </div>
</div>
@endsection

@push('plugin-scripts')
@endpush

@push('custom-scripts')
@endpush