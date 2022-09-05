<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div class="d-flex align-items-left flex-wrap text-nowrap">
        <h5 class="mb-3 mb-md-0 text-uppercase font-weight-normal">{{$process_experiment_info['vartion_name']}}</h5>
        @php
        $name=$process_experiment_info['vartion_name'];
        $vid=$process_experiment_info['vartion_id'];
        $expid=$process_experiment_info['experiment_id'];
        $status=$process_experiment_info['vartion_status'];
        @endphp
        <a href="javascript:void(0);" onclick="editVartion('{{$vid}}','{{$expid}}')" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Variation Name">
            <i class="fas fa-edit text-secondary"></i>
        </a>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        @if($process_experiment_info['vartion_status'] == "active")
        <a style="position:absolute;right:0px;top:50px" href="{{url('experiment/experiment/'.($process_experiment_info['vartion_id']).'/sim_config')}}" class="btn btn-sm btn-secondary btn-icon-text mr-0 d-none d-md-block" target="_blank" data-toggle="tooltip" type="button" data-placement="bottom" title="View Simulation Inputs">
            <i class="fas fa-link"></i> &nbsp;Simulation Inputs
            <!-- <i class="fas fa-external-link" aria-hidden="true"></i> -->
        </a>
        @else


        <a style="position:absolute;right:0px;top:50px" href="javascript:void(0);" onclick="statusAlert('{{$name}}')" class="btn btn-sm btn-secondary btn-icon-text mr-0 d-none d-md-block">
            <i class="fas fa-link"></i> &nbsp;Simulation Inputs
            <!-- <i class="fas fa-external-link" aria-hidden="true"></i> -->
        </a>
        @endif
        &nbsp;
        <a style="position:absolute;right:155px;top:50px" href="javascript:void(0);" onclick="VarationView()" class="btn btn-sm btn-secondary btn-icon-text mr-0 d-none d-md-block">
            <i class="fas fa-list"></i> &nbsp;Variation List
        </a>

    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <ul id="list-example1" class="nav nav-tabs nav-tabs-line font-weight-normal" id=" myTab" role="tablist">
            <li class=" nav-item">
                <a class="nav-link show active" id="process_flow_table_tab" data-toggle="tab" href="#process_flow_table" role="tab" aria-controls="process_flow_table" aria-selected="true" onclick="getDiagram()">Process Flow
                    Table</a>
            </li>
            <li class=" nav-item">
                <a class="nav-link" id="process_flow_diagram_tab" data-toggle="tab" href="#process_flow_diagram" role="tab" aria-controls="process_flow_diagram" aria-selected="true" onclick="getDiagramImageView()">Process Flow Diagram</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="unit_specification_tab" data-toggle="tab" href="#unit_specification" role="tab" aria-controls="unit_specification" aria-selected="true" onclick="getMaster()">Unit
                    Specifications</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="model_tab" data-toggle="tab" href="#model" role="tab" aria-controls="model" aria-selected="true" onclick="getModelView()">Model</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="dataset_tab" data-toggle="tab" href="#dataset" role="tab" aria-controls="dataset" aria-selected="true" onclick="getDatasetView()">Dataset</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="datarequest_tab" data-toggle="tab" href="#datarequest" role="tab" aria-controls="datarequest" aria-selected="true" onclick="getDatarequestView()">Model Update</a>
            </li>
            <li class="nav-item" style="display:none;">
                <a class="nav-link" id="energy_flow_tab" data-toggle="tab" href="#energy_flow" role="tab" aria-controls="energy_flow" aria-selected="true" onclick="getEnergyList()">Energy Flow</a>
            </li>
        </ul>
        <div class="tab-content mt-3" id="myTabContent">
            <div class="tab-pane fade show active" id="process_flow_table" role="tabpanel" aria-labelledby="process_flow_table_tab">
                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin float-right">
                    <div class="d-flex align-items-center flex-wrap text-nowrap">
                        @php
                        $per = request()->get('sub_menu_permission');
                        $permission=!empty($per['process_flow_table']['method'])?$per['process_flow_table']['method']:[];
                        @endphp
                        @if($process_experiment_info['viewflag']!="view")
                        @if(in_array("create",$permission))
                        <button type=" button" class="btn btn-sm btn-secondary btn-icon-text mr-0 d-none d-md-block" data-toggle="modal" data-target="#adddiagrammodel">
                            <i class="fas fa-plus"></i>&nbsp;&nbsp; Add Process Stream
                        </button>&nbsp;&nbsp;
                        @endif
                        <div class="deletebulk_diagram" style="display:none;">
                            <button type="button" class="btn btn-sm btn-danger btn-icon-text mr-0 " @if(in_array('delete',$permission)) onclick="bulkdelDiagram()" @else data-request="ajax-permission-denied" @endif>
                                <i class="fas fa-trash"></i>&nbsp;&nbsp; Delete
                            </button>

                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @php
                    $varid=$process_experiment_info['vartion_id'];
                    @endphp
                    <div class="mb-3 grid-margin" id="diagramId">
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="process_flow_diagram" role="tabpanel" aria-labelledby="process_flow_diagram_tab">
                @php
                $per = request()->get('sub_menu_permission');
                $permission=!empty($per['process_flow_diagram']['method'])?$per['process_flow_diagram']['method']:[];
                @endphp
                @if($process_experiment_info['viewflag']!="view")

                <button type="button" style="position:absolute;right:0px;top:50px" class="btn btn-sm btn-secondary btn-icon-text mr-0 mt-0 float-right" data-toggle="tooltip" data-placement="bottom" title="Add" @if(in_array('create',$permission)) onclick="getdiagramImagemodel('{{$varid}}')" @else data-request="ajax-permission-denied" @endif>
                    <i class="fas fa-plus"></i>&nbsp;&nbsp;
                    Add Process Flow Diagram
                </button>&nbsp;
                @endif
                <div id="viewDiagramImage"></div>
            </div>
            <div class="tab-pane fade" id="unit_specification" role="tabpanel" aria-labelledby="unit_specification_tab">
                <!---  start master and expierment unit tabs-->
                <div class="row">
                    <div class="col-md-2">
                        <div class="nav nav-tabs nav-tabs-vertical unit_specification_scroll" id="v-tab" role="tablist" aria-orientation="vertical">
                            <a class="nav-link active masternav" onclick='getMaster()' id="v-expdata-tab" data-toggle="pill" href="#v-expdata" role="tab" aria-controls="v-expdata" aria-selected="true">Master Data</a>
                            @if(!empty($process_experiment_info['experiment_units']))
                            @foreach($process_experiment_info['experiment_units'] as $experiment_unit)
                            <?php $experiment_unit_id = ___encrypt($experiment_unit['experiment_equipment_unit']['id']);
                            $unit_name = $experiment_unit['experiment_unit_name'];
                            $tab_id = ___encrypt($experiment_unit['id']);
                            ?>
                            <a class="nav-link profilenav" onclick='testing("{{$experiment_unit_id}}","{{$tab_id}}")' id="v-expdata-tab" data-toggle="pill" href="#v-expdata" role="tab" aria-controls="v-expdata" aria-selected="true">{{$experiment_unit['experiment_unit_name']}}</a>
                            @endforeach
                            @endif
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="tab-content tab-content-vertical border p-3" id="v-tabContent">
                            <div class="mb-3 grid-margin" id="setData"></div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-2 text-right ">
                        <input type="hidden" id="setexpcon" value="1" />
                        @php
                        $unit_permission=!empty($per['unit_specification']['method'])?$per['unit_specification']['method']:[];
                        @endphp
                        @if($process_experiment_info['viewflag']!="view")
                        @if(in_array('edit',$unit_permission))
                        <button type="button " onclick="saveUnitExp()" class="btn btn-sm btn-secondary submit">Submit</button>
                        <!-- <button type="reset" class="btn btn-danger btn-sm">Cancel</button> -->
                        @endif
                        @endif
                    </div>
                </div>
                <!---  end master and expierment unit tabs-->
            </div>
            <div class="tab-pane fade" id="model" role="tabpanel" aria-labelledby="model_tab">
                <div id="viewmodel">
                </div>
            </div>
            <div class="tab-pane fade" id="dataset" role="tabpanel" aria-labelledby="dataset_tab">
                <div class="card-body mb-3 grid-margin" id="viewdataset">
                </div>
            </div>
            <div class="tab-pane fade" id="datarequest" role="tabpanel" aria-labelledby="datarequest_tab">
                <div class="card-body mb-3 grid-margin" id="viewdatarequest">
                </div>
            </div>
            <div class="tab-pane fade " id="energy_flow" role="tabpanel" aria-labelledby="energy_flow_tab">
                <div class="row">
                    <div class="col-md-12 card shadow">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-3 mb-md-0 text-uppercase font-weight-normal">
                                    Energy Flows
                                </h5>
                            </div>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="energylistId"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="diagramImageModel"></div>

