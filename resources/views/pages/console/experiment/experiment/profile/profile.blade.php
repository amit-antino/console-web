@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<style>
    div.experiment_unit_section_scroll {
        /* height: 310px; */
        overflow-y: auto;
        min-height: 50px;
        max-height: 310px;
    }

    div.unit_specification_scroll {
        /* height: 310px; */
        overflow-y: auto;
        min-height: 50px;
        max-height: 310px;
        max-width: 210px;
    }
</style>
@endpush

@section('content')
@php
$per = request()->get('sub_menu_permission');
$permission=!empty($per['variation']['method'])?$per['variation']['method']:[];
@endphp
<div class="d-flex justify-content-between align-items-center">
    <div>
        <nav class="page-breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/experiment/experiment') }}">Experiments</a> - {{$process_experiment_info['name']}}</li>
                <li class="breadcrumb-item active" aria-current="page"><span id="profilebread">Experiment Profile<span>
                </li>
            </ol>
        </nav>
    </div>
    <div class="mb-3 d-flex align-items-center flex-wrap text-nowrap mr-2">
        <p class="mr-2 card-text text-muted ">Last updated
            {{___ago($process_experiment_info['updated_at'])}}
        </p>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <p class="mr-2">Status: <span class="badge badge-info">{{ucfirst($process_experiment_info['status'])}}</span></p>
            @if($parameters!='view')
            <a href="{{ url('/experiment/experiment/'.___encrypt($process_experiment_info['id']).'/edit') }}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" data-toggle="tooltip" data-placement="bottom" title="Edit Experiment">
                <i class="btn-icon-prepend" data-feather="edit"></i>
                Edit
            </a>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card shadow">
            <!-- <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Experiment Profile :
                        {{$process_experiment_info['name']}}
                    </h5>
                </div>
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    <p class="mr-2 card-text text-muted ">Last updated
                        {{___ago($process_experiment_info['updated_at'])}}
                    </p>
                    <h5 class="mr-2 text-uppercase font-weight-normal">Status: <span class="badge badge-info font-weight-normal">{{ucfirst($process_experiment_info['status'])}}</span>
                    </h5>
                    <a href="{{ url('/experiment/experiment/'.___encrypt($process_experiment_info['id']).'/edit') }}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" data-toggle="tooltip" data-placement="bottom" title="Edit Experiment">
                        <i class="btn-icon-prepend" data-feather="edit"></i>
                        Edit Experiment
                    </a>
                </div>
            </div> -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">

                    </div>
                    <div class="col-md-12">
                        <ul id="list-example" class="nav nav-tabs grid-margin font-weight-normal" id=" myTab" role="tablist">
                            <li class=" nav-item">
                                <a class="nav-link show active" id="profile_tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true" onclick="getprofileView()">Profile</a>
                            </li>
                            <li class=" nav-item">
                                <a class="nav-link" id="configuration_view_tab" data-toggle="tab" href="#configuration_view" role="tab" aria-controls="configuration_view" aria-selected="true" onclick="getConfigView()">Experiment Variation</a>
                            </li>
                        </ul>
                        <div class="text-center">
                            <div id="expprofileSpinner" class="spinner-border text-secondary" style="width: 2rem; height: 2rem;display: none; margin-top:25px;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                        <div class="tab-content p-3" id="myTabContent">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <div id="expprofileSpinner" class="spinner-border text-secondary" style="width: 2rem; height: 2rem;display: none; margin-top:25px;" role="status">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile_tab">
                                <div class="mb-3 grid-margin" id="view_profile_data">
                                </div>
                            </div>
                            <div class="tab-pan fade" id="configuration_view" role="tabpanel" aria-labelledby="configuration_view_tab">
                                <div class="mb-3 grid-margin" id="view_config_data">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Save Model Form for Variation -->
