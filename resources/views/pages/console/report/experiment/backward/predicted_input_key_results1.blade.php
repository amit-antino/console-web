<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="summary-tab" data-toggle="tab" href="#summary" role="tab" aria-controls="summary" aria-selected="true">Summary</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="detailed-tab" data-toggle="tab" href="#detailed" role="tab" aria-controls="detailed" aria-selected="false">Detailed</a>
    </li>
</ul>
<div class="tab-content border border-top-0 p-3" id="myTabContent">
    <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="summary-tab">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h6  class="mb-3 mb-md-0 text-uppercase font-weight-normal">Master Condition</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="process_experiment_reports" class="table table-hover mb-0">
                                <thead>
                                    <th>Condition Name</th>
                                    <th>Value </th>
                                    <th>Unit Type</th>
                                </thead>
                                <tbody>
                                    @if(!empty($data['key_results']['summary']))
                                    @foreach($data['key_results']['summary'] as $master_condition)
                                    <tr>
                                        <td>{{$master_condition['condition_name']}}</td>
                                        <td>{{$master_condition['value']}}</td>
                                        <td>{{$master_condition['unit_constants']['unit_constant_name']}}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="3">No record </td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="detailed" role="tabpanel" aria-labelledby="detailed-tab">
        <div class="card">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-header">
                        <h6 class="">Unit Condition</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @if(!empty($data['key_results']['detailed']))
                            @foreach($data['key_results']['detailed'] as $unit_condition)
                            <div class="col-md-12 mb-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h6  class="mb-3 mb-md-0 text-uppercase font-weight-normal">Experiment Unit Name: {{$unit_condition['experiment_unit_name']}}</h6>
                                    </div>
                                    <div class="card-body row">
                                        @if(!empty($unit_condition['conditions']))
                                        @foreach($unit_condition['conditions'] as $exp_outcome)
                                        <div class="col-md-3 grid-margin stretch-card">
                                            <div class="card border-left-secondary shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                                                <small>Condition Name<br></small>{{$exp_outcome['conditions']}}
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <h6  class="mb-3 mb-md-0 text-uppercase font-weight-normal">Value: <span class="badge badge-secondary">{{$exp_outcome['value']}}
                                                                    {{$exp_outcome['unit_constants']['unit_constant_name']}}</span>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="col-md-3 grid-margin stretch-card">
                                            <h6  class="mb-3 mb-md-0 text-uppercase font-weight-normal">No record </h6>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-header">
                            <h6  class="mb-3 mb-md-0 text-uppercase font-weight-normal">Stream Details</h6>
                        </div>
                        <div class="card-body row">
                            @if(!empty($data['key_results']['stream']))
                            @foreach($data['key_results']['stream'] as $stream_info)
                            <div class="col-md-12 mb-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h6  class="mb-3 mb-md-0 text-uppercase font-weight-normal">Stream Name: <span class="badge badge-info">{{$stream_info['process_diagram_name']}}</span></h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="process_experiment_reports" class="table table-hover mb-0">
                                                <thead>
                                                    <th>Product</th>
                                                    <th>Value</th>
                                                </thead>
                                                <tbody>
                                                    @if(!empty($stream_info['mass_flow_rate_info']))
                                                    @foreach($stream_info['mass_flow_rate_info'] as $k=>$v)
                                                    <tr>
                                                        <td>{{$v['product']}}</td>
                                                        <td>{{$v['value']}}</td>
                                                    </tr>
                                                    @endforeach
                                                    @else
                                                    <tr>
                                                        <td colspan="2" class="text-center">No Record </td>
                                                    </tr>
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-3 grid-margin stretch-card">
                    <div class="card shadow">
                        <div class="card-header">
                            <h6  class="mb-3 mb-md-0 text-uppercase font-weight-normal">Simulation Statistics</h6>
                        </div>
                        <div class="card-body">
                            <h5 class="mr-2">Execution Time:
                                <span class="badge badge-secondary">
                                    {{ round($data['key_results']['execution_time']['value'], 5) }} {{$data['key_results']['execution_time']['unit_constants']['unit_name']}}
                                    <i class="fas fa-stopwatch"></i>
                                </span>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
