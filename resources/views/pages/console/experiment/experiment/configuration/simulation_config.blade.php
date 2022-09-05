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
            <a href="{{url('/experiment/experiment')}}">Experiments</a> - {{$process_experiment->process_experiment_name}}
        </li>
        <li class="breadcrumb-item">
            @if($viewflag!="view_config")
            <a href="{{url('/experiment/experiment/'.___encrypt($variation->experiment_id).'/manage')}}">
                Variations
            </a>
            @else
            <a href="{{url('/experiment/experiment/'.___encrypt($variation->experiment_id).'/view')}}">
                Variations
            </a>
            @endif
            - {{$variation->name}}
        </li>
        @if(empty($apply_config))
        <li class="breadcrumb-item active">Simulation Input</li>
        @endif
        @if(!empty($apply_config))
        <li class="breadcrumb-item">
            @if($viewflag!="view_config")
            <a href="{{url('/experiment/experiment/'.___encrypt($variation->id).'/sim_config')}}">
                Simulation Inputs
            </a>
            @else
            <a href="{{url('/experiment/experiment/'.___encrypt($variation->id).'/view_config')}}">
                Simulation Inputs
            </a>
            @endif

            - {{$simulate_input->name}}
        </li>
        @endif
    </ol>
</nav>
@php
$per = request()->get('sub_menu_permission');
$reverse=!empty($per['reverse']['method'])?$per['reverse']['method']:[];
$forward=!empty($per['forward']['method'])?$per['forward']['method']:[];
$simulate_input_per=!empty($per['simulation_input']['method'])?$per['simulation_input']['method']:[];
@endphp
@if(empty($apply_config))
<div class="row">
    <div class="col-md-12 mb-3">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    Simulation Inputs
                    <!-- : <span> {{!empty($variation->name)?$variation->name:''}}</span> -->
                </div>
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    @if($viewflag!="view_config")

                    <button type="button" id="generate_multiple_report" data-url="{{ url('/experiment/experiment/simulation_config/bulk-generate-report') }}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to generate multiple report?" data-id="bulk-delete" class="btn btn-sm btn-secondary btn-icon-text mb-2 mb-md-0">
                        <i class="fas fa-file-export"></i>&nbsp;&nbsp;Generate Report
                    </button>
                    <span>&nbsp;</span>
                    <span>&nbsp;</span>
                    @if(in_array('create',$simulate_input_per) || empty($simulate_input_per))
                    <button type="button" class="btn btn-sm btn-secondary  btn-icon-text mr-2 d-none d-md-block" id="configModal_popup" data-toggle="modal" data-target="#configModal">
                        <i class="fas fa-save"></i> Create Simulation Input
                    </button>
                    @endif
                    @if (Auth::user()->role != 'console')
                    <a href="javascript:void(0);" data-url="{{url('/experiment/experiment/configuration/import_sim_input')}}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" data-request="ajax-popup" data-target="#import-div" data-tab="#importModal" type="button" data-toggle="tooltip" data-placement="bottom" title="Import Simulation Input">
                        <i class="fas fa-download"></i> Import
                    </a>
                    <a href="{{url('/experiment/experiment/'.___encrypt($variation->id).'/sim_excel_config')}}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
                        <i class="fas fa-table"></i> Simulation Input Excel Template
                    </a>
                    @endif
                    @if(in_array('delete',$simulate_input_per))
                    <div class="deletebulk">
                        <button type="button" data-url="{{ url('/experiment/experiment/simulation_config/bulk-delete') }}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
                            <i class="fas fa-trash"></i>&nbsp;&nbsp;Delete
                        </button>
                    </div>
                    @endif
                    @endif
                </div>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="view_config" class="table table-hover mb-0">
                                @php
                                $cnt=count($simulate_input_list);
                                @endphp
                                @if($cnt>10)
                                <div class="btn-group float-right" style="margin-left:5px">
                                    <button type="button" class="btn btn-sm btn-secondary btn-icon-text dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-filter icon-sm mr-2"></i></button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item table-filter-status" href="#" data-value="succ">Active</a>
                                        <a class="dropdown-item table-filter-status" href="#" data-value="inactive">Inactive</a>
                                        <a class="dropdown-item table-filter-status" href="#" data-value="">Clear Filter</a>
                                    </div>
                                </div>
                                @endif
                                <thead>
                                    <th><input type="checkbox" id="example-select-all"></th>
                                    <th>Simulation Input</th>
                                    <th>Variation</th>
                                    <th>Simulation Type</th>
                                    <th>Created By</th>
                                    <th>Created Date</th>
                                    <th>Updated By</th>
                                    <th>Updated Date</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </thead>
                                <tbody class="font-weight-normal">

                                    @if(!empty($simulate_input_list))
                                    @foreach($simulate_input_list as $simulate_input_detail)
                                    <tr>
                                        <td><input type="checkbox" value="{{___encrypt($simulate_input_detail['id'])}}" class="checkSingle" name="select_all[]"></td>
                                        <td>{{$simulate_input_detail['name']}}</td>
                                        <td>{{$simulate_input_detail['variation_name']}}</td>
                                        <td>{{ucfirst($simulate_input_detail['simulate_input_type'])}}</td>
                                        <td>{{$simulate_input_detail['created_by']}}</td>
                                        <td>
                                            {{ dateTimeFormate($simulate_input_detail['created_at']) }}
                                        </td>
                                        <td>{{$simulate_input_detail['updated_by']}}</td>
                                        <td>
                                            {{ dateTimeFormate($simulate_input_detail['updated_at']) }}
                                        </td>


                                        <td class="text-center">
                                            <span style="display:none" class="hide_status">
                                                @if($simulate_input_detail['status']=="active")
                                                succ
                                                @else
                                                {{$simulate_input_detail['status']}}
                                                @endif

                                            </span>
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" data-url="{{url('/experiment/experiment/simulation_input/'.___encrypt($simulate_input_detail['id']).'?status='.$simulate_input_detail['status'])}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you Change Status ?" class="custom-control-input" id="customSwitch{{___encrypt($simulate_input_detail['id'])}}" @if($simulate_input_detail['status']=='active' ) checked @endif>
                                                <label class="custom-control-label" for="customSwitch{{___encrypt($simulate_input_detail['id'])}}"></label>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                <!-- <a href="javascript:void(0);" type="button" data-url="{{url('/experiment/experiment/simulation_input/'.___encrypt($simulate_input_detail['id']).'/copy_to_knowledge')}}" type="button" class="btn btn-icon" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to move this to Knowledge Bank?" data-id="copy_to_knowledge" class="dropdown-item" data-toggle=" tooltip" data-placement="bottom" title="Copy to Knowledge Bank">
                                                    <i class="fas fa-database  text-secondary"></i>
                                                </a> -->
                                                @if($viewflag!="view_config")
                                                @if(in_array('edit',$simulate_input_per) || empty($simulate_input_per))
                                                <!-- <a href="javascript:void(0);" data-url="{{url('experiment/experiment/simulation_input/'.___encrypt($simulate_input_detail['id']).'/edit')}}" data-request="ajax-popup" data-target="#edit-div" data-tab="#editcategoryModal{{___encrypt($simulate_input_detail['id'])}}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Simulation Input Name">
                                                    <i class="fas fa-edit text-secondary"></i>
                                                </a> -->

                                                @endif
                                                @if(in_array('edit',$simulate_input_per) || empty($simulate_input_per))

                                                <a href="{{url('experiment/experiment/'.___encrypt($variation->id).'/sim_config?apply_config='.___encrypt($simulate_input_detail['id']))}}" type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Simulation Inputs Data">
                                                    <i class="fas fa-edit text-secondary"></i>
                                                </a>
                                                <a href="{{ url('/experiment/experiment/simulation_excel_config_store/'.___encrypt($simulate_input_detail['id'])) }}" type="button" id="configModal_popup" class="btn btn-icon" aria-haspopup="true" aria-expanded="false" title="Download Simulation Input Excel Template Data">
                                                    <i class="fas fa-download text-secondary"></i>
                                                </a>
                                                @if($simulate_input_detail['simulate_input_type']=='forward' && !empty($forward))
                                                @if($simulate_input_detail['status']=='active')
                                                <a type="button" onclick="getView('{{___encrypt($variation->id)}}','{{___encrypt($simulate_input_detail['id'])}}',1)" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Generate Forward Report">
                                                    <i class="fas fa-file-export text-secondary"></i>
                                                </a>
                                                @else
                                                <a type="button" onclick="statusAlert()" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Generate Forward Report">
                                                    <i class="fas fa-file-export text-secondary"></i>
                                                </a>
                                                @endif
                                                @else
                                                @if(!empty($reverse) && $simulate_input_detail['simulate_input_type']=='reverse')
                                                @if($simulate_input_detail['status']=='active')
                                                <a type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Generate Reverse Report" onclick="getView('{{___encrypt($variation->id)}}','{{___encrypt($simulate_input_detail['id'])}}',2)">
                                                    <i class="fas fa-file-export text-secondary"></i>
                                                </a>
                                                @else
                                                <a type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Generate Reverse Report" onclick="statusAlert()">
                                                    <i class="fas fa-file-export text-secondary"></i>
                                                </a>
                                                @endif
                                                @endif
                                                @endif
                                                @php
                                                $simId=___encrypt($simulate_input_detail['id']);
                                                @endphp
                                                @if(in_array('create',$simulate_input_per))
                                                <a href="javascript:void(0);" onclick='cloneExpSimInput("{{$simId}}")' type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Clone Simulation Input">
                                                    <i class="fas fa-copy text-secondary"></i>
                                                </a>
                                                @endif
                                                @if(in_array('delete',$simulate_input_per) || empty($simulate_input_per))
                                                <a href="javascript:void(0);" data-url="{{ url('/experiment/experiment/simulation_input/'.___encrypt($simulate_input_detail['id'])) }}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete Simulation Inputs">
                                                    <i class="fas fa-trash text-secondary"></i>
                                                </a>
                                                @endif
                                                @else
                                                <a href="{{url('experiment/experiment/'.___encrypt($variation->id).'/view_config?apply_config='.___encrypt($simulate_input_detail['id']))}}" type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="View Simulation Inputs">
                                                    <i class="fas fa-save text-secondary"></i>
                                                </a>
                                                @endif
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
@if(empty($open_popup) && !empty($apply_config))
<div class="row">
    <div class="col-md-12">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    Simulation Input - <span> {{!empty($simulate_input->name)?$simulate_input->name:''}}</span>
                    <a type="button" href="javascript:void(0);" data-url="{{url('experiment/experiment/simulation_input/'.___encrypt($simulate_input->id).'/edit')}}" data-request="ajax-popup" data-target="#edit-div" data-tab="#editcategoryModal{{___encrypt($simulate_input->id)}}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Simulation Input Name">
                        <i class="fas fa-edit text-secondary" style="margin-top: 6px;"></i>
                    </a>
                </div>
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    @if($viewflag!="view_config")
                    Simulation Type -{{ucfirst($simulate_input->simulate_input_type)}}
                    @if($simulate_input->simulate_input_type=='forward')
                    @if($simulate_input->status=='active')
                    <a type="button" onclick="getView('{{___encrypt($variation->id)}}','{{___encrypt($simulate_input->id)}}',1)" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Generate Forward Report">
                        <i class="fas fa-file-export text-secondary" style="margin-top: 6px;"></i>
                    </a>
                    @else
                    <a type="button" onclick="statusAlert()" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Generate Forward Report">
                        <i class="fas fa-file-export text-secondary" style="margin-top: 6px;"></i>
                    </a>
                    @endif
                    @else
                    @if($simulate_input->status=='active')
                    <a type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Generate Reverse Report" onclick="getView('{{___encrypt($variation->id)}}','{{___encrypt($simulate_input->id)}}',2)">
                        <i class="fas fa-file-export text-secondary" style="margin-top: 6px;"></i>
                    </a>
                    @else
                    <a type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Generate Reverse Report" onclick="statusAlert()">
                        <i class="fas fa-file-export text-secondary" style="margin-top: 6px;"></i>
                    </a>
                    @endif
                    @endif
                    @endif
                </div>
            </div>
            <div class="card-header">
                <ul id="list-example" class="nav nav-tabs card-header-tabs">

                    <li class="nav-item">
                        <a class="nav-link  show active" id="raw_material-tab" data-toggle="tab" href="#raw_material" role="tab" aria-controls="raw_material" aria-selected="true">Raw Materials</a>
                    </li>

                    @if(!empty($simulate_input->master_condition))
                    <li class="nav-item">
                        <a class="nav-link" onclick='render_list("{{___encrypt($simulate_input->id)}}","{{$simulate_input->simulate_input_type}}","condition_list_master","{{$viewflag}}")' id="master_condition-tab" data-toggle="tab" href="#master_condition" role="tab" aria-controls="master_condition" aria-selected="false">Master Conditions</a>
                    </li>
                    @endif
                    @if(!empty($simulate_input->unit_condition))
                    <li class="nav-item">
                        <a class="nav-link" onclick='render_list("{{___encrypt($simulate_input->id)}}","{{$simulate_input->simulate_input_type}}","exp_unit_condition_list","{{$viewflag}}")' id="ex_unit_condition-tab" data-toggle="tab" href="#ex_unit_condition" role="tab" aria-controls="ex_unit_condition" aria-selected="false">Experiment Unit Conditions</a>
                    </li>
                    @endif
                    @if(!empty($simulate_input->master_outcome))
                    <li class="nav-item">
                        <a class="nav-link" onclick='render_list("{{___encrypt($simulate_input->id)}}","{{$simulate_input->simulate_input_type}}","output_master_outcome_list","{{$viewflag}}")' id="master_outcome-tab" data-toggle="tab" href="#master_outcome" role="tab" aria-controls="master_outcome" aria-selected="false">Master Outcomes</a>
                    </li>
                    @endif
                    @if(!empty($simulate_input->unit_outcome))
                    <li class="nav-item">
                        <a class="nav-link" onclick='render_list("{{___encrypt($simulate_input->id)}}","{{$simulate_input->simulate_input_type}}","exp_unit_outcome_list","{{$viewflag}}")' id="ex_unit_outcome-tab" data-toggle="tab" href="#ex_unit_outcome" role="tab" aria-controls="ex_unit_outcome" aria-selected="false">Experiment Unit Outcomes</a>
                    </li>
                    @endif
                    @if($simulate_input->simulate_input_type=='forward')
                    <!-- <li class="nav-item">
                        <a class="nav-link " id="simulation_type_tab-tab" data-toggle="tab" href="#simulation_type_tab" role="tab" aria-controls="simulation_type_tab" aria-selected="false">Simulation Type</a>
                    </li> -->
                    @endif
                </ul>
            </div>
            @include('pages.console.experiment.experiment.configuration.simulation_input_tab')
        </div>
    </div>
</div>
@endif

<div class="modal fade bd-example-modal-sm my_product" id="setoutputModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-uppercase font-weight-normal" id="modal_logoutLabel">Generate Experiment
                    Report</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="process_experiment">Report Name
                            <span class="text-danger">*</span>
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter name"></i></span>
                        </label>
                        <input type="text" id="report_name" name="report_name" value="" class="form-control" placeholder="Report Name">
                        <span class="text-danger" id="name-error" style="display:none">Report name field is required</span>
                    </div>
                    <input type="hidden" id="process_experiment" value="{{___encrypt($process_experiment['id'])}}" name="process_experiment" class="form-control" required>
                    <input type="hidden" id="experiment_config" name=" experiment_config" class="form-control" required>
                    <input type="hidden" id="simulation_input_id" name="simulation_input_id" class="form-control" required>
                    <input type="hidden" id="Simulated" name="Simulated" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Cancel</button>
                <button type="button" onclick="saveData()" class="btn btn-secondary btn-sm">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="configModal" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ url('/experiment/experiment/simulation_config_store') }}" method="POST" role="process_config">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase font-weight-normal" id="userLabel">Create Simulation Input
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="variation_id" value="{{$variation->id}}">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Simulation Input Name&nbsp;<span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Simulation Input Name"></i></span>
                            </label>
                            <input type="text" id="name" name="name" class="form-control" value="" placeholder="Simulation Input Name">
                        </div>
                        <div class="form-group col-md-12">
                            
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Select Simulation Type&nbsp;<span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="simulation_type"></i></span>
                            </label>
                            <select class="form-control" name="simulation_input_type" style="width:100%;">
                                <option value="">Select Simulation Type</option>
                                <option value="forward">Forward</option>
                                <option value="reverse">Reverse</option>
                            </select>
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
<div class="modal fade bd-example-modal-md sim_input_model" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="text-center">
                <div id="expprofileSpinner1" class="spinner-border text-secondary" style="width: 2rem; height: 2rem;display: none; margin-top:25px;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title text-uppercase font-weight-normal" id="modal_logoutLabel">Clone Simulate Input</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="process_experiment">Enter Name
                            <span class="text-danger">*</span>
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Name"></i></span>
                        </label>
                        <input type="text" id="si_name" name="si_name" class="form-control" placeholder="Name">
                        <input type="hidden" id="siid" name="siid" class="form-control" placeholder="Name">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" onclick="saveSimInputData()" class="btn btn-secondary">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="configModalTemp" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ url('/experiment/experiment/simulation_excel_config_store') }}" method="POST" role="simulation_excel_config_store">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase font-weight-normal" id="userLabel">Create Simulation Input Excel Template</h5>
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
                            <input type="hidden" name="simulate_id" id="simulate_id">
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
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="simulation_excel_config_store"]' class="btn btn-sm btn-secondary submit">Submit</button>
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
<div id="edit-div"></div>
<div id="import-div"></div>