<div class="modal fade bd-example-modal-lg" id="configModal" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ url('/experiment/variation') }}" method="POST" role="process_config">
                <div class="modal-header">
                    <h5 class="modal-title" id="userLabel">Add Experiment Variation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Variation Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Variation Name"></i></span>
                            </label>
                            <input type="text" id="variation_name" name="variation_name" class="form-control" value="" placeholder="Variation Name">
                            <input type="hidden" id="experiment_id" name="experiment_id" class="form-control" value="{{___encrypt($process_experiment_info['id'])}}">
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Description"></i></span>
                            </label>
                            <textarea name="config_description" id="config_description" rows="5" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="process_config"]' class="btn btn-sm btn-secondary submit">Submit</button>
                    <!-- <button type="button" onclick="saveCurrentConfig()" class="btn btn-sm btn-secondary submit">Submit</button> -->
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Model Form for Process Flow Diagram -->
<div class="modal fade adddiagrammodel" tabindex="-1" role="dialog" id="adddiagrammodel" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Process Stream</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="process_experiment_name">Process Stream Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Stream Name"></i></span>
                            </label>
                            <input type="text" class="form-control" id="process_stream_name" name="process_stream_name" onchange="$('#process_stream_name-error').hide()" required placeholder="Enter Stream Name">
                            <span class="text-danger" id="process_stream_name-error" style="display:none">Process stream name field is required</span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="chemical">Select Flow Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Flow Type"></i></span>
                            </label>
                            <select class="form-control" id="process_flowtuye" onchange="enbleopenstream(this.value);$('#process_flowtuye-error').hide()">
                                <option value="0">Select Stream Flow</option>
                                @if(!empty($process_experiment_info['mass_flow_types']))
                                @foreach($process_experiment_info['mass_flow_types'] as $flowkey=>$flowval)
                                <option value="{{___encrypt($flowval['id'])}}">{{$flowval['name']}}</option>
                                @endforeach
                                @else
                                <option> No record Found</option>
                                @endif
                            </select>
                            <span class="text-danger" id="process_flowtuye-error" style="display:none">Flow type field is required</span>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Stream Type Open/Close
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Stream Type Open/Close"></i></span>
                            </label>
                            <div class="custom-control custom-switch ">&nbsp;&nbsp;
                                <input disabled type="checkbox" class="custom-control-input chk" id="openstream">
                                <label disabled class="custom-control-label text-center" for="openstream">Open
                                    Stream</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12 card fromunit">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h6>From Unit</h6>
                                </div>
                                <div>
                                    <button id="fromid" type="button" class="close float-left" data-toggle="tooltip" data-placement="top" title="Deselect">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body form-row">
                                <div class="form-group col-md-6">
                                    <label for="chemical">Select Experiment Unit
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Experiment Unit"></i></span>
                                    </label>
                                    <select class="form-control" id="experimentunit_output" onchange="getStreamDataInputOutput(this.value,'output');$('#experimentunit_output-error').hide()">
                                        <option value="0">Select Experiment Unit</option>
                                        @if(!empty($process_experiment_info['experiment_units']))
                                        @foreach($process_experiment_info['experiment_units'] as $experiment_unit)
                                        <option value="{{___encrypt($experiment_unit['id'])}}">
                                            {{$experiment_unit['experiment_unit_name']}}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <span class="text-danger" id="experimentunit_output-error" style="display:none">Experiment unit field is required</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Stream Detail for Flowtype Output</label>
                                    <select id="outputflowlist">
                                        <option value="0">No Stream Found</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12 card tounit">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h6>To Unit</h6>
                                </div>
                                <div>
                                    <button id="toid" type="button" class="close float-left" data-toggle="tooltip" data-placement="top" title="Deselect">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body form-row">
                                <div class="form-group col-md-6">
                                    <label for="chemical">Select Experiment Unit
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Experiment Unit"></i></span>
                                    </label>
                                    <select class="form-control" id="experimentunit_input" onchange="getStreamDataInputOutput(this.value,'input');$('#experimentunit_input-error').hide()">
                                        <option value="0">Select Experiment Unit</option>
                                        @if(!empty($process_experiment_info['experiment_units']))
                                        @foreach($process_experiment_info['experiment_units'] as $experiment_unit)
                                        <option value="{{___encrypt($experiment_unit['id'])}}">
                                            {{$experiment_unit['experiment_unit_name']}}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                    <span class="text-danger" id="experimentunit_input-error" style="display:none">Experiment unit field is required</span>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="">Stream Detail for Flowtype Input</label>
                                    <select class="form-control" id="inputflowlist">
                                        <option value="0">No Stream Found</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12 card product">
                            <label class="control-label">Select Product
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Product"></i></span>
                            </label>
                            <select class="js-example-basic-multiple" id="productid" name="productid[]" multiple="multiple" onchange="$('#productid-error').hide()">
                                @if(!empty($process_experiment_info['products']))
                                @foreach($process_experiment_info['products'] as $product)
                                <option value="{{___encrypt($product['id'])}}">{{$product['name']}}</option>
                                @endforeach
                                @endif
                            </select>
                            <span class="text-danger" id="productid-error" style="display:none">Product field is required</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="saveprocessDiagram()" class="btn btn-sm btn-secondary submit">Submit</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="editprocessdiagram"></div>

