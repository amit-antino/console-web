@extends('layout.console.master')
@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush
<style>
    .add_more_button_align {
        margin-top: 30px;
    }
</style>
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{url('/dashboard')}}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{url('/experiment/experiment')}}">Experiments</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{url('/experiment/experiment/'.___encrypt($variation->experiment_id).'/manage')}}">
                Variations
            </a>
            - {{$variation->name}}
        </li>
        @if(empty($apply_config))
        <li class="breadcrumb-item active">Simulation Input Excel Template</li>
        @endif
    </ol>
</nav>
@if(empty($apply_config))
<div class="row">
    <div class="col-md-12 mb-3">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    Simulation Input Excel Template: <span> {{!empty($variation->name)?$variation->name:''}}</span>
                </div>
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    <button type="button" class="btn btn-sm btn-secondary  btn-icon-text mr-2 d-none d-md-block" id="configModal_popup" data-toggle="modal" data-target="#configModal">
                        <i class="fas fa-save"></i> Create Simulation Input Excel Template
                    </button>
                    <a href="{{url('/experiment/experiment/'.___encrypt($variation->id).'/sim_config')}}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
                        <i class="fas fa-save"></i> Simulation Input
                    </a>
                    <div class="deletebulk">
                        <button type="button" data-url="{{ url('/experiment/experiment/sim_excel_config/bulk-delete') }}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
                            <i class="fas fa-trash"></i>&nbsp;&nbsp;Delete
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="view_config" class="table font-weight-normal">
                                <thead>
                                    <th><input type="checkbox" id="example-select-all"></th>
                                    <th>Template Name</th>
                                    <th>Forward Log</th>
                                    <th>Reverse Log</th>
                                    <th>Created By</th>
                                    <th>Created Date</th>
                                    <th>Updated By</th>
                                    <th>Updated Date</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </thead>
                                <tbody class="font-weight-normal">
                                    @php
                                    $cnt = count($data)
                                    @endphp
                                    @if(!empty($data))
                                    @foreach($data as $template)
                                    <tr>
                                        <td><input type="checkbox" value="{{___encrypt($template['id'])}}" class="checkSingle" name="select_all[]"></td>
                                        <td>{{$template['template_name']}}</td>
                                        <td><a onclick="importedReport('forward',<?php echo $template['id']; ?>)">{{sizeof($template['forwardlog'])}}</a></td>
                                        <td><a onclick="importedReport('reverse',<?php echo $template['id']; ?>)">{{sizeof($template['reverselog'])}}</a></td>
                                        <td>{{get_user_name($template['created_by'])}}</td>
                                        <td>{{dateTimeFormate($template['created_at'])}}</td>
                                        <td>{{get_user_name($template['updated_by'])}}</td>
                                        <td>{{dateTimeFormate($template['updated_at'])}}</td>
                                        <td class="text-center">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" data-url="{{url('experiment/experiment/'.___encrypt($template['id']).'/sim_excel_config_delete?status='.$template['status'])}}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you Change Status ?" class="custom-control-input" id="customSwitch{{___encrypt($template['id'])}}" @if($template['status']=='active' ) checked @endif>
                                                <label class="custom-control-label" for="customSwitch{{___encrypt($template['id'])}}"></label>
                                            </div>
                                        </td>
                                        @php
                                        $reverse=[];
                                        $forward=[];
                                        @endphp
                                        @if(!empty($template->raw_material))
                                        @foreach(json_decode($template->raw_material) as $key => $raw_data)
                                        @if($key=='forward')
                                        @php $forward = !empty($raw_data)?$raw_data:[];@endphp
                                        @endif
                                        @if($key=='reverse')
                                        @php $reverse = !empty($raw_data)?$raw_data:[];@endphp
                                        @endif
                                        @endforeach
                                        @endif
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a href="javascript:void(0);" data-url="{{url('experiment/experiment/'.___encrypt($variation->id).'/sim_excel_config/'.___encrypt($template['id']).'/edit')}}" data-request="ajax-popup" data-target="#edit-div" data-tab="#editcategoryModal{{___encrypt($template['id'])}}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Simulation Input Excel Template Name">
                                                    <i class="fas fa-edit text-secondary"></i>
                                                </a>
                                                <a href="{{url('experiment/experiment/sim_excel_config/'.___encrypt($template['id']).'/manage')}}" type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Simulation Input Excel Template Data">
                                                    <i class="fas fa-eye text-secondary"></i>
                                                </a>&nbsp;
                                                @if($template['simulate_id']==0)
                                                <a href="#" type="button" class="btn btn-icon dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Download Simulation Input Excel Template Data">
                                                    <i class="fas fa-download text-secondary"></i>
                                                </a>&nbsp;
                                                @else
                                                <a href="{{ url('experiment/experiment/sim_excel_config/'.___encrypt($template['id']).'/download_with_data') }}" type="button" class="btn btn-icon" title="Download Simulation Input Excel Template With Data">
                                                    <i class="fas fa-download text-secondary"></i>
                                                </a>&nbsp;
                                                @endif
                                                @php
                                                $checked_template = templateUsed($template['id']);
                                                @endphp
                                                @if(empty($checked_template))
                                                <a href="javascript:void(0);" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-url="{{url('experiment/experiment/'.___encrypt($template['id']).'/sim_excel_config_delete')}}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete Simulation Input Excel Template Data">
                                                    <i class="fas fa-trash text-secondary"></i>
                                                </a>&nbsp;&nbsp;
                                                @endif
                                                <div class="dropdown-menu">
                                                    @if(!empty($forward))
                                                    <a class="dropdown-item" href="{{ url('experiment/experiment/sim_excel_config/'.___encrypt($template['id']).'/download/forward') }}">Forward</a>
                                                    @else
                                                    <a class="dropdown-item" onclick="alterMsg()">Forward</a>
                                                    @endif

                                                    @if(!empty($reverse))
                                                    <a class="dropdown-item" href="{{ url('experiment/experiment/sim_excel_config/'.___encrypt($template['id']).'/download/reverse') }}">Reverse</a>
                                                    @else
                                                    <a class="dropdown-item" onclick="alterMsg()">Reverse</a>
                                                    @endif
                                                </div>
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
</div>
@endif
<div class="modal fade bd-example-modal-lg" id="configModal" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ url('/experiment/experiment/simulation_excel_config_store') }}" method="POST" role="process_config">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase font-weight-normal" id="userLabel">Create Simulation Input Excel Template
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="variation_id" value="{{___encrypt($variation->id)}}">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Template Name
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Template Name"></i></span>
                            </label>
                            <input type="text" id="name" name="template_name" class="form-control" value="" placeholder="Template Name">
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Description"></i></span>
                            </label>
                            <textarea name="description" id="description" rows="5" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="process_config"]' class="btn btn-sm btn-secondary submit">Submit</button>
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!---imported log report--->
<div class="modal fade bd-example-modal-lg" id="importedreport" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ url('/experiment/experiment/simulation_excel_config_store') }}" method="POST" role="process_config">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase font-weight-normal" id="userLabel">Imported Report
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="importedData">
                    <table class="table font-weight-normal">
                        <thead>
                            <tr>
                                <th>File</th>
                                <th>Total</th>
                                <th>Imported</th>
                                <th>Pending</th>
                                <th>Status</th>
                                <th>Uploaded Date</th>
                            </tr>
                        </thead>
                        <tbody id="logData">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer text-right">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!------End imported log report------>
