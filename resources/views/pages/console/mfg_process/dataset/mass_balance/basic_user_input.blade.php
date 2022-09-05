@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush
@php
$simulationtype = get_simulation_stage($data['process_dataset']['simulation_type']);
@endphp
<div class="tab-pane fade show active" id="v-expdata" role="tabpanel" aria-labelledby="v-expdata-tab">
    <div class="form-row">
    @if($data['viewflag']!="view_config")
    <!-- <h6 class="col-md-6">{{$simulationtype['simulation_name']}} - Basic User Input</h6> -->
        <button type="button" style="position:absolute;right:10px" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block"  onclick="basicio('-1')" data-toggle="tooltip" data-placement="bottom" title="Add Mass Input/Output">
            <i class="fas fa-plus"></i>&nbsp;&nbsp;
            Add Mass Input/Output 
        </button>&nbsp;<br>
    @endif
    </div>
    <br>
    <div class="table">
        <table id="table-data" class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Flow Type</th>
                    <th>Mass Flow and Unit Type</th>
                    @if($data['viewflag']!="view_config")
                    <th>Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if(!empty($data['process_dataset']['mass_basic_io']))
                @php 
                $mass_basic_io_list = $data['process_dataset']['mass_basic_io'];
                usort($mass_basic_io_list, function($a, $b) {
                    return $a['flow_type'] <=> $b['flow_type'];
                });
                @endphp
                @foreach($mass_basic_io_list as $count=>$mass_basic_io)
                <tr>
                    <td>{{getsingleChemicalName($mass_basic_io['product'])}}</td>
                    <td>{{getsingleFlowtyeName($mass_basic_io['flow_type'])}} &nbsp;
                    
                    <span class="badge badge-info">
                    @if($mass_basic_io['io']==1)
                        Input
                    @else
                        Output
                    @endif
                    </span>
                    
                    </td>
                    <td>{{$mass_basic_io['mass_flow']}} {{get_unit_constant(10,$mass_basic_io['unit_type'])}}</td>
                    <td class="text-center">
                        <input type="hidden" id="product{{$count}}" value="{{___encrypt($mass_basic_io['product'])}}" />
                        <input type="hidden" id="flow_type{{$count}}" value="{{___encrypt($mass_basic_io['flow_type'])}}" />
                        <input type="hidden" id="mass_flow{{$count}}" value="{{$mass_basic_io['mass_flow']}}" />
                        <input type="hidden" id="unit_type{{$count}}" value="{{___encrypt($mass_basic_io['unit_type'])}}" />
                        <input type="hidden" id="phase{{$count}}" @if(!empty($mass_basic_io['phase'])) value="{{$mass_basic_io['phase']}}" @else value='' @endif />
                        @if($data['viewflag']!="view_config")
                        <a href="javascript:void(0);" onclick="basicio('{{$count}}')" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit dataset">
                            <i class="fas fa-edit text-secondary"></i>
                        </a>
                        @if($mass_basic_io['flow_type']!=1 && $mass_basic_io['flow_type']!=3)
                        <a href="javascript:void(0);" onclick="deletebasicio('{{$count}}')" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit dataset">
                            <i class="fas fa-trash text-secondary"></i>
                        </a>
                        @endif
                        @endif
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="basicioModal" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ url('/mfg_process/simulation/'.___encrypt($data['process_dataset']['id']).'/dataset/store') }}" method="POST" role="process_config">
                <div class="modal-header">
                    <h5 class="modal-title" id="userLabel">Add Mass Input/Output</h5>
                    <button type="button" id="basicioModalClose" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <input type="hidden" id="dataset_id" name="dataset_id" class="form-control" value="{{___encrypt($data['process_dataset']['id'])}}">
                            <input type="hidden" id="io_id" name="io_id" class="form-control" value="">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Product
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Product"></i></span>
                            </label>
                            <select class="form-control" id="product" name="product">
                                <option selected disabled value="">Select Product</option>
                                @if(!empty($data['products']))
                                @foreach($data['products'] as $product)
                                @php
                                    $product_id = substr($product, 3);
                                @endphp
                                <option value="{{___encrypt($product_id)}}">{{getsingleChemicalName($product_id)}}</option>
                                @endforeach
                                @endif
                            </select>
                            <span id="err-product" style='display:none' class="text-danger">Select product</span>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Flow Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Flow Tpe"></i></span>
                            </label>
                            <select class="form-control" id="flow_type" name="flow_type" onchange="display_phase()">
                                <option selected disabled value="">Select Flow Type</option>
                                @if(!empty($data['flow_types']))
                                @foreach($data['flow_types'] as $flow_type)
                                <option value="{{___encrypt($flow_type->id)}}" data-type="{{$flow_type->type}}">{{$flow_type->flow_type_name}}</option>
                                @endforeach
                                @endif
                            </select>
                            <span id="err-flow_type" style='display:none' class="text-danger">Select flow type</span>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Mass Flow
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Mass Flow"></i></span>
                            </label>
                            <input class="form-control" id="mass_flow" name="mass_flow">
                            <span id="err-mass_flow" style='display:none' class="text-danger">Enter mass flow</span>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Unit Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Unit Type"></i></span>
                            </label>
                            <select class="form-control" id="unit_type" name="unit_type">
                                <option selected disabled value="">Select Unit Type</option>
                                @if(!empty($data['unit_types']))
                                @foreach($data['unit_types'] as $unit_type)
                                <option value="{{___encrypt($unit_type['id'])}}">{{$unit_type['unit_name']}}</option>
                                @endforeach
                                @endif
                            </select>
                            <span id="err-unit_type" style='display:none' class="text-danger">Select unit type</span>
                        </div>
                        <div class="form-group col-md-6" id="phase_div" style='display:none'>
                            <label class="control-label">Phase of the component
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Phase of the component"></i></span>
                            </label>
                            <select class="form-control" id="phase" name="phase">
                                <option selected disabled value="">Select phase of the component</option>
                                <option value="solid" @if(!empty($data['phase']) && $data['phase']==solid) selected @endif>Solid</option>
                                <option value="liquid" @if(!empty($data['phase']) && $data['phase']==liquid) selected @endif>Liquid</option>
                                <option value="gas"  @if(!empty($data['phase']) && $data['phase']==gas) selected @endif>Gas/Vapour</option>
                            </select>
                            <span id="err-phase" style='display:none' class="text-danger">Select phase of the component</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                <button type="button" onclick="saveBasicio()" class="btn btn-sm btn-secondary submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