<div class="modal fade addflowmodel" tabindex="-1" role="dialog" id="addflowmodel" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Energy Flow</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="process_experiment_name">Energy Stream Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Energy Stream Name"></i></span>
                            </label>
                            <input type="text" class="form-control" id="energy_stream_name" name="energy_stream_name" required placeholder="Enter Energy Stream Name">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="">Select Energy Utility
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Energy Utility"></i></span>
                            </label>
                            <select class="form-control" id="utility_id">
                                <option value="0">Select Energy Utility</option>
                                @if(!empty($process_experiment_info['selectUtilityArr']))
                                @foreach($process_experiment_info['selectUtilityArr'] as $selectUtilityval)
                                <option value="{{___encrypt($selectUtilityval['id'])}}">
                                    {{$selectUtilityval['energy_name']}}
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <br>
                            <br>
                            <div class="custom-control custom-switch ">&nbsp;&nbsp;
                                <input type="checkbox" class="custom-control-input " id="inputoutput">
                                <label class="custom-control-label text-center" for="inputoutput">&nbsp;&nbsp;<span id="ioenenrgy">Input</span></label>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="chemical">Select Experiment Unit
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Experiment Unit"></i></span>
                            </label>
                            <select class="form-control" id="energy_experimentunit_id">
                                <option value="0">Select Experiment Unit</option>
                                @if(!empty($process_experiment_info['experiment_units']))
                                @foreach($process_experiment_info['experiment_units'] as $experiment_unit)
                                <option value="{{___encrypt($experiment_unit['id'])}}">
                                    {{$experiment_unit['experiment_unit_name']}}
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="chemical">Select Stream Flow Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select  Stream Flow Type"></i></span>
                            </label>
                            <select class="form-control" id="energy_flow_type">
                                <option value="0">Select Stream Flow Type </option>
                                @if(!empty($process_experiment_info['flowTypeEnergy']))
                                @foreach($process_experiment_info['flowTypeEnergy'] as $energyflowkey=>$energyflowval)
                                <option value="{{___encrypt($energyflowval['id'])}}">
                                    {{$energyflowval['flow_type_name']}}
                                </option>
                                @endforeach
                                @else
                                <option value="0">No Stream Flow Type Found</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" onclick="saveEnergyFlow()" class="btn btn-sm btn-secondary submit">Submit</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div id="editenergyflow"></div>
<div id="editvariation"></div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
<script src="{{asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
<script src="{{ asset('assets/plugins/ace-builds/ace.js') }}"></script>
<script src="{{ asset('assets/plugins/ace-builds/theme-chaos.js') }}"></script>
@endpush

