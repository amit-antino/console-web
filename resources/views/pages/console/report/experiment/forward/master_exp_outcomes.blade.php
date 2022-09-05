<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active text-uppercase font-weight-normal" id="detailed-tab" data-toggle="tab" href="#detailed" role="tab" aria-controls="detailed" aria-selected="false">Detailed</a>
                    </li>

                </ul>
                <div class="tab-content border border-top-0 p-3" id="myTabContent">

                    <div class="tab-pane fade show active" id="detailed" role="tabpanel" aria-labelledby="detailed-tab">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="text-uppercase font-weight-normal">Master Exp Outcome</h6>
                                <div class="card-body"></div>
                                <div class="row">

                                    <div class="col-md-12 mb-3">
                                        <div class="card">

                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="process_experiment_reports" class="table table-hover mb-0">
                                                        <thead>
                                                            <th>Outcome Name</th>
                                                            <th>Value </th>
                                                            <th>Unit</th>

                                                        </thead>
                                                        <tbody>
                                                            @if(!empty($data['master_exp_outcomes']))
                                                            @foreach($data['master_exp_outcomes'] as $mkey=>$mval)
                                                            @if(!empty($mval))
                                                            @foreach($mval as $mk=>$mv)
                                                            <tr>
                                                                <td>{{$mv['outcome_name']}}</td>
                                                                <td>{{$mv['value']}}</td>
                                                                <td>{{$mv['unit_type']['unit_constant']['unit_symbol']}}</td>


                                                            </tr>
                                                            @endforeach
                                                            @endif
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
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>