<div id="edit-div"></div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js')}}"></script>

<script src="{{ asset('/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script type="text/javascript">
    function importedReport(type, template_id) {
        $("#importedreport").modal();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/simulation-input-imported-report') }}",
            method: 'POST',
            data: {
                template_id: template_id,
                type: type
            },
            success: function(result) {
                $("#logData").html(result);
            }
        })
    }

    function getoutputmodal() {
        $('.testmodal').show();
    }

    var cnt = '{{$cnt}}';
    $(function() {
        'use strict';
        if (cnt > 10) {
            $('#view_config').DataTable({
                "iDisplayLength": 100,
                "language": {
                    search: ""
                }
            });
            $('#view_config').each(function() {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Search');
                search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
            });
        }

    });

    $(".deletebulk").hide();
    $("#example-select-all").click(function() {
        if ($(this).is(":checked")) {
            $(".deletebulk").show();
        } else {
            $(".deletebulk").hide();
        }
        $('.checkSingle').not(this).prop('checked', this.checked);
        $('.checkSingle').click(function() {
            if ($('.checkSingle:checked').length == $('.checkSingle').length) {
                $('#example-select-all').prop('checked', true);
            } else {
                $('#example-select-all').prop('checked', false);
            }
        });
    });
    $('.checkSingle').click(function() {
        var len = $("[name='select_all[]']:checked").length;
        if (len > 1) {
            $(".deletebulk").show();
        } else {
            $(".deletebulk").hide();
        }
        if ($('.checkSingle:checked').length == $('.checkSingle').length) {
            $('#example-select-all').prop('checked', true);
        } else {
            $('#example-select-all').prop('checked', false);
        }
    });

    async function saveData() {
        let result;
        report_name = document.getElementById('report_name').value;
        if (report_name == "") {
            swal.fire({
                text: "Please Enter Report Name",
                confirmButtonText: 'Close',
                confirmButtonClass: 'btn btn-sm btn-danger',
                width: '350px',
                height: '10px',
                icon: 'warning',
            });
            return false;
        }
        simulated = document.getElementById('Simulated').value;
        simulation_input_id = document.getElementById('simulation_input_id').value;
        experiment_config = document.getElementById('experiment_config').value;
        process_experiment = document.getElementById('process_experiment').value;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        try {
            result = await $.ajax({
                url: "{{ url('/reports/experiment') }}",
                method: 'POST',
                data: {
                    report_name: report_name,
                    experiment_id: process_experiment,
                    experiment_variation_id: experiment_config,
                    simulation_input_id: simulation_input_id,
                    report_type: simulated
                }
            });
            if (result && result.success == "pending") {
                swal.fire({
                    text: "Report is in Process!, Once Process Done You can proceed for next report",
                    confirmButtonText: 'Close',
                    confirmButtonClass: 'btn btn-sm btn-danger',
                    width: '350px',
                    height: '10px',
                    icon: 'warning',
                });
                document.getElementById('report_name').value = "";
                $(".my_product").modal("hide");
                // let url = "{{ url('reports/experiment') }}";
                // window.open(url, '_blank');
                return false;
            }
            const Toast = Swal.mixin({
                toast: true,
                position: "bottom-end",
                showConfirmButton: false,
                timer: 5000,
            });
            Toast.fire({
                icon: 'success',
                title: "Report Created",
            })
            document.getElementById('report_name').value = "";
            $(".my_product").modal("hide");
            let url = "{{ url('reports/experiment') }}";
            window.open(url, '_blank');
            console.log("two");
        } catch (error) {
            console.error(error);
        }
    }

    function getConfiguration(id) {
        if (id != 0) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/reports/experiment/getConfiguration') }}",
                method: 'POST',
                data: {
                    id: id,
                },
                success: function(result) {
                    var respObj;
                    respObj = JSON.parse(result);
                    $('#experiment_config').children('option:not(:first)').remove();
                    if (respObj['configuration'].length != 0) {
                        $.each(respObj['configuration'], function(key, value) {
                            $('#experiment_config').append($('<option></option>').val(value['id'])
                                .html(value['name']))
                        });
                    }
                }
            })
        } else {
            $('#experiment_config').children('option:not(:first)').remove();
        };
    }

    function getDataset(id) {
        pid = document.getElementById('process_experiment').value;
        if (id != 0) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/reports/experiment/getDataset') }}",
                method: 'POST',
                data: {
                    variation_id: id,
                    process_id: pid
                },
                success: function(result) {
                    var respObj;
                    respObj = JSON.parse(result);
                    $('#simulation_input_id').children('option:not(:first)').remove();
                    if (respObj['dataset'].length != 0) {
                        $.each(respObj['dataset'], function(key, value) {
                            $('#simulation_input_id').append($('<option></option>').val(value['id']).html(
                                value['name']))
                        });
                    }
                }
            })
        } else {
            $('#simulation_input_id').children('option:not(:first)').remove();
        };
    }

    function renderCondition(process) {
        if (process != 0) {
            $('#renderConditionSpinner').show();
        } else {
            $("#exp_unit_condition_row").empty();
            $('#renderConditionSpinner').hide();
            return false;
        }
        if ($("#divexp_unit_condition" + process).length && $("#divexp_unit_condition" + process).length == 1) {
            $('#divexp_unit_condition' + process).remove();
        }
        var process_id = $('#process_experiment_id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/exp_unit_condition') }}" + '?process_experiment_id=' +
                process_id,
            method: 'GET',
            data: {
                name: process,
            },
            success: function(result) {
                $('#exp_unit_condition_row').append(result.html);
                $('#renderConditionSpinner').hide();
            }
        });
    }

    function renderexpOutocme(process) {
        if (process != 0) {
            $('#renderexpOutocmeSpinner').show();
        } else {
            $("#exp_unit_outcomes_appendrows").empty();
            $('#renderexpOutocmeSpinner').hide();
            return false;
        }
        if ($("#divexp_unit_outcome" + process).length && $("#divexp_unit_outcome" + process).length == 1) {
            $('#divexp_unit_outcome' + process).remove();
        }
        var process_id = $('#process_experiment_id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/exp_unit_outcomes/') }}" + '?process_experiment_id=' +
                process_id,
            method: 'GET',
            data: {
                name: process,
            },
            success: function(result) {
                $('#exp_unit_outcomes_appendrows').append(result.html);
                $('#renderexpOutocmeSpinner').hide();
            }
        });
    }

    function rendersetUnitCondition(process) {
        if (process != 0) {
            $('#rendersetUnitConditionSpinner').show();
        } else {
            $("#setpoint_unitcond_appendrows").empty();
            $('#rendersetUnitConditionSpinner').hide();
            return false;
        }
        if ($("#divset_point_unit_cond" + process).length && $("#divset_point_unit_cond" + process).length == 1) {
            $('#divset_point_unit_cond' + process).remove();
        }
        var process_id = $('#process_experiment_id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/set_unit_condition/') }}" + '?process_experiment_id=' +
                process_id,
            method: 'GET',
            data: {
                name: process,
            },
            success: function(result) {
                $('#setpoint_unitcond_appendrows').append(result.html);
                $('#rendersetUnitConditionSpinner').hide();
            }
        });
    }

    function selectExperimentunit(process) {
        if (process != 0) {
            $('#selectExperimentunitSpinner').show();
        } else {
            $("#messure_data_div").empty();
            $('#selectExperimentunitSpinner').hide();
            return false;
        }
        if ($("#divexp_messure" + process).length && $("#divexp_messure" + process).length == 1) {
            $('#divexp_messure' + process).remove();
        }
        var process_id = $('#process_experiment_id').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/exp_messure_data/')}}" + '?process_experiment_id=' +
                process_id,
            method: 'GET',
            data: {
                name: process,
            },
            success: function(result) {
                $('#messure_data_div').append(result.html);
                $('#selectExperimentunitSpinner').hide();
            }
        });
    }

    function getView(configid, simid, reportype) {
        $('#experiment_config').val(configid);
        $('#simulation_input_id').val(simid);
        $('#Simulated').val(reportype);
        $(".my_product").modal("show");
    }

    function cloneExpSimInput(val) {
        var siminput_id = val;
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false,
        })
        swalWithBootstrapButtons.fire({
            title: 'Do you want to give Simulate Input name?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'ml-2',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                document.getElementById('siid').value = siminput_id;
                $(".sim_input_model").modal("show");
            } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
            ) {
                if (siminput_id != "") {
                    var objectexp = {
                        "tab": "clone",
                        "siminput_id": siminput_id
                    };

                    event.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: '{{ url("/experiment/experiment/clonesimInput") }}',
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
                            location.reload(true);
                        },
                    });
                }
            }
        })
    }

    function alterMsg() {
        swal.fire({
            text: "Please enter data in simulation input template.",
            confirmButtonText: 'Close',
            confirmButtonClass: 'btn btn-sm btn-danger',
            width: '350px',
            height: '10px',
            icon: 'warning',
        });
        return false;
    }

    function saveSimInputData() {
        var siminput_id = document.getElementById('siid').value;
        if (siminput_id != "") {
            var objectexp = {
                "tab": "clone",
                "siminput_id": document.getElementById('siid').value,
                "name": document.getElementById('si_name').value
            };
            document.getElementById('expprofileSpinner1').style.display = '';
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '{{ url("/experiment/experiment/clonesimInput") }}',
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
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $(".sim_input_model").modal("hide");

                    location.reload(true);

                },
            });
        }
    }

    $(function() {
        $('#simulation_type').change(function() {
            var simulation_type = $('#simulation_type').val();
            if (simulation_type == 'Dynamic') {
                $('.hide_show_div').show();
            } else {
                $('.hide_show_div').hide();
            }
        });
        // $('#simulation_type').load(function() {
        var simulation_type = $('#simulation_type').val();
        if (simulation_type == 'Dynamic') {
            $('.hide_show_div').show();
        } else {
            $('.hide_show_div').hide();
        }
        //});
        // $('.hide_show_div').hide();
        $(".js-example-basic-single").select2();
    });

    $('#time_unit_type').on('change', function() {
        var val = this.value; //or alert($(this).val());
        console.log('sd');
        $('#time_interval_unit_type').val(val);
    });

    function render_list(id, simulate_input_type, $target, viewflag) {
        $('#loading').show();
        var $this = $(this);
        // var simulate_input_type = $('#simulate_input_type').val();
        var $url = "{{url('experiment/experiment/sim_config_output/list')}}";
        $.ajax({
            url: $url,
            type: "GET",
            data: {
                id: id,
                type: $target,
                simulate_input_type: simulate_input_type,
                viewflag: viewflag
            },
            success: function($response) {
                if ($response.status == true) {
                    $('#' + $target).html($response.html);
                    $('#loading').hide();
                    return false;
                }
            },
        });
    }
</script>
@endpush