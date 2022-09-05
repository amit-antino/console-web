@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<!-- <link href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css" rel="stylesheet" /> -->
@endpush
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Experiment Reports</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Experiment Reports</h5>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        {{-- <button type="button" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
                <i class="fa fa-refresh"></i>&nbsp;
            </button> --}}
        <a href="javascript:void(0);" data-request="ajax-append-list" data-url="{{ url('reports/experiment') }}" data-target="#tole_list_new" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="bottom" title="Refresh">
            <i class="fa fa-redo fa-spin" style="display:none" id="loading_spin"></i>
            <i class="fa fa-redo" id="loading_no_spin"></i>
        </a>
        <button type="button" data-toggle="modal" data-target=".bd-example-modal-sm" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
            <i class="fas fa-plus"></i>&nbsp;
            Create Experiment Report
        </button>
        @if(!empty(get_quide_doc('report')))
        <a href="{{ url(get_quide_doc('report')) }}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
            <i class="fas fa-download"></i>&nbsp;&nbsp;User Guide
        </a>
        @endif
        <div class="deletebulk">
            <button type="button" data-url="{{ url('/reports/experiment/bulk-delete') }}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
                <i class="fas fa-trash"></i>&nbsp;
                Delete
            </button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card shadow">
                 <div class="table-responsive">
                    @php
                    $cnt = count($experiment_reports);
                    @endphp
                    @if($cnt>0)

                    <p>
                    <div class="btn-group float-right" style="margin-left:5px">
                        <button type="button" class="btn btn-sm btn-secondary btn-icon-text dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user icon-sm mr-2"></i></button>
                        <div class="dropdown-menu">
                            @if (!empty($userarray))
                            @foreach ($userarray as $uname)
                            <a class="dropdown-item table-filter" data-value="{{$uname}}" href="#">{{$uname}}</a>
                            @endforeach
                            <a class="dropdown-item table-filter" href="#" data-value="">Clear Filter</a>
                            @endif
                        </div>
                    </div>
                    <div class="btn-group float-right" style="margin-left:5px">
                        <button type="button" class="btn btn-sm btn-secondary btn-icon-text dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-bars icon-sm mr-2"></i></button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item table-filter-type" href="#" data-value="Forward">Forward</a>
                            <a class="dropdown-item table-filter-type" href="#" data-value="Reverse">Reverse</a>
                            <a class="dropdown-item table-filter-type" href="#" data-value="">Clear Filter</a>
                        </div>
                    </div>
                    <div class="btn-group float-right" style="margin-left:5px">
                        <button type="button" class="btn btn-sm btn-secondary btn-icon-text dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-filter icon-sm mr-2"></i></button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item table-filter-status" href="#" data-value="success">Success</a>
                            <a class="dropdown-item table-filter-status" href="#" data-value="pending">Pending</a>
                            <a class="dropdown-item table-filter-status" href="#" data-value="failure">Failure</a>
                            <a class="dropdown-item table-filter-status" href="#" data-value="">Clear Filter</a>
                        </div>
                    </div>
                    <div class="btn-group float-right" style="margin-left:5px">
                        <button type="button" class="btn btn-sm btn-secondary btn-icon-text dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-search icon-sm mr-2"></i></button>
                        <div class="dropdown-menu">
                            <input type="text" id="myCustomSearchBox" class="form-control" placeholder="Search here..">
                        </div>
                    </div>
                    <!-- <select style="width: 200px;margin-left:5px" class="float-right" id="table-filter">
                            <option value="">Filter By User</option>
                            @if (!empty($userarray))
                            @foreach ($userarray as $uname)
                            <option>{{ $uname }}</option>
                            @endforeach
                            @endif
                        </select>
                        <select style="width: 200px;margin-left:5px" class="float-right" id="table-filter-type">
                            <option value="">Filter By Type </option>
                            <option value="forward">Forward</option>
                            <option value="reverse">Reverse</option>
                        </select> -->
                    </p>
                    @endif
                    <table id="experiment_reports" class="table">
                        <thead>
                            @if (Auth::user()->role != 'console')
                            <th><input type="checkbox" name="select_all1" value="1" id="example-select-all"></th>
                            @endif
                            <th>Report Name</th>
                            <th>Experiment Name <i class="fa fa-external-link" aria-hidden="true"></i></th>
                            <th>Variation <i class="fa fa-external-link" aria-hidden="true"></i></th>
                            <th>Simulation Input <i class="fa fa-external-link" aria-hidden="true"></i></th>
                            <th>Report Type</th>
                            <th>User name</th>
                            <th class="text-center">Timestamp</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </thead>
                        <tbody class="font-weight-normal" id="tole_list_new">

                            @if (!empty($experiment_reports))
                            @foreach ($experiment_reports as $report)
                            @php
                            $reportId=___encrypt($report['id']);
                            @endphp
                            <tr>
                                @if (Auth::user()->role != 'console')
                                <td>
                                    <input type="checkbox" value="{{ ___encrypt($report['id']) }}" class="checkSingle" name="select_all[]">
                                </td>
                                @endif
                                <td>{{ $report['report_name'] }}
                                    <a href="javascript:void(0);" onclick="editreportName('{{$reportId}}')" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Report Name">
                                        <i class="fas fa-edit text-secondary"></i>
                                    </a>
                                </td>
                                <td class="text-wrap width-250">
                                    @if(!empty($report['experiment_deleted_at']))
                                    {{$report['experiment_name'] }}
                                    @else
                                    <a href="{{url('experiment/experiment/'.___encrypt($report['experiment_id']).'/view')}}" target="_blank"> {{$report['experiment_name'] }} </a>
                                    @endif
                                </td>
                                <td class="text-wrap width-250">
                                    @if(!empty($report['variation_deleted_at']) || !empty($report['experiment_deleted_at']))
                                    {{ $report['configuration_name'] }}
                                    @else
                                    <a href="{{url('experiment/experiment/view_varition?id='.___encrypt($report['variation_id']).'&process_experiment_id='.___encrypt($report['experiment_id']))}}" target="_blank">{{ $report['configuration_name'] }} </a>
                                    @endif
                                </td>
                                <td class="text-wrap width-250">
                                    @if(!empty($report['simulation_input_deleted_at']) || !empty($report['experiment_deleted_at']) || !empty($report['variation_deleted_at']))
                                    {{ str_replace('_', ' ', $report['dataset']) }}
                                    @else
                                    <a href="{{url('experiment/experiment/'.___encrypt($report['variation_id']).'/sim_config?apply_config='.___encrypt($report['simulation_input_id']))}}" target="_blank">{{ str_replace('_', ' ', $report['dataset']) }} </a>
                                    @endif
                                </td>
                                <td class="width-200">{{ ucfirst($report['simulate_input_type']) }}</td>
                                <td class="text-wrap width-200">{{ $report['created_by'] }}</td>
                                <td class="text-center text-wrap width-200">
                                    {{ dateTimeFormate($report['created_at']) }}
                                </td>
                                <td class="text-center">
                                    <span class="hide_status">{{$report['status']}}</span>

                                    @if ($report['status'] == 'success')
                                    <i class="fas fa-check-circle text-success" data-toggle="tooltip" data-placement="bottom" title="Success"></i>
                                    @elseif($report['status'] == 'failure')
                                    <i class="fas fa-times-circle text-danger" data-toggle="tooltip" data-placement="bottom" title="Failed"></i>
                                    @else
                                    <i class="fas fa-sync-alt text-warning" data-toggle="tooltip" data-placement="bottom" title="Processing"></i>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($report['status'] == 'success')
                                    <input type="hidden" value="{{$report['status']}}">
                                    <a href="{{ url('/reports/experiment/' . ___encrypt($report['id']) . '?report_type=' . ___encrypt($report['report_type'])) }}" type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="View Report">
                                        <i class="fas fa-eye text-secondary"></i>

                                    </a>
                                    @elseif($report['status'] == 'failure')
                                    <input type="hidden" value="{{$report['status']}}">
                                    <!-- <a href="{{ url('/reports/experiment/' . ___encrypt($report['id']) . '?report_type=' . ___encrypt($report['report_type'])) }}"
                                                            type="button" class="dropdown-item" data-toggle="tooltip"
                                                            data-placement="bottom" title="View Report">
                                                            <i class="fas fa-eye"></i> View
                                                        </a> -->
                                    <a type="button" href="javascript:void(0);" data-url="{{ url('/reports/experiment/' . ___encrypt($report['id']) . '/retry') }}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to retry?" type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Try Again">
                                        <i class="fas fa-redo text-secondary"></i>
                                    </a>
                                    @endif
                                    @if (Auth::user()->role != 'console')
                                    <a type="button" href="javascript:void(0);" data-url="{{ url('/reports/experiment/' . ___encrypt($report['id'])) }}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" type="button" class="btn btn-icon" data-placement="bottom" title="Delete Report">
                                        <i class="fas fa-trash text-secondary"></i>
                                    </a>
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

