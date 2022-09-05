@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/reports/process_comparison')}}">Process Simulation Comparison Reports</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create Process Simulation Comparison Report</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('/reports/process_comparison')}}" method="POST" role="report">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Create Process Comparison Report</h4>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="report_name">Report Name
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Specify a name for this report. The report will be saved in your database using this name for retrieval/modification in future."></i></span>
                            </label>
                            <input type="text" id="report_name" name="report_name" data-request="isalphanumeric" class="form-control form-control-sm" placeholder="Report Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="report_type">Select Report Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Report Type"></i></span>
                            </label>
                            <select name="report_type" id="report_type" class="form-control">
                                <option value="">Select Report Type</option>
                                <option value="standard">Standard</option>
                                <option value="custom">Custom </option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="simulation_type">Select Simulation Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Simulation type"></i></span>
                            </label>
                            <select id="simulation_type" onchange="populate_process_simulation(this.value)" name="simulation_type" class="form-control" required>
                                <option value="">Select Simulation Type</option>
                                @if(!empty($simulation_types))
                                @foreach($simulation_types as $simulation_type)
                                <option value="{{___encrypt($simulation_type->id)}}">{{$simulation_type->simulation_name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="process_simulation">Select Process Simulation
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Process Simulation"></i></span>
                            </label>
                            <select class="js-example-basic-multiple" onchange="populate_process_simulation_details(this.value)" name="process_simulation[]" id="process_simulation" multiple="multiple">
                                <option value="">Select Process</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tags">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter tags"></i></span>
                            </label>
                            <input type="text" id="tags" name="tags" class="form-control form-control-sm" placeholder="Tags">
                        </div>
                        <div class="form-group col-md-12" id="custom_data_source">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-3 mb-md-0">Select Data Source</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-sm-6" id="mass_balance" style="display: none;">

                                            <label>Mass Balance</label></br>
                                            <select style="width: 500px" class="js-example-basic-single" name="mass_bal" id="mass_bal">

                                            </select>
                                        </div>
                                        <div class="form-group col-sm-6" id="energy_balance" style="display: none;">

                                            <label>Energy Utility Balance</label></br>
                                            <select style="width: 500px" class="js-example-basic-single" name="energy_bal" id="energy_bal">

                                            </select>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-12 ">


                            <div class="card shadow">
                                <div class="card-header">
                                    <h4 class="mb-3 mb-md-0">Edit/Specify Weights</h4>
                                    <h6 class="mb-3 mb-md-0">SUM of the weights for all the parameters should be EXACTLY equal to 100</h6>
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="remaining_weight">Remaining weight

                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Remaining Weight"></i></span>
                                            </label>
                                            <input type="text" id="remaining_weight" name="remaining_weight" class="form-control form-control-sm" placeholder="Remaining Weight">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="economic_constraint">Economic constraint

                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Economic constraint"></i></span>
                                            </label>
                                            <input type="text" id="economic_constraint" name="economic_constraint" class="form-control form-control-sm" placeholder="Economic constraint">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="process_cost_enviroment_impacts">Process costs and environmental impacts

                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Process costs and environmental impacts"></i></span>
                                            </label>
                                            <input type="text" id="process_cost_enviroment_impacts" name="process_cost_enviroment_impacts" class="form-control form-control-sm" placeholder="Process costs and environmental impacts">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="enviroment_impact_raw_material">Environmental Impact of Raw Materials

                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Environmental Impact of Raw Materials"></i></span>
                                            </label>
                                            <input type="text" id="enviroment_impact_raw_material" name="enviroment_impact_raw_material" class="form-control form-control-sm" placeholder="Environmental Impact of Raw Materials">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="ehs_hazards">EHS hazards
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter EHS hazards"></i></span>
                                            </label>
                                            <input type="text" id="ehs_hazards" name="ehs_hazards" class="form-control form-control-sm" placeholder="EHS hazards">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="risk_aspect">Risk aspect

                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Risk aspect"></i></span>
                                            </label>
                                            <input type="text" id="risk_aspect" name="risk_aspect" class="form-control form-control-sm" placeholder="Risk aspect">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="total_weights">Total weights

                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Total weights"></i></span>
                                            </label>
                                            <input type="text" id="total_weights" name="total_weights" class="form-control form-control-sm" placeholder="Total weights">
                                        </div>
                                    </div>




                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="report"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="/reports/process_comparison" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    function populate_process_simulation(simulation_type) {
        if (simulation_type != 0) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ url('/reports/process_comparison/process_simulations') }}",
                method: 'GET',
                data: {
                    id: simulation_type,
                },
                success: function(result) {
                    var respObj = JSON.parse(result);
                    $('#process_simulation').children('option:not(:first)').remove();
                    $.each(respObj['simulation_detail'], function(key, value) {
                        $('#process_simulation').append($('<option></option>').val(value['id']).html(value['process_name']))
                    });
                    $("#custom_data_source").show();
                    $('#mass_bal').children('option').remove();
                    $('#energy_bal').children('option').remove();
                    if (respObj['SimulationDataSourcesType1'].length != 0) {

                        $.each(respObj['SimulationDataSourcesType1'], function(key, value) {
                            $('#mass_bal').append($('<option></option>').val(value['id']).html(value['data_source']))
                        });
                        $("#mass_balance").show();
                    } else {
                        $("#mass_balance").hide();

                    }
                    if (respObj['SimulationDataSourcesType2'].length != 0) {
                        $.each(respObj['SimulationDataSourcesType2'], function(key, value) {
                            $('#energy_bal').append($('<option></option>').val(value['id']).html(value['data_source']))
                        });

                        $("#energy_balance").show();
                    } else {
                        $("#energy_balance").hide();
                    }
                }
            });
        } else {

            $("#custom_data_source").hide();
            $('#mass_bal').children('option').remove();
            $('#energy_bal').children('option').remove();
            $("#energy_balance").hide();
            $("#mass_balance").hide();
        }
    }

    function populate_process_simulation_details(process_simulation_id) {

    }

    $(function() {
        // Multi Select
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }

        if ($(".js-example-basic-multiple").length) {
            $(".js-example-basic-multiple").select2();
        }

        $("#custom_data_source").hide();

        $('#tags').tagsInput({
            'interactive': true,
            'defaultText': 'Add More',
            'removeWithBackspace': true,
            'width': '100%',
            'height': 'auto',
            'placeholderColor': '#666666'
        });

        $("#default").click(function() {
            $("#custom_data_source").hide();
        });

        $("#custom").click(function() {
            $("#custom_data_source").show();
        })
    });
</script>
@endpush