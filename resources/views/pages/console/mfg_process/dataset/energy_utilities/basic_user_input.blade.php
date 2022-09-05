@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush
@php
$simulationtype = get_simulation_stage($data['process_dataset']['simulation_type']);
@endphp
<div class="tab-pane fade show active" id="v-expdata" role="tabpanel" aria-labelledby="v-expdata-tab">
    <div class="form-row">
    <h6 class="col-md-6">Basic User Input</h6>
    @if($data['viewflag']!="view_config")
    <button type="button" style="position:absolute;right:10px" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block"  onclick="basicio('-1')" data-toggle="tooltip" data-placement="bottom" title="Add Energy Input/Output">
        <i class="fas fa-plus"></i>&nbsp;&nbsp;
        Add Energy Input/Output
    </button>&nbsp;<br>
    @endif
    </div>
    <br>
    <div class="table">
        <table id="table-data" class="table">
            <thead>
                <tr>
                    <th>Energy</th>
                    <th>Flow Type</th>
                    <th>Energy Flow and Unit Type</th>
                    @if($data['viewflag']!="view_config")
                    <th>Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if(!empty($data['process_dataset']['energy_basic_io']))
                @php
                $energy_basic_io_list = $data['process_dataset']['energy_basic_io'];
                usort($energy_basic_io_list, function($a, $b) {
                    return $a['flow_type'] <=> $b['flow_type'];
                });
                @endphp
                @foreach($energy_basic_io_list as $count=>$energy_basic_io)
                @php
                $flowrate_unit = get_flowrate_unit($energy_basic_io['energy'])
                @endphp
                <tr>
                    <td>{{getsingleEnergyName($energy_basic_io['energy'])}}</td>
                    <td>{{getsingleFlowtyeName($energy_basic_io['flow_type'])}} &nbsp;

                    <span class="badge badge-info">
                    @if($energy_basic_io['io']==1)
                        Input
                    @else
                        Output
                    @endif
                    </span>

                    </td>
                    <td>{{$energy_basic_io['energy_flow']}} {{get_unit_constant($flowrate_unit,$energy_basic_io['unit_type'])}}</td>
                    <td class="text-center">
                        <input type="hidden" id="energy{{$count}}" value="{{___encrypt($energy_basic_io['energy'])}}" />
                        <input type="hidden" id="flow_type{{$count}}" value="{{___encrypt($energy_basic_io['flow_type'])}}" />
                        <input type="hidden" id="energy_flow{{$count}}" value="{{$energy_basic_io['energy_flow']}}" />
                        <input type="hidden" id="unit_type{{$count}}" value="{{___encrypt($energy_basic_io['unit_type'])}}" />
                        @if($data['viewflag']!="view_config")
                        <a href="javascript:void(0);" onclick="basicio('{{$count}}')" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit dataset">
                            <i class="fas fa-edit text-secondary"></i>
                        </a>
                        @if($energy_basic_io['flow_type']!=1 && $energy_basic_io['flow_type']!=3)
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
                    <h5 class="modal-title" id="userLabel">Add energy Input/Output</h5>
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
                            <label class="control-label">Energy & Utility
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Energy & Utility"></i></span>
                            </label>
                            <select class="form-control" id="energy" name="energy" onchange="get_unit_constant()">
                                <option selected disabled value="">Select Energy & Utility</option>
                                @if(!empty($data['energies']))
                                @foreach($data['energies'] as $energy)
                                @php
                                    $energy_id = substr($energy, 3);
                                @endphp
                                <option value="{{___encrypt($energy_id)}}">{{getsingleEnergyName($energy_id)}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Flow Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Flow Tpe" multiple-data-search-live="true"></i></span>
                            </label>
                            <select class="form-control" id="flow_type" name="flow_type">
                                <option selected disabled value="">Select Flow Type</option>
                                @if(!empty($data['flow_types']))
                                @foreach($data['flow_types'] as $flow_type)
                                @if($flow_type->id!=1 && $flow_type->id!=3)
                                <option value="{{___encrypt($flow_type->id)}}" data-type="{{$flow_type->type}}">{{$flow_type->flow_type_name}}</option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Energy Flow
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Energy Flow"></i></span>
                            </label>
                            <input class="form-control" id="energy_flow" name="energy_flow">
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
    var energy_id = $("#energy"+id).val();
    var flow_type = $("#flow_type"+id).val();
    var energy_flow = $("#energy_flow"+id).val();
    var unit_type = $("#unit_type"+id).val();
    $("#energy").val(energy_id)
    get_unit_constant(unit_type)
    $("#flow_type").val(flow_type)
    $("#energy_flow").val(energy_flow)

    if(flow_type=="{{___encrypt(1)}}" || flow_type=="{{___encrypt(3)}}"){
        $( "#energy" ).prop( "disabled", true );
        $( "#flow_type" ).prop( "disabled", true );
    }else{
        $( "#energy" ).prop( "disabled", false );
        $( "#flow_type" ).prop( "disabled", false );
    }

}

function saveBasicio(){
    var io_id = $("#io_id").val();
    var dataset_id = $("#dataset_id").val();
    var energy_id = $("#energy").val();
    var flow_type = $("#flow_type").val();
    var energy_flow = $("#energy_flow").val();
    var unit_type = $("#unit_type").val();
    var flow_type_io = $("#flow_type").find(':selected').attr('data-type')
    var error_msg=""
        if (energy_id ==null) {
            var error_msg = "Please Select energy"
        }
        if (error_msg=="" && flow_type ==null) {
            var error_msg = "Please Select Flow Type"
        }
        if (error_msg=="" && (energy_flow =="" || energy_flow==0)) {
            var error_msg = "Please Provide energy Flow"
        }
        if (error_msg=="" && unit_type ==null) {
            var error_msg = "Please Select Unit Type"
        }
        if(error_msg!=""){
            swal.fire({
                text: error_msg,
                confirmButtonText: 'Close',
                confirmButtonClass: 'btn btn-sm btn-danger',
                width: '350px',
                height: '10px',
                icon: 'warning',
            });
            return false;
        }

    var objectexp = {
        "io_id": io_id,
        "dataset_id": dataset_id,
        "energy": energy_id,
        "flow_type": flow_type,
        "energy_flow":energy_flow,
        "unit_type":unit_type,
        "io":flow_type_io,
    };
    event.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: 'POST',
        url: '{{ url("/mfg_process/simulation/dataset/save_energy_basic_io") }}',
        data: JSON.stringify(objectexp),
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
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
               // location.reload()
                // $("#basicioModal").hide();
                $("#basicioModal").modal('hide');
                $('#basicioModalClose').trigger('click');
                $(".modal-backdrop").hide();
                $('#energy_utilities').trigger('click');
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
        url: '{{ url("/mfg_process/simulation/dataset/delete_energy_basic_io") }}',
        data: JSON.stringify(objectexp),
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
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
                $('#energy_balance').trigger('click');
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

function get_unit_constant(unit_constant_id){
    var energy_id = $("#energy").val();
    $.ajax({
        type: 'get',
        url: '{{ url("/mfg_process/simulation/dataset/get_unit_constant/") }}/'+energy_id,
        cache: false,
        contentType: false,
        processData: false,
        success: function(data) {
            $("#unit_type").html(data.html);
            $("#unit_type").val(unit_constant_id)
        }
    });
}
</script>