<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase font-weight-normal" id="modal_logoutLabel">Generate Experiment Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="process_experiment">Enter Report Name
                            <span class="text-danger">*</span>
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Report Name"></i></span>
                        </label>
                        <input type="text" id="report_name" name="report_name" data-request="isalphanumeric" class="form-control" placeholder="Report Name">
                        <span id="error-msg-rp" class="help-block text-danger"></span>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="experiment_id">Select Experiment
                            <span class="text-danger">*</span>
                            <span id="ep"><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Experiment"></i></span>
                        </label>
                        <select id="experiment_id" onclick="getConfiguration(this.value)" name="experiment_id" class="js-example-basic-single" required>
                            <option value="0">Select Experiment</option>
                            @if (!empty($process_experiment))
                            @foreach ($process_experiment as $pe)
                            <option value="{{ ___encrypt($pe['id']) }}">
                                {{ $pe['process_experiment_name'] }}
                            </option>
                            @endforeach
                            @else
                            <option value="">There are no experiment or The experiment are inactive</option>
                            @endif
                        </select>
                        <span id="error-msg-ep" class="help-block text-danger"></span>

                    </div>
                    <div class="form-group col-md-6">
                        <label for="experiment_variation_id">Select Variation
                            <span class="text-danger">*</span>
                            <span id="varid"><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Variation"></i></span>
                        </label>
                        <select id="experiment_variation_id" name="experiment_variation_id" class="js-example-basic-single" required>
                            <option value="0">Select Variation</option>
                        </select>
                        <span id="error-msg-varid" class="help-block text-danger"></span>

                    </div>
                    <div class="form-group col-md-6">
                        <label for="dataset">Select Report Type
                            <span class="text-danger">*</span>
                            <span id="rt"><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Report Type"></i></span>
                        </label>
                        <select id="report_type" name="report_type" class="form-control" onchange="getDataset(this.value)" required>
                            <option value="0"><i>Select Report Type</option>
                            <option value="1">Forward Model</option>
                            <option value="2">Reverse Model</option>
                        </select>
                        <span id="error-msg-rt" class="help-block text-danger"></span>

                    </div>
                    <div class="form-group col-md-6">
                        <label for="simulation_input_id">Select Simulation Inputs
                            <span class="text-danger">*</span>
                            <span id="si"><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Simulation Inputs"></i></span>
                        </label>
                        <select id="simulation_input_id" name="simulation_input_id" class="js-example-basic-single" required>
                            <option value="0">Select Simulation Inputs</option>
                        </select>
                        <span id="error-msg-si" class="help-block text-danger"></span>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                <button type="button" onclick="saveData()" class="btn btn-secondary btn-sm">Save</button>
            </div>
        </div>
    </div>
