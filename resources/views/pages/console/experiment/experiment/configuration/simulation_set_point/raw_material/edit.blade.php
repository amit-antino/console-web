<div class="modal fade pd " tabindex="-1" role="dialog" aria-labelledby="pd" aria-hidden="true" id="pd{{___encrypt($data['pfd_stream_id'])}}">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="{{url('experiment/experiment/simulate_set_point/raw_material_list')}}" role="edit_output_raw_material{{$data['count']}}">
            <input type="hidden" name="count" value="{{$data['count']}}">
                <input type="hidden" name="pfd_stream_id" value="{{___encrypt($data['pfd_stream_id'])}}">
                <input type="hidden" name="simulate_input_id" value="{{___encrypt($data['simulate_input_id'])}}">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase font-weight-normal" id="exampleModalLabel">Edit Raw Material
                        Stream Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="process_experiment_name">Process Stream Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Process Stream Name"></i></span>
                            </label>
                            <input type="text" value="{{$data['processDiagram']['name']}}" class="form-control" id="name" name="name" required placeholder="Process Stream Name" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="process_experiment_name">Select Unit Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Unit Type"></i></span>
                            </label>
                            <select name="unit_id" class="form-control" data-request="ajax-append-fields" data-url="{{url('experiment/experiment/product_raw_material_list')}}" data-method="POST" data-process_experiment_id="{{___encrypt($data['experiment_id'])}}" data-count="0" data-target="#unit_constant_list">
                                <option value="">Select Unit Type</option>
                                <option @if($data['unit_id']==10) selected @endif value="{{___encrypt(10)}}">Mass</option>
                                <option @if($data['unit_id']==4) selected @endif value="{{___encrypt(4)}}">Volume</option>
                                <option @if($data['unit_id']==3) selected @endif value="{{___encrypt(3)}}">Molar</option>

                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="process_experiment_name">Value Flow Rate
                                <!-- <span class="text-danger">*</span> -->
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Value Flow Rate"></i></span>
                            </label>
                            <input type="number" min="0.0000000001" data-request="isnumeric" value="{{!empty($data['value_flow_rate'])?$data['value_flow_rate']:0}}" class="form-control" id="value_flow_rate" name="value_flow_rate" required placeholder="Enter Value Flow Rate">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="unit_constant_id">Select Unit Constant
                                <!-- <span class="text-danger">*</span> -->
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Unit Type"></i></span>
                            </label>
                            <select name="unit_constant_id" id="unit_constant_list" class="form-control">
                                <option value="">Select Unit Constant</option>
                                @if(!empty($data['master_unit']))
                                @foreach($data['master_unit'] as $unit_type)
                                <option @if($data['unit_constant_id']==$unit_type['id']) selected @endif value="{{___encrypt($unit_type['id'])}}">{{$unit_type['unit_name']}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        @if(!empty($data['product_arr']))
                        @php
                        $total_count=count($data['product_arr'])-1;
                        @endphp
                        <div class="col-md-12" id="product_list">
                            @foreach($data['product_arr'] as $default_count => $pro)
                            <div class="form-row" id="remove-raw-material-product{{$default_count}}">
                                <div class="form-group col-md-4">
                                    <label for="process_experiment_name">Select Product
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Product"></i></span>
                                    </label>
                                    <select class="form-control rm_product" onchange="check_duplicate($(this))" data-target="#associated_chemical{{$default_count}}" data-count="{{$default_count}}" data-method="POST" data-request="ajax-append-fields" data-url="{{url('experiment/experiment/getProductAssociateSimulation')}}" id="product_id" name="product_arr[{{$default_count}}][product_id]">
                                        <option value="">Select Product</option>
                                        @if(!empty($data['product']))
                                        @foreach($data['product'] as $chemical)
                                        @if(!empty($pro['product_id']))
                                        <option @if($pro['product_id']==$chemical->id)) selected @endif
                                            value="{{___encrypt($chemical->id)}}">{{$chemical->chemical_name}}</option>
                                        @else
                                        <option value="{{___encrypt($chemical->id)}}">{{$chemical->chemical_name}}
                                        </option>
                                        @endif
                                        @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label class="control-label">Select Criteria
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Criteria"></i></span>
                                    </label>
                                    <select data-target="#setpoint-raw-material-value{{$default_count}}" data-count="{{$default_count}}" data-method="POST" data-type="raw_material" data-request="ajax-append-fields" data-url="{{url('experiment/experiment/range-value-field')}}" class="form-control" id="criteria" name="product_arr[{{$default_count}}][criteria]">
                                        <option value="">Select Criteria</option>
                                        @if(!empty($criteria))
                                        @foreach($criteria as $criterias)
                                        <option @if($pro['criteria']==$criterias->id) selected @endif value="{{___encrypt($criterias->id)}}">{{$criterias->name}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <div class="form-row">
                                        <div class="form-group col-md-9">
                                            <label class="control-label">Enter Value Percentage
                                                <span class="text-danger">*</span>
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Value"></i></span>
                                            </label>
                                            <div class="input-group">
                                                <input type="number" min="0.0000000001" data-request="isnumeric" class="form-control" value="{{!empty($pro['total'])?$pro['total']:0}}" id="value" name="product_arr[{{$default_count}}][value]" placeholder="Enter Total Value">
                                                <div id="setpoint-raw-material-value{{$default_count}}">
                                                    @if(!empty($pro['max_value']))
                                                    <input type="number" min="0.0000000001" data-request="isnumeric" class="form-control" value="{{$pro['max_value']}}" id="value" name="product_arr[{{$default_count}}][max_value]" placeholder="Enter Total Value">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                @if($default_count==0)
                                <div class="col-md-1 add_more_button_align">
                                    <button type="button" class="btn btn-secondary btn-sm btn-icon" data-request="add-another" data-target="#clone_div" data-url="{{url('experiment/data_set/raw_material/add_more_product_set_point?count='.$total_count.'&experiment_id='.___encrypt($data['experiment_id']).'&pfd_stream_id='.___encrypt($data['pfd_stream_id']).'&unit_id='.___encrypt($data['unit_id']))}}" data-types="chemical" data-count="{{$total_count}}">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                @else
                                <div class="col-md-1 add_more_button_align">
                                    <button type="button" class="btn btn-danger btn-sm btn-icon" data-request="remove" data-target="#remove-raw-material-product{{$default_count}}">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>

                        @else
                        @php
                        $default_count=0;
                        @endphp
                        <div class="col-md-12 form-row">
                            <div class="form-group col-md-4">
                                <label for="process_experiment_name">Select Product
                                    <span class="text-danger">*</span>
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Product"></i></span>
                                </label>
                                <select class="form-control rm_product" onchange="check_duplicate($(this))" id="product_id" name="product_arr[{{$default_count}}][product_id]">
                                    <option value="">Select Product</option>
                                    @if(!empty($data['product']))
                                    @foreach($data['product'] as $chemical)
                                    @if(!empty($pro['product_id']))
                                    <option @if($pro['product_id']==$chemical->id)) selected @endif
                                        value="{{___encrypt($chemical->id)}}">{{$chemical->chemical_name}}</option>
                                    @else
                                    <option value="{{___encrypt($chemical->id)}}">{{$chemical->chemical_name}}</option>
                                    @endif
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label class="control-label">Select Criteria
                                    <span class="text-danger">*</span>
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Criteria"></i></span>
                                </label>
                                <select data-target="#setpoint-raw-material-value{{$default_count}}" data-count="{{$default_count}}" data-method="POST" data-type="raw_material" data-request="ajax-append-fields" data-url="{{url('experiment/experiment/range-value-field')}}" class="form-control" id="criteria" name="product_arr[{{$default_count}}][criteria]">
                                    <option value="">Select Criteria</option>
                                    @if(!empty($criteria))
                                    @foreach($criteria as $criterias)
                                    @if(!empty($pro['criteria']))
                                    <option @if($pro['criteria']==$criterias->id) selected @endif value="{{___encrypt($criterias->id)}}">{{$criterias->name}}</option>
                                    @else
                                    <option value="{{___encrypt($criterias->id)}}">{{$criterias->name}}</option>
                                    @endif
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md-4">
                                <div class="form-row">
                                    <div class="form-group col-md-9">
                                        <label class="control-label">Enter Value Percentage
                                            <span class="text-danger">*</span>
                                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Value"></i></span>
                                        </label>
                                        <div class="input-group">
                                            <input type="number" min="0.0000000001" data-request="isnumeric" class="form-control" value="{{$prod['total']}}" id="value" name="product_arr[{{$default_count}}][value]" placeholder="Enter Total Value">
                                            <div id="setpoint-raw-material-value{{$default_count}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-1 add_more_button_align">
                                <label class=""></label>
                                <button type="button" class="btn btn-secondary btn-sm btn-icon" data-request="add-another" data-target="#clone_div" data-url="{{url('experiment/data_set/raw_material/add_more_product_set_point?count='.$default_count.'&experiment_id='.___encrypt($data['experiment_id']).'&pfd_stream_id='.___encrypt($data['pfd_stream_id']))}}" data-types="chemical" data-count="{{$default_count}}">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-12" id="clone_div">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-ajax_list="#outcome_raw_material" data-model_id="#pd{{___encrypt($data['pfd_stream_id'])}}" data-request="ajax-submit-popup-form" data-target='[role="edit_output_raw_material{{$data['count']}}"]' class="btn btn-sm btn-secondary submit">Update</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function check_duplicate(selected_product){
    arr =  $(".rm_product").map(function() {
                        return $(this).val();
                    }).get();
    var cnt = 0;
    for(i=0;i<arr.length;i++){
        if(selected_product.val()==arr[i]){
            cnt++
        }
    }
    if(cnt>1){
        selected_product.val("");
        Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Product already selected',
                })
                return false;
    }
}
    function setval(cnt){
        debugger
        var selected_product=$('#product_id0').val()
        var selected_criteria=$('#criteria0').val()
        var selected_value=$('#value0').val()
        var max_value=$('#max_value0').val()
        // var cnt='{{$data['count']}}'
        $('#product_id'+cnt).val(selected_product)
        $('#criteria'+cnt).val(selected_criteria)
        $('#value'+cnt).val(selected_value)
        $('#max_value0'+cnt).val(max_value)
        $('#product_id0').val(0)
        $('#criteria0').val(0)
        $('#value0').val(0)
        $('#max_value0').val(0)
    }


</script>

