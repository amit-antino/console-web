@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
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
    }
</style>
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/experiment/experiment') }}">Experiments</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/experiment/experiment/'.___encrypt($process_experiment_info['id']).'/manage') }}">{{$process_experiment_info['name']}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Variation -
            {{$process_experiment_info['config_name']}}
        </li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Variation :
                        {{$process_experiment_info['config_name']}}
                    </h5>
                </div>
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    <h5 class="mr-2 text-uppercase font-weight-normal">Status: <span class="badge badge-info">{{ucfirst($process_experiment_info['status'])}}</span></h5>
                    <a href="{{ url('/experiment/experiment/'.___encrypt($process_experiment_info['id']).'/manage') }}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" data-toggle="tooltip" data-placement="bottom" title="Edit Experiment">
                        <i class="btn-icon-prepend" data-feather="edit"></i>
                        Manage Profile
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="text-center">
                            <div id="expprofileSpinner" class="spinner-border text-secondary" style="width: 2rem; height: 2rem;display: none; margin-top:25px;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <p class="card-text float-right"><small class="text-muted">Last updated
                                {{___ago($process_experiment_info['updated_at'])}}</small></p>
                        <br>
                        <hr>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Variation</h5><br>
                            </div>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <!-- <button type="button" class="btn btn-sm btn-info mr-2 d-none d-md-block" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                    View Variations
                                </button> -->
                                <a href="{{ url('/experiment/experiment/'.___encrypt($process_experiment_info['id']).'/manage/'.___encrypt($process_experiment_info['variation_id']).'/edit') }}" class="btn btn-sm btn-secondary mr-2 d-none d-md-block">
                                    Edit Variation
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="early_data" name="early_data">
                            <div class="example card shadow-sm">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <div>
                                        <ul id="list-example1" class="nav nav-tabs card-header-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link show active" id="process_flow_diagram_tab" data-toggle="tab" href="#process_flow_diagram" role="tab" aria-controls="process_flow_diagram" aria-selected="true" onclick="getDiagram()">Process Flow Diagram</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="unit_specification_tab" data-toggle="tab" href="#unit_specification" role="tab" aria-controls="unit_specification" aria-selected="true" onclick="getMaster()">Unit Specifications</a>
                                            </li>
                                            <!-- <li class="nav-item">
                                                <a class="nav-link" id="energy_flow_tab" data-toggle="tab" href="#energy_flow" role="tab" aria-controls="energy_flow" aria-selected="true" onclick="getEnergyList()">Energy Flow</a>
                                            </li> -->
                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content profile-tab" id="myTabContent">
                                        <div class="tab-pane fade show active" id="process_flow_diagram" role="tabpanel" aria-labelledby="process_flow_diagram_tab">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <div>
                                                    <h5 class="mb-3 mb-md-0 text-uppercase font-weight-normal">
                                                        Process Flow Diagram
                                                    </h5>
                                                </div>
                                                <div class="d-flex align-items-center text-nowrap">
                                                    <button type="button" class="btn btn-sm btn-info mr-2 d-none d-md-block" data-toggle="collapse" data-target="#flowdiagram" aria-expanded="false" aria-controls="flowdiagram">
                                                        View Process Flow Diagram
                                                    </button>
                                                    <!-- <button type="button" class="btn btn-sm btn-secondary mr-2 d-none d-md-block" data-toggle="modal" data-target="#adddiagrammodel">
                                                        Add Process Stream Details
                                                    </button> -->
                                                    <div class="deletebulk_diagram">
                                                        <button type="button" data-url="{{ url('/experiment/process_diagram/bulk-delete') }}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" data-name="_diagram" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
                                                            <i class="btn-icon-prepend" data-feather="trash"></i>Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="collapse" id="flowdiagram">
                                                    <img src="{{asset('assets/images/h2pro.png')}}" alt="Image" class="img-fluid" height="600" width="1000" />
                                                </div>
                                                <div id="diagramId">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="unit_specification" role="tabpanel" aria-labelledby="unit_specification_tab">
                                            <!---  start master and expierment unit tabs-->
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="nav nav-tabs nav-tabs-vertical unit_specification_scroll" id="v-tab" role="tablist" aria-orientation="vertical">
                                                        <a class="nav-link active masternav" onclick='getMaster()' id="v-expdata-tab" data-toggle="pill" href="#v-expdata" role="tab" aria-controls="v-expdata" aria-selected="true">Master Data</a>
                                                        @if(!empty($process_experiment_info['experiment_units']))
                                                        @foreach($process_experiment_info['experiment_units'] as
                                                        $experiment_unit)
                                                        <?php $experiment_unit_id = ___encrypt($experiment_unit['experiment_equipment_unit']['id']);
                                                        $unit_name = $experiment_unit['experiment_unit_name'];
                                                        $tab_id = ___encrypt($experiment_unit['id']);
                                                        ?>
                                                        <a class="nav-link profilenav" onclick='testing("{{$experiment_unit_id}}","{{$tab_id}}")' id="v-expdata-tab" data-toggle="pill" href="#v-expdata" role="tab" aria-controls="v-expdata" aria-selected="true">{{$experiment_unit['experiment_unit_name']}}</a>
                                                        @endforeach
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-9">
                                                    <div class="tab-content tab-content-vertical border p-3" id="v-tabContent">
                                                        <div id="setData"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!---  end master and expierment unit tabs-->
                                        </div>
                                        <!-- <div class="tab-pane fade " id="energy_flow" role="tabpanel" aria-labelledby="energy_flow_tab">
                                            <div class="row">
                                                <div class="col-md-12 card shadow">
                                                    <div class="card-header d-flex justify-content-between align-items-center">
                                                        <div>
                                                            <h5 class="mb-3 mb-md-0">
                                                                Energy Flows
                                                            </h5>
                                                        </div>
                                                        <div class="d-flex align-items-center flex-wrap text-nowrap">
                                                            <button type="button" class="btn btn-sm btn-secondary mr-2 d-none d-md-block" data-toggle="modal" data-target="#addflowmodel">
                                                                Add Energy Flow
                                                            </button>
                                                            <div class="deletebulk_en">
                                                                <button type="button" data-url="{{ url('/experiment/process_exp_energflow/bulk-delete') }}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" data-name="_en" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
                                                                    <i class="btn-icon-prepend" data-feather="trash"></i>Delete
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="energylistId"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
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
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script type="text/javascript">
    $('#view_config').DataTable();

    $(function() {
        $("#example-select-all_diagram").click(function() {
            if ($(this).is(":checked")) {
                $(".deletebulk_diagram").show();
            } else {
                $(".deletebulk_diagram").hide();
            }
            $('.checkSingle_diagram').not(this).prop('checked', this.checked);
            $('.checkSingle_diagram').click(function() {
                if ($('.checkSingle_diagram: checked ').length == $('.checkSingle_diagram')
                    .length) {
                    $('#example-select-all_diagram').prop('checked', true);
                } else {
                    $('#example-select-all_diagram').prop('checked', false);
                }
            });
        });
        
        $('.checkSingle_diagram').click(function() {
            var len = $("[name='select_all_diagram[]']:checked").length;
            if (len > 1) {
                $(".deletebulk_diagram").show();
            } else {
                $(".deletebulk_diagram").hide();
            }
        });
    });

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
    var experiment_unit_id = '<?php echo $experiment_unit_id; ?>';
    var variation_id =
        "{{!empty($process_experiment_info['variation_id'])?___encrypt($process_experiment_info['variation_id']):''}}";

    function getStreamDataInputOutput(value, type) {
        if (type == "output") {
            if (value != 0 && $('#openstream').is(':checked')) {
                $('#experimentunit_input').val(0);
                $('#inputflowlist').html('');
                $(".tounit").css("display", "none");
            } else {
                $(".tounit").css("display", "");
            }
        }
        if (type == "input") {
            if (value != 0 && $('#openstream').is(':checked')) {
                $('#experimentunit_output').val(0);
                $('#outputflowlist').html('');
                $(".fromunit").css("display", "none");
            } else {
                $(".fromunit").css("display", "");
            }
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/getstreamdata/') }}",
            method: 'GET',
            data: {
                experiment_unit_id: value,
                process_experiment_id: process_experiment_id,
                tab: type
            },
            success: function(result) {
                obj = JSON.parse(result);
                objcnt = Object.keys(obj.streams).length;
                if (obj.flowtype == "input") {
                    var html = "";
                    if (objcnt != 0) {
                        for (i in obj.streams) {
                            html += '<option value="' + obj.streams[i]['input_stream_id'] + '">';
                            html += obj.streams[i]['stream_name'];
                            html += '</option>';
                        }
                    } else {
                        html += '<option value="0">';
                        html += "No Streams Found";
                        html += '</option>';
                    }
                    $('#inputflowlist').html(html);
                }
                if (obj.flowtype == "output") {
                    var htmloutput = "";
                    if (objcnt != 0) {
                        for (x in obj.streams) {
                            htmloutput += '<option value="' + obj.streams[x]['output_stream_id'] + '">';
                            htmloutput += obj.streams[x]['stream_name'];
                            htmloutput += '</option>';
                        }
                    } else {
                        htmloutput += '<option value="0">';
                        htmloutput += "No Streams Found";
                        htmloutput += '</option>';
                    }
                    $('#outputflowlist').html(htmloutput);
                }
            }
        })
    }

    function testing(experiment_unit_id, unit_tab) {
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/exp_profile/') }}",
            method: 'GET',
            data: {
                experiment_unit_id: experiment_unit_id,
                process_experiment_id: process_experiment_id,
                unit_tab_id: unit_tab,
                variation_id: variation_id
            },
            success: function(result) {
                $('#setData').html(result.html);
                $('#expprofileSpinner').hide();

            }
        });
    }

    getDiagram();

    function getDiagram() {
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{ url("/experiment/process_diagram") }}',
            method: 'GET',
            data: {
                master: "getdigram",
                process_experiment_id: process_experiment_id,
                variation_id: variation_id,
            },
            success: function(result) {
                $('#diagramId').html('');
                $('#diagramId').html(result.html);
                $('#expprofileSpinner').hide();
            }
        });
    }

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

    function getMaster() {
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/exp_profile_master/') }}",
            method: 'GET',
            data: {
                master: "master",
                process_experiment_id: process_experiment_id,
                variation_id: variation_id,
            },
            success: function(result) {
                $('#setData').html('');
                $('#setData').html(result.html);
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
        if (value == "l4zbq2dprO" || value == "WJxbojagwO") {
            document.getElementById("openstream").checked = false;
        } else {
            document.getElementById("openstream").checked = true;
        }
    }

    function saveprocessDiagram() {
        if (process_experiment_id != "") {
            var process_stream_name = $('#process_stream_name').val();
            var mass_flow_type_id = $('#process_flowtuye').val();
            var experimentunit_input = $('#experimentunit_input').val();
            var experimentunit_output = $('#experimentunit_output').val();
            var openstream = 0;
            if (document.getElementById("openstream").checked == true) {
                openstream = 1;
            } else {
                openstream = 0;
            }
            var inputstreamvalue = $('#inputflowlist').val();
            var outputstreamvalue = $('#outputflowlist').val();
            var inputstreamtext = $("#inputflowlist option:selected").text();
            var outputstreamtext = $("#outputflowlist option:selected").text();
            if (process_stream_name == "") {
                swal.fire({
                    text: "Please Enter Stream Name",
                    confirmButtonText: 'Close',
                    confirmButtonClass: 'btn btn-sm btn-danger',
                    width: '350px',
                    height: '10px',
                    icon: 'warning',
                });
                return false;
            }
            if (experimentunit_input == "0" && experimentunit_output == "0") {
                swal.fire({
                    text: "Please Select  Unit Experiment unit",
                    confirmButtonText: 'Close',
                    confirmButtonClass: 'btn btn-sm btn-danger',
                    width: '350px',
                    height: '10px',
                    icon: 'warning',
                });
                return false;
            }
            if ($("#experimentunit_input option:selected").text()) {
                var experimentunit_input_text = $("#experimentunit_input option:selected").text();
            } else {
                var experimentunit_input_text = "";
            }
            if ($("#experimentunit_output option:selected").text()) {
                var experimentunit_output_text = $("#experimentunit_output option:selected").text();
            } else {
                var experimentunit_output_text = "";
            }
            var variation_id = $("#variation_id").val();
            var objectexp = {
                "tab": "process_diagram",
                "process_experiment_id": process_experiment_id,
                "process_stream_name": process_stream_name,
                "experimentunit_input": experimentunit_input,
                "experimentunit_output": experimentunit_output,
                "mass_flow_type_id": mass_flow_type_id,
                "inputstreamvalue": inputstreamvalue,
                "outputstreamvalue": outputstreamvalue,
                "openstream": openstream,
                "experimentunit_input_text": experimentunit_input_text,
                "experimentunit_output_text": experimentunit_output_text,
                "inputstreamtext": inputstreamtext,
                "outputstreamtext": outputstreamtext,
                "variation_id": variation_id
            };
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '{{ url("/experiment/process_diagram") }}',
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
                    $("#adddiagrammodel").modal('hide');
                    $('#process_stream_name').val('');
                    $('#process_flowtuye').val(0);
                    $('#experimentunit_input').val(0);
                    $('#experimentunit_output').val(0);
                    document.getElementById("openstream").checked = false;
                    $('#outputflowlist').html('');
                    $('#inputflowlist').html('');
                    $(".tounit").css("display", "");
                    $(".fromunit").css("display", "");
                    getDiagram();
                    $("#process_flow_diagram_tab").addClass("show active");
                },
            });
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