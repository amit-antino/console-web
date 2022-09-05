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
//$per = request()->get('sub_menu_permission');
//$permission=!empty($per['variation']['method'])?$per['variation']['method']:[];
$permission=['create','edit','index','manage'];
@endphp
<div class="d-flex justify-content-between align-items-center">
    <div>
        <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/mfg_process/simulation') }}">Process Simulation</a></li>
            <li class="breadcrumb-item active" aria-current="page">Process Simulation Profile - <b>{{$data['edit']['process_name']}}</b></li>
        </ol>
        </nav>
    </div>
    <div class="mb-3 d-flex align-items-center flex-wrap text-nowrap mr-2">
        <p class="mr-2 card-text text-muted ">Last updated
            {{___ago($data['edit']['updated_at'])}}
        </p>
        <p class="mr-2 font-weight-normal">Status:
            <span class="badge badge-info font-weight-normal">{{ucfirst($data['edit']['status'])}}</span>
        </p>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">

                    </div>
                    <div class="col-md-12">
                        <ul id="list-example" class="nav nav-tabs grid-margin font-weight-normal" id=" myTab" role="tablist">
                            <li class=" nav-item">
                                <a class="nav-link show active" id="profile_tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true" onclick="getprofileView();set_url('#profile')">Profile</a>
                            </li>
                            <li class=" nav-item">
                                <a class="nav-link" id="configuration_view_tab" data-toggle="tab" href="#configuration_view" role="tab" aria-controls="configuration_view" aria-selected="true" onclick="getConfigView();set_url('#config')">Process Datasets</a>
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
                                <div class="mb-3 grid-margin form-row" id="view_profile_data">
                                    <div class="form-group col-md-6">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label class="control-label">Process Type: <span class="badge badge-info">{{$data['processtype']}}</span></label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="control-label">Process Category: <span class="badge badge-info">{{$data['processCategory']}}</span></label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="control-label">Main Feedstock: <span class="badge badge-info">{{$data['feed']}}</span></label>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="control-label">Main Products: <span class="badge badge-info">{{$data['main_product']}}</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div class="form-row">
                                            <div class="form-group col-md-12">
                                                <label class="control-label">Selected Products:
                                                    @if(!empty($data['productName']))
                                                    @foreach($data['productName'] as $pn)
                                                    <span class="badge badge-info">{{$pn}}</span>
                                                    @endforeach
                                                    @endif
                                                </label>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label class="control-label">Selected Energy Utilities:
                                                    @if(!empty($data['utilityName']))
                                                    @foreach($data['utilityName'] as $un)
                                                    <span class="badge badge-info"> {{$un}} </span>
                                                    @endforeach
                                                    @endif
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="control-label">Tags</label>
                                        @if(!empty($data['edit']['tags']))
                                        @foreach($data['edit']['tags'] as $tag)
                                        <span class="badge badge-info">{{$tag}}</span>
                                        @endforeach
                                        @endif
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="description">Description</label>
                                        <textarea disabled name="description" id="description" rows="5" class="form-control">{{$data['edit']['description']}}</textarea>
                                    </div>
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

    var process_id = '<?php echo ___encrypt($data['edit']['id']); ?>';
    //var viewflag = 'php echo //$process_experiment_info['viewflag']; ?>';
    //var config_id = "{{!empty($process_experiment_info['config_id'])?___encrypt($process_experiment_info['config_id']):''}}";

    
    //saveCurrentConfig
    getprofileView();

    function getprofileView() {
        $('#expprofileSpinner').show();
        $('#expprofileSpinner').hide();
        $('#profilebread').html("Experiment Profile");
    }

    function set_url(tab){
        location.hash = tab;
    }

    function getConfigView() {
        debugger;
        viewflag = '{{$data["viewflag"]}}'
        $('#datarequest_tab').removeClass("reqtab");
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/mfg_process/simulation/') }}/"+process_id+"/dataset",
            method: 'get',
            data:{
                viewflag:viewflag
            },
            success: function(result) {
                $('#view_config_data').html(result.html);
                $('#expprofileSpinner').hide();
                $('#profilebread').html("Process Datasets");
            }
        });
    }

    function getModelView() {
        $('#datarequest_tab').removeClass("reqtab");
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/view_associate_model') }}",
            method: 'POST',
            data: {
                process_experiment_id: process_experiment_id,
                viewflag: viewflag
            },
            success: function(result) {
                $('#viewmodel').html(result.html);
                $('#expprofileSpinner').hide();
            }
        });
    }

    function getDatasetView() {
        $('#datarequest_tab').removeClass("reqtab");
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/view_dataset') }}",
            method: 'POST',
            data: {
                process_experiment_id: process_experiment_id,
                viewflag: viewflag
            },
            success: function(result) {
                $('#viewdataset').html(result.html);
                $('#expprofileSpinner').hide();
            }
        });
    }

    function getDatarequestView() {
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/view_datarequest') }}",
            method: 'POST',
            data: {
                process_experiment_id: process_experiment_id,
                viewflag: viewflag
            },
            success: function(result) {
                $('#viewdatarequest').html(result.html);
                $('#expprofileSpinner').hide();
            }
        });
    }

    function requestModel() {
        $("#datarequest_tab").trigger("click");
        $('#datarequest_tab').addClass("reqtab");
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
                config_id: config_id,
            },
            success: function(result) {
                $('#energylistId').html('');
                $('#energylistId').html(result.html);
                $('#expprofileSpinner').hide();
            }
        });
    }

    function saveUnitExp() {
        let id = document.getElementById('setexpcon').value;
        if (id == 2) {
            productCondition();
        } else {
            productConditionmaster();
        }
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
        } else if (value == "Opnel5aKBz" || value == "wMvbmOeYAl" || value == "4openRe7Az" || value == "yMYerEdOBQ") {
            $('#experimentunit_input').val(0);
            $('#inputflowlist').html('');
            $(".tounit").css("display", "none");
            $('#experimentunit_output').val(0);
            $('#outputflowlist').html('');
            $(".fromunit").css("display", "");
        } else {
            $('#experimentunit_input').val(0);
            $('#inputflowlist').html('');
            $(".tounit").css("display", "");
            $('#experimentunit_output').val(0);
            $('#outputflowlist').html('');
            $(".fromunit").css("display", "");
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

    if(location.hash=='#config'){
        $('#configuration_view_tab').trigger('click');
    }
</script>
@endpush