@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{ asset('/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script type="text/javascript">
     $("select.form-control").addClass("js-example-basic-single");
    function createTemplateWithData(simulate_id) {
        $("#simulate_id").val(simulate_id)
        $("#configModalTemp").modal()
    }

    function getoutputmodal() {
        $('.testmodal').show();
    }

    $('.hide_status').hide();
    var cnt = '{{!empty($cnt)?$cnt:0}}';
    $(function() {

        if (cnt > 10) {
            var table = $('#view_config').DataTable({
                "iDisplayLength": 100,

            });
            $('.table-filter-status').on('click', function() {
                var selectedValue = $(this).attr("data-value");

                table.columns(8).search(selectedValue).draw();
            });
            // $('#view_config').each(function() {
            //     var datatable = $(this);
            //     // SEARCH - Add the placeholder for Search and Turn this into in-line form control
            //     // var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
            //     // search_input.attr('placeholder', 'Search');
            //     // search_input.removeClass('form-control-sm');
            //     // // LENGTH - Inline-Form control
            //     // var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
            //     // length_sel.removeClass('form-control-sm');
            // });
        }

    });

    async function saveData() {
        let result;
        $("#name-error").hide();
        report_name = document.getElementById('report_name').value;
        if (report_name == "") {
            $("#name-error").show();
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
            if (result.error == 'error_validation') {
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

    $(".deletebulk").hide();
    $("#generate_multiple_report").hide();
    $("#example-select-all").click(function() {
        if ($(this).is(":checked")) {
            $(".deletebulk").show();
            $("#generate_multiple_report").show();
        } else {
            $(".deletebulk").hide();
            $("#generate_multiple_report").hide();
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
            $("#generate_multiple_report").show();
        } else {
            $(".deletebulk").hide();
            $("#generate_multiple_report").hide();
        }
        if (len == $('.checkSingle').length) {
            $('#example-select-all').prop('checked', true);
        } else {
            $('#example-select-all').prop('checked', false);
        }
    });

    function statusAlert() {
        swal.fire({
            text: "Selected simulation input is inactive",
            confirmButtonText: 'Close',
            confirmButtonClass: 'btn btn-sm btn-danger',
            width: '350px',
            height: '10px',
            icon: 'warning',
        });
        return false;
    }
   
 
</script>
@endpush