<div class="row">
    <div class="col-md-12 grid-margin ">
        <div class="">
            <div class="">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active font-weight-normal text-uppercase" id="summary-tab" data-toggle="tab" href="#summary" role="tab" aria-controls="summary" aria-selected="true">Summary</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link font-weight-normal text-uppercase" id="detailed-tab" data-toggle="tab" href="#detailed" role="tab" aria-controls="detailed" aria-selected="false">Detailed</a>
                    </li>
                </ul>
                <div class="tab-content border border-top-0 p-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="summary-tab">
                        <div class="row">
                            <div class="col-md-12 mb-3 grid-margin">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                                        <div>
                                            <h6 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Master Outcomes</h6>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="key_result_outcome" class="table">
                                                <thead>
                                                    <th>Outcome Name</th>
                                                    <th class="text-center">Value </th>
                                                </thead>
                                                <tbody class="font-weight-normal">
                                                    @if(!empty($data['desired_outcomes']['summary']))
                                                    @foreach($data['desired_outcomes']['summary'] as $master_outcomes)
                                                    <tr>
                                                        <td>{{$master_outcomes['outcome_name']}}</td>
                                                        <td class="text-center">
                                                            {{$master_outcomes['value']}}
                                                            {{(!empty($master_outcomes['unit_constant_name']))?$master_outcomes['unit_constant_name']['unit_constant']['unit_name']:'-'}}
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
                    </div>
                    <div class="tab-pane fade" id="detailed" role="tabpanel" aria-labelledby="detailed-tab">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                                        <div>
                                            <h6 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Master Conditions</h6>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="key_result_outcome" class="table">
                                                <thead>
                                                    <th>Condition Name</th>
                                                    <th class="text-center">Value </th>
                                                </thead>
                                                <tbody class="font-weight-normal">
                                                    @if(!empty($data['desired_outcomes']['detailed']['experiment_unit_condition']))
                                                    @foreach($data['desired_outcomes']['detailed']['experiment_unit_condition'] as $experiment_unit_condition)
                                                    <tr>
                                                        <td>{{$experiment_unit_condition['condition_name']}}</td>
                                                        <td class="text-center">
                                                            {{$experiment_unit_condition['value']}}
                                                            {{(!empty($experiment_unit_condition['unit_constant_name']))?$experiment_unit_condition['unit_constant_name']:'-'}}
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
                            @if(!empty($data['desired_outcomes']['detailed']['raw_material']))
                            <div class="col-md-12 mb-3">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                                        <div>
                                            <h6 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Raw Materials</h6>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="input_raw" class="table">
                                                <thead>
                                                    <th>Stream Name</th>
                                                    <th>Value and Flow Rate</th>
                                                    <th>Product and Percentage</th>
                                                </thead>
                                                <tbody class="font-weight-normal">
                                                    @foreach($data['desired_outcomes']['detailed']['raw_material'] as $stream_info)
                                                    <tr>
                                                        <td>{{str_replace("-", " ", Str::upper($stream_info['stream']))}}</td>
                                                        <td>
                                                            {{$stream_info['flow_rate_value']}} {{$stream_info['unit_constant_name']}}
                                                        </td>
                                                        <td>
                                                            @foreach($stream_info['detail'] as $key => $val)
                                                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                                                <p>{{$key+1}}. {{$val['product_name']}}</p>&nbsp;&nbsp;
                                                                <span class="badge badge-info">{{(!empty($val['value']))?$val['value']:0}}&#37;</span>
                                                            </div>
                                                            @endforeach
                                                        </td>
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
                </div>
            </div>
        </div>
    </div>
</div>