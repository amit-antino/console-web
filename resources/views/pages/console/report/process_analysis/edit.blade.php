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
        <li class="breadcrumb-item active" aria-current="page">Edit Process Simulation Report</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="/reports/process_analysis/store" method="POST">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Process Simulation Report</h4>
                </div>
                <div class="card-body">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
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
                                <option value="">Select Report Type</option>
                                <option value="standard">Standard</option>
                                <option value="custom">Custom</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="simulation_type">Select Simulation Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Simulation Type"></i></span>
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
                        </div>
                        <div class="form-group col-md-6">
                            <label for="process_name">Process Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Process Name"></i></span>
                            </label>
                            <input type="text" style="background-color:white" name="process_name" id="process_name" class="form-control" value="" disabled />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="main_feedstock">Main Feedstock
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Main Feedstock"></i></span>
                            </label>
                            <input type="text" style="background-color:white" id="main_feedstock" name="main_feedstock" class="form-control" value="" disabled />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="data_source">Select Data Source
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Data Source"></i></span>
                            </label>
                            <select name="data_source" id="data_source" class="form-control">
                                <option value="">Select Data Source</option>
                                <option value="default">Default</option>
                                <option value="custom">Custom</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12" id="custom_data_source">
                            <div class="form-row">
                                <div class="form-group col-sm-6">
                                    <label>Mass Balance*<i data-toggle="tooltip" title="" data-original-title="Select Main Feedstock. You can select a maximum of 100 chemicals/ materials and or generic Processs. Example: Butanol" class="mdi mdi-information-outline"></i></label>
                                    <select class="js-example-basic-single w-100" name="">
                                        <option value="TX">Texas</option>
                                        <option value="NY">New York</option>
                                        <option value="FL">Florida</option>
                                        <option value="KN">Kansas</option>
                                        <option value="HW">Hawaii</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>Energy Utility Balance*<i data-toggle="tooltip" title="" data-original-title="Select Main Feedstock. You can select a maximum of 100 chemicals/ materials and or generic Processs. Example: Butanol" class="mdi mdi-information-outline"></i></label>
                                    <select class="js-example-basic-single w-100" name="">
                                        <option value="TX">Texas</option>
                                        <option value="NY">New York</option>
                                        <option value="FL">Florida</option>
                                        <option value="KN">Kansas</option>
                                        <option value="HW">Hawaii</option>
                                    </select>
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
                    <button type="submit" class="btn btn-sm btn-secondary submit">Submit</button>
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

        $("#default").click(function() {
            $("#custom_data_source").hide();
        });

        $("#custom").click(function() {
            $("#custom_data_source").show();
        })
    });
</script>
@endpush