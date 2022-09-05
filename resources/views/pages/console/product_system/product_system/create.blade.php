@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/product_system/product') }}">Product System</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create Product System</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('/product_system/product')}}" method="POST" role="product_sys">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Create Product System</h4>
                </div>
                <div class="card-body">
                    @CSRF
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="name">Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Product System Name"></i></span>
                            </label>
                            <input type="text" class="form-control" id="name" name="name" data-request="isalphanumeric" placeholder="Enter Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="description"> Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Add Description"></i></span>
                            </label>
                            <textarea id="description" name="description" class="form-control" data-request="isalphanumeric" maxlength="10000" rows="3" placeholder="Description"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tags">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter tags"></i></span>
                            </label>
                            <input type="text" id="tags" class="form-control" name="tags" placeholder="Enter tags">
                        </div>
                        <div class="form-group col-md-12">
                            <span id="error" class="text-danger"></span>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="process_simulation">Select Process Simulation
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Process Simulation"></i></span>
                                    </label>
                                    <select id="process_simulation" name="process_simulation" data-url="{{url('/product_system/product_simulation_typelist')}}" data-request="ajax-append-fields" data-level="1" data-count="0" data-target="#simulation_type" class="js-example-basic-single" required>
                                        <option value="">Select Process Simulation</option>
                                        <?php
                                            if(!is_null($process_simulation)){
                                                foreach($process_simulation as $process)
                                                {
                                        ?>
                                        <option value="{{___encrypt($process['id'])}}">{{$process['process_name']}}</option>
                                        <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="process_simulation">Select Simulation Type
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Process Simulation Dataset"></i></span>
                                    </label>
                                    <select id="simulation_type" name="simulation_type" data-url="{{url('/product_system/process_simulation_datasetList')}}" data-request="ajax-append-fields" data-count="0" data-target="#dataset" class="js-example-basic-single" required>
                                        <option value="">Select Simulation Type</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="process_simulation">Select Dataset
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Process Simulation Dataset"></i></span>
                                    </label>
                                    <select id="dataset" name="dataset" class="js-example-basic-single" required>
                                        <option value="">Select Dataset</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-1">
                                    <label for=""><span class="text-danger">&nbsp;&nbsp;</span></label>
                                    </br>
                                    <button type="button" class="btn btn-sm  btn-icon" id="btnadd" data-request="add-another-display-text" data-target="#process-simulation" data-url="{{url('/product_system/product-addmore')}}" data-count="0" data-toggle="tooltip" data-placement="bottom" title="Add">
                                        <i class="fas fa-plus text-secondary"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table">
                                        <table class="table table-bordered">
                                            <thead>
                                                <th>Simulation Type</th>
                                                <th>Process Simulation Name</th>
                                                <th>Dataset Name</th>
                                                <th class="text-center">Actions</th>
                                            </thead>
                                            <tbody id="process-simulation"></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                                        
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="product_sys"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{url('product_system/product')}}" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(function() {
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }

        $('#tags').tagsInput({
            'height': 'auto',
            'width': '100%',
            'interactive': true,
            'defaultText': 'Add More Tags',
            'placeholderColor': '#666666'
        });
    });

     
</script>
@endpush