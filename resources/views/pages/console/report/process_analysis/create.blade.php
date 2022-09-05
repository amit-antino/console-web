@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/reports/process_analysis')}}">Process Simulation Reports</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create Process Simulation Report</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card">
            <form action="{{url('/reports/process_analysis')}}" method="POST" role="report">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Create Process Simulation Report</h4>
                </div>
                <div class="card-body">

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="report_name">Report Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Specify a name for this report. The report will be saved in your database using this name for retrieval/modification in future."></i></span>
                            </label>
                            <input type="text" id="report_name" name="report_name" class="form-control" placeholder="Report Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="report_type">Select Report Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Report Type"></i></span>
                            </label>
                            <select name="report_type" id="report_type" class="form-control">
                                <option value="0">Select Report Type</option>
                                <option value="standard">Standard</option>
                                <option value="custom">Custom </option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="simulation_type">Select Simulation Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Simulation Type"></i></span>
                            </label>
                            <select id="simulation_type" onchange="populate_process_simulation(this.value)" name="simulation_type" class="form-control" required>
                                <option value="0">Select Simulation Type
                                </option>
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
                            <select id="process_simulation" onchange="populate_process_simulation_details(this.value)" name="process_simulation" class="js-example-basic-single" required>
                                <option value="0">Select Process Simulation</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="main_product">Main Product
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Main Product"></i></span>
                            </label>
                            <input type="text" style="background-color:white" id="main_product" name="main_product" class="form-control" value="" disabled />
                            <input type="hidden" style="background-color:white" id="main_product_id" name="main_product_id" class="form-control" value="" />
                        </div>

                        <div class="form-group col-md-6">
                            <label for="main_feedstock">Main Feedstock
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Main Feedstock"></i></span>
                            </label>
                            <input type="text" style="background-color:white" id="main_feedstock" name="main_feedstock" class="form-control" value="" disabled />
                            <input type="hidden" style="background-color:white" id="main_feedstock_id" name="main_feedstock_id" class="form-control" value="" />
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

                        <div class="form-group col-md-6">
                            <label for="tags">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Equipment tags"></i></span>
                            </label>
                            <input type="text" id="tags" name="tags" class="form-control" placeholder="Tags">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description"> Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Description"></i></span>
                            </label>
                            <textarea id="description" name="description" class="form-control" maxlength="10000" rows="5" placeholder="Description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="report"]' class="btn btn-sm btn-secondary submit">Submit</button>
                    <!-- <button type="button" onclick="saveData()" class="btn btn-sm btn-secondary">Submit</button> -->
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                    <a href="{{url('reports/process_analysis')}}" class="btn btn-sm btn-danger">Cancel</a>
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
                url: "{{ url('/reports/process_analysis/process_simulations') }}",
                method: 'GET',
                data: {
                    id: simulation_type,
                },
                success: function(result) {
                    var respObj = JSON.parse(result);
                    console.log(respObj);
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
            document.getElementById('main_feedstock').value = "";
            document.getElementById('main_feedstock_id').value = "";
            document.getElementById('main_product_id').value = "";
            document.getElementById('main_product').value = "";
            $("#custom_data_source").hide();
            $('#mass_bal').children('option').remove();
            $('#energy_bal').children('option').remove();
            $("#energy_balance").hide();
            $("#mass_balance").hide();
        }

    }

    function populate_process_simulation_details(process_simulation_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/reports/process_analysis/process_simulation_details') }}",
            method: 'GET',
            data: {
                id: process_simulation_id,
                type: document.getElementById('simulation_type').value,
            },
            success: function(result) {
                var respObj;
                respObj = JSON.parse(result);

                var fesd = respObj['simulation_detail']['main_feedstock'];
                var fesdid = respObj['simulation_detail']['main_feedstock_id'];
                var main_product_id = respObj['simulation_detail']['main_product_id'];
                var product_name = respObj['simulation_detail']['main_product'];
                document.getElementById('main_feedstock').value = fesd;
                document.getElementById('main_feedstock_id').value = fesdid;
                document.getElementById('main_product_id').value = main_product_id;
                document.getElementById('main_product').value = product_name;


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
    }

    $("#custom_data_source").hide();

    $(function() {
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }

        $('#tags').tagsInput({
            'interactive': true,
            'defaultText': 'Add More',
            'removeWithBackspace': true,
            'width': '100%',
            'height': 'auto',
            'placeholderColor': '#666666'
        });


    });

    function saveData() {

        report_name = document.getElementById('report_name').value;
        alert(report_name);
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

        report_type = document.getElementById('report_type').value;
        simulation_type = document.getElementById('simulation_type').value;
        process_simulation = document.getElementById('process_simulation').value;
        main_product_id = document.getElementById('main_product_id').value;
        main_feedstock_id = document.getElementById('main_feedstock_id').value;
        mass_bal = document.getElementById('mass_bal').value;
        energy_bal = document.getElementById('energy_bal').value;
        tags = document.getElementById('tags').value;
        description = document.getElementById('description').value;
        if (report_type == 0) {
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/reports/process_analysis') }}",
            method: 'POST',
            data: {
                report_name: report_name,
                report_type: report_type,
                simulation_type: simulation_type,
                process_simulation: process_simulation,
                main_product_id: main_product_id,
                main_feedstock_id: main_feedstock_id,
                mass_bal: mass_bal,
                energy_bal: energy_bal,
                tags: tags,
                description: description
            },
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

                    let url = "{{ url('reports/process_analysis') }}";
                    document.location.href = url;
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.message,
                    })
                }
                // document.getElementById('report_type').value = "";
                // document.getElementById('simulation_input_id').value = 0;
                // document.getElementById('experiment_variation_id').value = 0;
                // document.getElementById('experiment_id').value = 0;
                // $('.bd-example-modal-sm').hide();
                // $('body').removeClass('modal-open');
                // $('.modal-backdrop').remove();

            }
        })
    }
</script>
@endpush