<ul class="nav nav-tabs nav-tabs-line" id="myTab" role="tablist">
    @if(!empty($data['key_data_inputs']))
    <li class="nav-item">
        <a class="nav-link active font-weight-normal text-uppercase" id="key_data_inputs-tab" data-toggle="tab" href="#key_data_inputs" role="tab" aria-controls="key_data_inputs" aria-selected="true">Key Data Inputs</a>
    </li>
    @endif
    @if(!empty($data['commercial_info']))
    <li class="nav-item">
        <a class="nav-link font-weight-normal text-uppercase {{!empty($data['commercial_info'])?'':'active'}}" id="commercial_info-tab" data-toggle="tab" href="#commercial_info" role="tab" aria-controls="commercial_info" aria-selected="false">Commercial Info</a>
    </li>
    @endif
</ul>
<div class="tab-content mt-3" id="myTabContent">
    <div class="tab-pane fade {{!empty($data['key_data_inputs'])?'show active':''}}" id="key_data_inputs" role="tabpanel" aria-labelledby="key_data_inputs-tab">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div>
                        <h6 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Stream Information</h6>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="stream_info" class="table">
                        <thead>
                            <th>Stream</th>
                            <th>Products</th>
                        </thead>
                        <tbody class="font-weight-normal">
                            @if(!empty($data['key_data_inputs']['stream_info']))
                            @foreach($data['key_data_inputs']['stream_info'] as $sk=>$stream_info)
                            <tr>
                                <td>{{$sk}}</td>
                                <td>
                                    @foreach($stream_info as $product)
                                    <span class="badge badge-info">{{getsingleChemicalName($product)}}</span>
                                    @endforeach
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="table-responsive">
                    <table id="stream_info" class="table">
                        <thead>
                            <th>Stream</th>
                            <th>Products</th>
                        </thead>
                        <tbody class="font-weight-normal">
                            @if(!empty($data['key_data_inputs']['stream_info']))
                            @foreach($data['key_data_inputs']['stream_info'] as $sk=>$stream_info)
                            <tr>
                                <td>{{$sk}}</td>
                                <td>
                                    @foreach($stream_info as $product)
                                    <span class="badge badge-info">{{getsingleChemicalName($product)}}</span>
                                    @endforeach
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
    <div class="tab-pane fade {{!empty($data['inputs']['summary'])?'':'show active'}}" id="detailed" role="tabpanel" aria-labelledby="detailed-tab">
        <div class="row">
            @if(!empty($data['inputs']['detailed']['experiment_unit_condition']))
            <div class="col-md-12 mb-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h6 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Unit Condition</h6>
                    </div>
                </div>
                <div class="">
                    <div class="row">
                        @foreach($data['inputs']['detailed']['experiment_unit_condition'] as $unit_condition)
                        <div class="col-12 p-3">
                            <div class="card">
                                <div class="p-3">
                                    <h6 class="text-uppercase font-weight-normal">Experiment Unit Name: {{str_replace("_", " ", Str::upper($unit_condition['experiment_unit_name']))}}</h6>
                                </div>
                                <div class="table-responsive">
                                    <table id="input_mastercondition" class="table nowrap">
                                        <thead>
                                            <th>Condition Name</th>
                                            <th>Value</th>
                                        </thead>
                                        <tbody class="font-weight-normal">
                                            @if(!empty($unit_condition['experiment_equipment_unit']))
                                            @foreach($unit_condition['experiment_equipment_unit'] as $exp_outcome)
                                            <tr>
                                                <td>
                                                    {{$exp_outcome['condition_name']}}
                                                </td>
                                                <td> {{$exp_outcome['value']}}
                                                    @if(!empty($exp_outcome['unit_constant_name']))
                                                    {{$exp_outcome['unit_constant_name']['unit_constant']['unit_symbol']}}
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="2">No Records Found</td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
            @if(!empty($data['inputs']['detailed']['raw_material']))
            <div class="col-md-12 mb-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h6 class="text-uppercase font-weight-normal">Raw Materials</h6>
                        </br>
                    </div>
                </div>
                <div class="">
                    <div class="table-responsive">
                        <table id="input_raw" class="table">
                            <thead>
                                <th>Stream Name</th>                                                          
                                <th>Product and Flow Rate</th>
                                 <th>Unit</th>   
                            </thead>
                            <tbody class="font-weight-normal">
                                @foreach($data['inputs']['detailed']['raw_material'] as $strkey=> $stream_info)
                                <tr>
                                    <td>{{str_replace("-", " ", Str::upper($stream_info['stream']))}}</td>
                                    
                                    <td>
                                        @foreach($stream_info['detail'] as $key => $val)
                                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                                            <p>{{$key+1}}. {{$val['product_name']}}</p>&nbsp;&nbsp;
                                            <span class="badge badge-info">{{(!empty($val['value']))?$val['value']:0}}</span>
                                        </div>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{$stream_info['unit_constant_name']}}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
            @if(!empty($data['inputs']['detailed']['productproperty']))
            <div class="col-md-12">
                <div class="card-header">
                    <h6 class="">Raw Materials Product Properties</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($data['inputs']['detailed']['productproperty'] as $pkey => $product_prop)
                        <div class="col-md-12 mb-3">
                            <div class="card">
                                <div class="card-header">
                                    <button type="button" class="btn btn-sm btn-info mr-2 d-none d-md-block" data-toggle="collapse" data-target="#collapseExample{{$pkey}}" aria-expanded="false" aria-controls="collapseExample">{{(!empty($product_prop['product_name']))?$product_prop['product_name']:''}}</button>
                                </div>
                                <div class="collapse" id="collapseExample{{$pkey}}">
                                    <div class="card-body row">
                                        @if(!empty($product_prop['sub_property_name']))
                                        @foreach($product_prop['sub_property_name'] as $propkey=>$prop)
                                        <div class="col-md-6 grid-margin stretch-card">
                                            <div class="card border-left-secondary shadow h-100 py-2">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                                                <small>Sub Property Name<br></small>{{$prop['property_name']}}
                                                            </div>
                                                        </div>
                                                        @if(is_array($prop['value']))
                                                        @foreach($prop['value'] as $p)
                                                        <div class="col-auto">
                                                            <h6 class="mb-3 mb-md-0 text-uppercase font-weight-normal"> Value: <span class="badge badge-secondary">{{$p['value']}} {{$p['unit_constant_name']}} </span></h6>
                                                        </div>
                                                        @endforeach
                                                        @else
                                                        <div class="col-auto">
                                                            <h6 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Value: <span class="badge badge-secondary">{{$prop['value']}} {{$prop['unit_constant_name']}}</span></h6>
                                                        </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                        @else
                                        <div class="col-md-3 grid-margin stretch-card">
                                            <h6 class="mb-3 mb-md-0 text-uppercase font-weight-normal">No record </h6>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        // $('#input_mastercondition').DataTable({
        //     "iDisplayLength": 10,
        //     "language": {
        //         search: ""
        //     }
        // });
        // $('#input_mastercondition').each(function() {
        //     var datatable = $(this);
        //     // SEARCH - Add the placeholder for Search and Turn this into in-line form control
        //     var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
        //     search_input.attr('placeholder', 'Search');
        //     search_input.removeClass('form-control-sm');
        //     // LENGTH - Inline-Form control
        //     var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
        //     length_sel.removeClass('form-control-sm');
        // });
        // $('#input_raw').DataTable({
        //     "iDisplayLength": 10,
        //     "language": {
        //         search: ""
        //     }
        // });
        // $('#input_raw').each(function() {
        //     var datatable = $(this);
        //     // SEARCH - Add the placeholder for Search and Turn this into in-line form control
        //     var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
        //     search_input.attr('placeholder', 'Search');
        //     search_input.removeClass('form-control-sm');
        //     // LENGTH - Inline-Form control
        //     var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
        //     length_sel.removeClass('form-control-sm');
        // });
    });
</script>
