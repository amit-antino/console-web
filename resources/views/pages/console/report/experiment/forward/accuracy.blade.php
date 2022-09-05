
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active font-weight-normal text-uppercase" id="summary-tab" data-toggle="tab" href="#summary" role="tab" aria-controls="summary" aria-selected="true">Summary</a>
                    </li>
                    @if(!empty($data['accuracy']['detailed']['unit_outcomes']))
                    <li class="nav-item">
                        <a class="nav-link font-weight-normal text-uppercase" id="detailed-tab" data-toggle="tab" href="#detailed" role="tab" aria-controls="detailed" aria-selected="false">Detailed</a>
                    </li>
                    @endif
                </ul>
                <div class="tab-content border border-top-0 p-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="summary-tab">
                        <div class="row">
                            @if(!empty($data['accuracy']['summary']['master_outcomes']))
                            <div class="col-md-12 mb-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="text-uppercase font-weight-normal">Accuracy of Master Outcomes</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="process_experiment_reports" class="table table-hover mb-0">
                                                <thead>
                                                    <th>Outcome Name</th>
                                                    <th>Value and Unit</th>
                                                </thead>
                                                <tbody>
                                                    @foreach($data['accuracy']['summary']['master_outcomes'] as $outcome)
                                                    <tr>
                                                        <td>{{$outcome['outcome_name']}}</td>
                                                        <td>{{$outcome['value']}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @if(!empty($data['accuracy']['detailed']['unit_outcomes']))
                    <div class="tab-pane fade" id="detailed" role="tabpanel" aria-labelledby="detailed-tab">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="text-uppercase font-weight-normal">Unit Outcomes</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach($data['unit_outcomes'] as $key=>$val)
                                            <div class="col-md-12 mb-3">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h6 class="text-uppercase font-weight-normal">Experiment Unit Name: {{$val['exp_unit_name']}}</h6>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table id="process_experiment_reports" class="table table-hover mb-0">
                                                                <thead>
                                                                    <th>Outcome Name</th>
                                                                    <th>Minimum</th>
                                                                    <th>Maximum</th>
                                                                    <th>Mean</th>
                                                                    <th>STD</th>
                                                                    <th>Accuracy (&#37;)</th>
                                                                    <th>Mean Absolute Error</th>
                                                                    <th>RMSE</th>
                                                                </thead>
                                                                <tbody>
                                                                    @if(!empty($val['exp_outcome']))
                                                                    @foreach($val['exp_outcome'] as $exp_outcome_key => $exp_outcome)
                                                                    <tr>
                                                                        <td>{{$exp_outcome['outcome_name']}}</td>
                                                                        <td>{{$exp_outcome['min']}}</td>
                                                                        <td>{{$exp_outcome['max']}}</td>
                                                                        <td>{{$exp_outcome['mean']}}</td>
                                                                        <td>{{$exp_outcome['std']}}</td>
                                                                        <td>{{$exp_outcome['accuracy']}}</td>
                                                                        <td>{{$exp_outcome['MAE']}}</td>
                                                                        <td>{{$exp_outcome['RMSE']}}</td>
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
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>