</div>
<div id="process_experiment_report_edit">
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
<script src="https://kit.fontawesome.com/c222dd3c0d.js" crossorigin="anonymous"></script>



@endpush

@push('custom-scripts')
<script>
    $(".deletebulk").hide();
    $('.hide_status').hide();
    var cnt = '{{ $cnt }}'
    $(function() {
        if (cnt > 0) {
            'use strict';
            var table = $('#experiment_reports').DataTable({
                // "dom": 'lrtip',
                "iDisplayLength": 100,
                // dom: 'Blfrtip',
                // buttons: [
                //     'copy', 'csv', 'excel', 'pdf', 'print'
                // ],
                "language": {
                    search: ""
                },
                "dom": "lrtip"
            });
            // $('#table-filter').on('change', function() {
            //     var selectedValue = $("#table-filter").val();
            //     table.columns(6).search(selectedValue).draw();
            // });
            $('.table-filter').on('click', function() {
                var selectedValue = $(this).attr("data-value");
                table.columns(6).search(selectedValue).draw();
            });
            $('.table-filter-type').on('click', function() {
                var selectedValue = $(this).attr("data-value");
                table.columns(5).search(selectedValue).draw();
            });
            $('.table-filter-status').on('click', function() {
                var selectedValue = $(this).attr("data-value");
                table.columns(8).search(selectedValue).draw();
            });
            $('#myCustomSearchBox').keyup(function() {
                table.search($(this).val()).draw(); // this  is for customized searchbox with datatable search feature.
            })
            $('#experiment_reports').each(function() {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find(
                    'div[id$=_filter] input');
                search_input.attr('placeholder', 'Search');
                search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find(
                    'div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
            });
        }
    });

    function editreportName(id) {
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/reports/experiment/editname') }}",
            method: 'post',
            data: {
                var_id: id,
            },
            success: function(result) {
                $("#process_experiment_report_edit").html(result.html);
                $('#expprofileSpinner').hide();
                $("#editconfigModal" + id).modal('show');
            }
        });
    }

    $("#example-select-all").click(function() {
        $('.checkSingle').not(this).prop('checked', this.checked);
        var len = $("[name='select_all[]']:checked").length;
        if (len > 1) {
            $(".deletebulk").show();
        } else {
            $(".deletebulk").hide();
        }
    });
    $('.checkSingle').click(function() {
        var len = $("[name='select_all[]']:checked").length;
        if (len > 1) {
            $(".deletebulk").show();
        } else {
            $(".deletebulk").hide();
        }
        if (len == $('.checkSingle').length) {
            $('#example-select-all').prop('checked', true);
        } else {
            $('#example-select-all').prop('checked', false);
        }
    });
    // function table-filter-type(selectedValue){
    //     //var selectedValue = $("#table-filter-type").val();
    //             table.columns(5).search(selectedValue).draw();
    // }

    function saveData() {
        report_name = document.getElementById('report_name').value;
        if (report_name == "") {
            $("#error-msg-rp").text("Enter Report Name");
            return false;
        } else {
            $("#error-msg-rp").text('');
        }
        report_type = document.getElementById('report_type').value;
        simulation_input_id = document.getElementById('simulation_input_id').value;
        experiment_variation_id = document.getElementById('experiment_variation_id').value;
        experiment_id = document.getElementById('experiment_id').value;
        if (experiment_id == 0) {
            $("#error-msg-ep").text("Select Experiment");
            return false;
        } else {
            $("#error-msg-ep").text('');
        }

        if (experiment_variation_id == 0) {
            $("#error-msg-varid").text("Select Variation");
            return false;
        } else {
            $("#error-msg-varid").text('');
        }
        if (report_type == 0) {
            $("#error-msg-rt").text("Select Report Type");

            return false;
        } else {
            $("#error-msg-rt").text('');
        }
        if (simulation_input_id == 0) {
            $("#error-msg-si").text("Select Simulation Input");

            return false;
        } else {
            $("#error-msg-si").text('');
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/reports/experiment') }}",
            method: 'POST',
            data: {
                report_name: report_name,
                experiment_id: experiment_id,
                experiment_variation_id: experiment_variation_id,
                simulation_input_id: simulation_input_id,
                report_type: report_type,
            },
            success: function(data) {
                if (data.error == 'error_validation') {
                    swal.fire({
                        text: "Please add data in simulation input.",
                        confirmButtonText: 'Close',
                        confirmButtonClass: 'btn btn-sm btn-danger',
                        width: '350px',
                        height: '10px',
                        icon: 'warning',
                    });
                    document.getElementById('report_name').value = "";
                    $(".my_product").modal("hide");
                    return false;
                }
                const Toast = Swal.mixin({
                    toast: true,
                    position: "bottom-end",
                    showConfirmButton: false,
                    timer: 5000,
                });
                if (data.message == 'Permission Denied!') {
                    Toast.fire({
                        icon: 'warning',
                        title: "Permission Denied!",
                    })
                } else {
                    Toast.fire({
                        icon: 'success',
                        title: "Report Created",
                    })
                }
                document.getElementById('report_type').value = "";
                document.getElementById('simulation_input_id').value = 0;
                document.getElementById('experiment_variation_id').value = 0;
                document.getElementById('experiment_id').value = 0;
                $('.bd-example-modal-sm').hide();
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                let url = "{{ url('reports/experiment') }}";
                document.location.href = url;
            }
        })
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
                    $('#experiment_variation_id').children('option:not(:first)').remove();
                    if (respObj['configuration'].length != 0) {
                        $.each(respObj['configuration'], function(key, value) {
                            $('#experiment_variation_id').append($('<option></option>').val(value[
                                'id']).html(value['name']))
                        });
                        $('#error-msg-ep').text('');
                    }else{
                        $('#error-msg-ep').append($('<option></option>').val('').html('There are no variations or The variations are inactive'))

                    }
                }
            })
        } else {
            $('#experiment_variation_id').children('option:not(:first)').remove();
        };
    }

    function getDataset(id) {

        pid = document.getElementById('experiment_id').value;
        var_id = document.getElementById('experiment_variation_id').value;
        if (id == 0) {
            swal.fire({
                text: "Please Select Report Type",
                confirmButtonText: 'Close',
                confirmButtonClass: 'btn btn-sm btn-danger',
                width: '350px',
                height: '10px',
                icon: 'warning',
            });
            return false;
        }

        if (var_id != 0) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/reports/experiment/getDataset') }}",
                method: 'POST',
                data: {
                    variation_id: var_id,
                    process_id: pid,
                    report_type: id
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
                        $('#error-msg-rt').text('');
                    }else{
                        $('#error-msg-rt').text('');
                        $('#error-msg-rt').append($('<option></option>').val('').html('There are no simulation inputs or status is inactive'))
                    }
                }
            })
        } else {
            $('#simulation_input_id').children('option:not(:first)').remove();
        };
    }
</script>
@endpush