<script>
    var vartion_id = "{{$process_experiment_info['vartion_id']}}";
    var vartion_name = "{{$process_experiment_info['vartion_name']}}";
    var experiment_id = "{{$process_experiment_info['experiment_id']}}";
    var experiment_unit_id = '<?php echo $experiment_unit_id; ?>';
    getDiagram();

    function VarationView() {
        $('#configuration_view_tab').trigger('click')
    }

    function getdiagramImagemodel(id) {
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{url("/experiment/process_diagram/getimgmodel") }}',
            method: 'post',
            data: {
                id: id
            },
            success: function(result) {
                $("#diagramImageModel").html(result.html);
                $('#expprofileSpinner').hide();
                $("#diagramimage" + id).modal('show');
            }
        });
    }

    function getDiagramImageView() {
        $('#datarequest_tab').removeClass("reqtab");
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: '{{ url("/experiment/process_diagram/getDiagramImageView") }}',
            method: 'post',
            data: {
                master: "getDiagramImageView",
                vartion_id: vartion_id,
                viewflag: viewflag
            },
            success: function(result) {
                $('#viewDiagramImage').html('');
                $('#viewDiagramImage').html(result.html);
                $('#expprofileSpinner').hide();
            }
        });
    }

    function getDiagram() {
        $('#datarequest_tab').removeClass("reqtab");
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
                process_experiment_id: experiment_id,
                vartion_id: vartion_id,
                viewflag: viewflag
            },
            success: function(result) {
                $('#diagramId').html('');
                $('#diagramId').html(result.html);
                $('#expprofileSpinner').hide();
            }
        });
    }

    function getMaster() {
        $('#datarequest_tab').removeClass("reqtab");
        document.getElementById('setexpcon').value = 1;
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
                process_experiment_id: experiment_id,
                vartion_id: vartion_id
            },
            success: function(result) {
                $('#setData').html('');
                $('#setData').html(result.html);
                $('#expprofileSpinner').hide();
                $('.profilenav').removeClass("active");
                $('.masternav').addClass("active");
            }
        });
    }

    function testing(experiment_unit_id, unit_tab) {
        $('#datarequest_tab').removeClass("reqtab");
        document.getElementById('setexpcon').value = 2;
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
                vartion_id: vartion_id
            },
            success: function(result) {
                $('#setData').html(result.html);
                $('#expprofileSpinner').hide();

            }
        });
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
            var products = $("select[name='productid[]']")
                .map(function() {
                    return $(this).val();
                }).get();
            if (process_stream_name == "") {
                $('#process_stream_name-error').show();
                return false;
            }
            if (mass_flow_type_id == 0) {
                $('#process_flowtuye-error').show();
                return false;
            }
            if (mass_flow_type_id == "VolejRejNm" || mass_flow_type_id == "Wpmbk5ezJn" || mass_flow_type_id == "k8mep2bMyJ") {
                if (experimentunit_input == 0) {
                    $('#experimentunit_input-error').show();
                    return false;
                }
                if (products == "") {
                    $('#productid-error').show();
                    return false;
                }
            } else if (mass_flow_type_id == "Opnel5aKBz" || mass_flow_type_id == "wMvbmOeYAl" || mass_flow_type_id == "4openRe7Az" || mass_flow_type_id == "yMYerEdOBQ") {
                if (experimentunit_output == 0) {
                    $('#experimentunit_output-error').show();
                    return false;
                }
            } else {
                if (experimentunit_input == 0) {
                    $('#experimentunit_input-error').show();
                    return false;
                }
                if (experimentunit_output == 0) {
                    $('#experimentunit_output-error').show();
                    return false;
                }
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
                "vartion_id": vartion_id,
                "products": products
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
                        $('#productid').val('').trigger("change");
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
                    $("#process_flow_table_tab").addClass("show active");
                },
            });
        }
    }

    function getStreamDataInputOutput(value, type) {
        if (type == "output") {
            if (value != 0 && $('#openstream').is(':checked')) {
                $('#experimentunit_input').val(0);
                $('#inputflowlist').html('');
                $(".tounit").css("display", "none");
            }
            if (value == "0") {
                $('#outputflowlist').html('');
                return false
            }
        }
        if (type == "input") {
            if (value != 0 && $('#openstream').is(':checked')) {
                $('#experimentunit_output').val(0);
                $('#outputflowlist').html('');
                $(".fromunit").css("display", "none");
            }
            if (value == "0") {
                $('#inputflowlist').html('');
                return false
            }
        }
        if (value == "0") {
            return false;
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
                tab: type,
                vartion_id: vartion_id,
                flag: 'add'
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

    function productConditionmaster() {
        if (process_experiment_id != "") {
            var master_conditions = [];
            var master_conditions = $('#condition_masterid').val();
            var variation_id = $('#variation_id').val();
            var master_outcomes = $('#outcome_masterid').val();
            var master_reaction = $('#reaction_masterid').val();
            var objectexp = {
                "process_experiment_id": process_experiment_id,
                "variation_id": variation_id,
                "tab": "condition",
                "master_conditions": master_conditions,
                "master_outcomes": master_outcomes,
                "master_reaction": master_reaction,
                "vartion_id": vartion_id
            };
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '{{ url("/experiment/experimentProfile/saveprofilemaster") }}',
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
                },
            });
        }
    }
</script>