<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="text-uppercase font-weight-normal">Unit Outcomes</h6>
            </div>
            <div class="card-body row">
                @if(!empty($data['unit_outcomes_tab']))
                @foreach($data['unit_outcomes_tab'] as $key=>$val)
                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="text-uppercase font-weight-normal">{{$val['exp_unit_name']}}</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="process_experiment_reports" class="table table-hover mb-0">
                                    <thead>
                                        <th>Experimental Outcome</th>
                                        <th>Value</th>
                                        <th>Unit</th>
                                    </thead>
                                    <tbody>
                                        @if(!empty($val['exp_outcome']))
                                        @foreach($val['exp_outcome'] as $k=>$v)
                                        <tr>
                                            <td>{{$v['outcome_name']}}</td>
                                            <td>{{$v['value']}}</td>
                                            <td>{{$v['unit_type']['unit_constant']['unit_symbol']}}</td>
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
                @endif
            </div>
        </div>
    </div>
</div>