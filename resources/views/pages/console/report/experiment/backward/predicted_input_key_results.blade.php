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
                        <h6 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Master Conditions</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="process_experiment_reports" class="table font-weight-normal">
                                <thead>
                                    <th>Condition Name</th>
                                    <th class="text-center">Value </th>
                                    <th class="text-center">Unit</th>
                                </thead>
                                <tbody>
                                    @if(!empty($data['predicted_input_key_results']['summary']))
                                    @foreach($data['predicted_input_key_results']['summary'] as $master_condition)
                                    <tr>
                                        <td>{{$master_condition['condition_name']}}</td>
                                        <td class="text-center">{{$master_condition['value']}}</td>
                                        <td class="text-center">
                                            @if(!empty($master_condition['unit_constants']))
                                            {{$master_condition['unit_constants']['unit_constant_name']}}
                                            @else
                                            -
                                            @endif
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
        <div class="card">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="card-header">
                        <h6 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Predicted Raw Materials</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="" class="table font-weight-normal ">
                                <thead>
                                    <th>Product</th>
                                    <th class="text-center">Value </th>
                                </thead>
                                <tbody>
                                    @if(!empty($data['predicted_input_key_results']['detailed']))
                                    @foreach($data['predicted_input_key_results']['detailed']['stream'] as $detailed)
                                    <tr>
                                        <td>{{$detailed['product_name']}}</td>
                                        <td class="text-center">{{$detailed['value']}}&#37;</td>
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