<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card shadow">
            <div class="card-body">
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
                            <div class="col-md-12 mb-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Accuracy of Master Outcomes</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="process_experiment_reports" class="table font-weight-normal">
                                                <thead>
                                                    <th>Outcome Name</th>
                                                    <th class="text-center">Value</th>
                                                    <th class="text-center">Unit</th>
                                                    <th class="text-center">SetPoint Achieved</th>
                                                </thead>
                                                <tbody>
                                                    @if(!empty($data['accuracy']['summary']))
                                                    @foreach($data['accuracy']['summary'] as $mkey=>$mv)
                                                    <tr>
                                                        <td>{{$mv['outcome_name']}}</td>
                                                        <td class="text-center">{{$mv['value']}}</td>
                                                        <td class="text-center">
                                                            @if(!empty($mv['unit_constants']))
                                                            {{$mv['unit_constants']['unit_constant_name']}}
                                                            @else
                                                            -
                                                            @endif
                                                        </td>
                                                        <td class="text-center">{{ucfirst($mv['setpoint_achieved'])}}</td>
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
                                    <div class="card-header">
                                        <h6 class="">Number of Iterations - {{ $data['accuracy']['detailed']}}</h6>
                                    </div>
                                    <div class="card-body">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>