<script>

function basicio(id) {
    $("#basicioModal").modal('show');
    $("#io_id").val(id);
    var product_id = $("#product"+id).val();
    var flow_type = $("#flow_type"+id).val();
    var mass_flow = $("#mass_flow"+id).val();
    var unit_type = $("#unit_type"+id).val();
    var phase = $("#phase"+id).val();
    $("#product").val(product_id)
    $("#flow_type").val(flow_type)
    $("#mass_flow").val(mass_flow)
    $("#unit_type").val(unit_type)
    $("#phase").val(phase)
    if(flow_type=="{{___encrypt(1)}}" || flow_type=="{{___encrypt(3)}}"){
        $( "#product" ).prop( "disabled", true );
        $( "#flow_type" ).prop( "disabled", true );
    }else{
        $( "#product" ).prop( "disabled", false );
        $( "#flow_type" ).prop( "disabled", false );
    }
    display_phase()
}

function display_phase(){
    var flow_type = $("#flow_type").val();
    if(flow_type == '4openRe7Az'){
        $("#phase_div").show();
    }else{
        $("#phase_div").hide();
        $("#phase").val('');
    }
}

function saveBasicio(){
    var io_id = $("#io_id").val();
    var dataset_id = $("#dataset_id").val();
    var product_id = $("#product").val();
    var flow_type = $("#flow_type").val();
    var mass_flow = $("#mass_flow").val();
    var unit_type = $("#unit_type").val();
    var phase = $("#phase").val();
    var flow_type_io = $("#flow_type").find(':selected').attr('data-type')
    $("#err-product").hide();
    $("#err-flow_type").hide();
    $("#err-mass_flow").hide();
    $("#err-unit_type").hide();
    $("#err-phase").hide();
    if (product_id ==null) {
        $("#err-product").show();
        return;
    }
    if (flow_type ==null) {
        $("#err-flow_type").show();
        return;
    }
    if (mass_flow =="" || mass_flow==0) {
        $("#err-mass_flow").show();
        return;
    }
    if (unit_type ==null) {
        $("#err-unit_type").show();
        return;
    }
    if(flow_type == '4openRe7Az' && phase == null){
        $("#err-phase").show();
        return;
    }

    var objectexp = {
        "io_id": io_id,
        "dataset_id": dataset_id,
        "product": product_id,
        "flow_type": flow_type,
        "mass_flow":mass_flow,
        "unit_type":unit_type,
        "io":flow_type_io,
        "phase" : phase,
    };
    event.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: '{{ url("/mfg_process/simulation/dataset/save_basic_io") }}',
        data: JSON.stringify(objectexp),
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            debugger;
            if (data.success === true) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                Toast.fire({
                    icon: 'success',
                    title: data.message,
                })
                location.reload()
                // $("#basicioModal").hide();
                // $("#basicioModal").modal('hide');
                $('#basicioModalClose').trigger('click');
                $('#mass_balance').trigger('click');
                // $(".modal-backdrop").hide();
            } else {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: true,
                    
                });
                Toast.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.message,
                })
            }
        },
    });
}

function deletebasicio(id){
    var objectexp = {
        "id": id,
        "dataset_id": dataset_id,
    };
    $.ajax({
        type: 'POST',
        url: '{{ url("/mfg_process/simulation/dataset/delete_basic_io") }}',
        data: JSON.stringify(objectexp),
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            debugger;
            if (data.status === true) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                Toast.fire({
                    icon: 'success',
                    title: data.message,
                })
                $('#mass_balance').trigger('click');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.errors,
                })
            }
        },
    });
}
</script>