@push('custom-scripts')
<script type="text/javascript">
    if ($(".js-example-basic-single").length) {
        $(".js-example-basic-single").select2();
    }

    if ($(".js-example-basic-multiple").length) {
        $(".js-example-basic-multiple").select2();
    }

    $('#toid').click(function() {
        $(".tounit").css("display", "");
        $(".fromunit").css("display", "");
        $('#experimentunit_input').val(0);
        $('#experimentunit_output').val(0);
        $('#outputflowlist').html('');
        $('#inputflowlist').html('');
    });

    $('#fromid').click(function() {
        $(".tounit").css("display", "");
        $(".fromunit").css("display", "");
        $('#experimentunit_input').val(0);
        $('#experimentunit_output').val(0);
        $('#outputflowlist').html('');
        $('#inputflowlist').html('');
    });
    var process_experiment_id = '<?php echo ___encrypt($process_experiment_info['id']); ?>';
    var viewflag = "{{$parameters}}";
    var variation_id = "{{!empty($process_experiment_info['variation_id'])?___encrypt($process_experiment_info['variation_id']):''}}";

    function saveCurrentConfig() {
        var fd = new FormData();
        var variation_name = $('#variation_name').val();
        var experiment_id = $('#experiment_id').val();
        var config_description = $('#config_description').val();
        // Check file selected or not
        if (variation_name.length > 0) {
            fd.append('variation_name', variation_name);
            fd.append('experiment_id', experiment_id);
            fd.append('description', config_description);
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/experiment/variation') }}",
                type: 'post',
                data: fd,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success == true) {
                        $('#associated_models_tab').trigger('click')
                        const Toast = Swal.mixin({
                            toast: true,
                            position: "bottom-end",
                            showConfirmButton: false,
                            timer: 5000,
                        });
                        Toast.fire({
                            icon: 'success',
                            title: "Variation Added",
                        });
                        $("#configModal").modal('hide');
                        $('#variation_name').val('');
                        $('#config_description').val('');
                        $('#configuration_view_tab').trigger('click')

                    }
                },
            });
        } else {
            swal.fire({
                text: "Please Enter Variation Name",
                confirmButtonText: 'Close',
                confirmButtonClass: 'btn btn-sm btn-danger',
                width: '350px',
                height: '10px',
                icon: 'warning',
            });
            return false;
        }
    }
    //saveCurrentConfig
    var request_val = "{{!empty(request()->input('variation'))?request()->input('variation'):''}}";
    if (request_val == 'variation') {
        $('#configuration_view_tab').trigger("click");
    } else {
        getprofileView();

    }

    function getprofileView() {
        $('#datarequest_tab').removeClass("reqtab");
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/view_profile') }}",
            method: 'POST',
            data: {
                process_experiment_id: process_experiment_id,
            },
            success: function(result) {
                $('#view_profile_data').html(result.html);
                $('#expprofileSpinner').hide();
                $('#profilebread').html("Experiment Profile");
            }
        });
    }

    function getConfigView() {
        $('#datarequest_tab').removeClass("reqtab");
        $('#expprofileSpinner').show();
        // var viewFlag = "{{!empty($segment4)?$segment4:''}}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/view_configuration') }}",
            method: 'POST',
            data: {
                process_experiment_id: process_experiment_id,
                viewflag: viewflag
            },
            success: function(result) {
                $('#view_config_data').html(result.html);
                $('#expprofileSpinner').hide();
                $('#profilebread').html("Experiment Variation");
            }
        });
    }

    //getDatarequestView

    function getEnergyList() {
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{ url("/experiment/process_exp_energflow") }}',
            method: 'GET',
            data: {
                master: "getdigram",
                process_experiment_id: process_experiment_id,
                variation_id: variation_id,
            },
            success: function(result) {
                $('#energylistId').html('');
                $('#energylistId').html(result.html);
                $('#expprofileSpinner').hide();
            }
        });
    }


    $('#inputoutput').click(function() {
        if ($('#inputoutput').is(':checked')) {
            $('#ioenenrgy').html("Output");
        } else {
            $('#ioenenrgy').html("Input");
        }
    });

    $('#openstream').click(function() {
        if ($('#openstream').is(':checked')) {} else {
            $(".tounit").css("display", "");
            $(".fromunit").css("display", "");
            $('#experimentunit_input').val(0);
            $('#experimentunit_output').val(0);
            $('#outputflowlist').html('');
            $('#inputflowlist').html('');
        }
    });

    function enbleopenstream(value) {
        if (value == "VolejRejNm" || value == "Wpmbk5ezJn" || value == "k8mep2bMyJ") {
            $('#experimentunit_output').val(0);
            $('#outputflowlist').html('');
            $(".fromunit").css("display", "none");
            $('#experimentunit_input').val(0);
            $('#inputflowlist').html('');
            $(".tounit").css("display", "");
            $(".product").css("display", "");
            $('#productid').val('').trigger("change");
        } else if (value == "Opnel5aKBz" || value == "wMvbmOeYAl" || value == "4openRe7Az" || value == "yMYerEdOBQ") {
            $('#experimentunit_input').val(0);
            $('#inputflowlist').html('');
            $(".tounit").css("display", "none");
            $('#experimentunit_output').val(0);
            $('#outputflowlist').html('');
            $(".fromunit").css("display", "");
            $(".product").css("display", "none");
            $('#productid').val('').trigger("change");
            //$("select[id='productid'] option:selected").removeAttr("selected");
        } else {
            $('#experimentunit_input').val(0);
            $('#inputflowlist').html('');
            $(".tounit").css("display", "");
            $('#experimentunit_output').val(0);
            $('#outputflowlist').html('');
            $(".fromunit").css("display", "");
            $(".product").css("display", "none");
            $('#productid').val('').trigger("change");
            $("select[id='productid'] option:selected").removeAttr("selected");
        }
        if (value == "l4zbq2dprO" || value == "WJxbojagwO") {
            document.getElementById("openstream").checked = false;
        } else {
            document.getElementById("openstream").checked = true;
        }
    }

    function saveEnergyFlow() {
        if (process_experiment_id != "") {
            var energy_stream_name = $('#energy_stream_name').val();
            var utility_id = $('#utility_id').val();
            var energy_experimentunit_id = $('#energy_experimentunit_id').val();
            var energy_flow_type = $('#energy_flow_type').val();
            var inputoutput = 0;
            if (document.getElementById("inputoutput").checked == true) {
                inputoutput = 1;
            } else {
                inputoutput = 0;
            }
            if (energy_stream_name == "") {
                swal.fire({
                    text: "Please Enter Energy Stream Name",
                    confirmButtonText: 'Close',
                    confirmButtonClass: 'btn btn-sm btn-danger',
                    width: '350px',
                    height: '10px',
                    icon: 'warning',
                });
                return false;
            }
            if (energy_experimentunit_id == "0") {
                swal.fire({
                    text: "Please Select From Unit Experiment unit",
                    confirmButtonText: 'Close',
                    confirmButtonClass: 'btn btn-sm btn-danger',
                    width: '350px',
                    height: '10px',
                    icon: 'warning',
                });
                return false;
            }
            if (utility_id == "0") {
                swal.fire({
                    text: "Please Select Energy Utility  ",
                    confirmButtonText: 'Close',
                    confirmButtonClass: 'btn btn-sm btn-danger',
                    width: '350px',
                    height: '10px',
                    icon: 'warning',
                });
                return false;
            }
            if (energy_flow_type == "0") {
                swal.fire({
                    text: "Please Select Energy FlowType  ",
                    confirmButtonText: 'Close',
                    confirmButtonClass: 'btn btn-sm btn-danger',
                    width: '350px',
                    height: '10px',
                    icon: 'warning',
                });
                return false;
            }
            var objectexp = {
                "tab": "energyflow",
                "process_experiment_id": process_experiment_id,
                "energy_stream_name": energy_stream_name,
                "utility_id": utility_id,
                "energy_experimentunit_id": energy_experimentunit_id,
                "energy_flow_type": energy_flow_type,
                "inputoutput": inputoutput,
            };
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '{{ url("/experiment/process_exp_energflow") }}',
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
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.errors,
                        })
                    }
                    $("#addflowmodel").modal('hide');
                    $('#energy_stream_name').val('');
                    $('#utility_id').val(0);
                    $('#energy_flow_type').val(0);
                    document.getElementById("inputoutput").checked = false;
                    $('#energy_experimentunit_id').val(0);
                    getEnergyList();
                    $("#energy_flow_tab").addClass("show active");
                },
            });
        }
    }

    $(".deletebulk_diagram").hide();
    $(".deletebulk_en").hide();
</script>
@endpush