@extends('layout.console.master')
@push('plugin-styles')
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/models')}}">Models</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create or Add Models</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form method="POST" action="{{url('/models')}}" role="models">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Create or Add Models</h4>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Name
                                <span class="text-danger">*</span>
                                <i data-toggle="tooltip" title="Enter Name." class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <input type="text" class="form-control" id="name" data-request="isalphanumeric" name="name" placeholder="Enter Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="File">Upload File
                                <span class="text-danger">*</span>
                                <i data-toggle="tooltip" title="Upload Multiple File." class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <input type="file" class="form-control" multiple="" id="file" name="file[]">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="version">Version
                                <i data-toggle="tooltip" title="Enter version." class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <input type="number" min="0.0000000001" data-request="isnumeric" class="form-control" id="version" name="version" placeholder="Enter Version">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="association">Association
                                <i data-toggle="tooltip" title="Enter Association." class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <input type="text" class="form-control" id="association" name="association" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="association">Recommendations
                                <i data-toggle="tooltip" title="Enter Recommendations." class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <input type="text" class="form-control" id="recommendations" name="recommendations" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="association">List of Models
                                <i data-toggle="tooltip" title="Enter List of Models." class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <input type="text" class="form-control" id="list_of_models" name="list_of_models" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="association">Assumptions
                                <i data-toggle="tooltip" title="Enter Assumptions." class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <input type="text" class="form-control" id="assumptions" name="assumptions" />
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description
                                <i data-toggle="tooltip" title="Add Description. You can enter maximum 1000 characters. " class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <textarea class="form-control" id="description" name="description" data-request="isalphanumeric" placeholder="Enter Description"></textarea>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="models"]' class="btn btn-sm btn-secondary submit">
                            Submit
                        </button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{url('/models')}}" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(function() {
        $('#association').tagsInput({
            'height': 'auto',
            'width': '100%',
            'interactive': true,
            'defaultText': 'Add More Association',
            'placeholderColor': '#666666'
        });
        $('#assumptions').tagsInput({
            'height': 'auto',
            'width': '100%',
            'interactive': true,
            'defaultText': 'Add More Assumptions',
            'placeholderColor': '#666666'
        });
        $('#list_of_models').tagsInput({
            'height': 'auto',
            'width': '100%',
            'interactive': true,
            'defaultText': 'Add List Of Models',
            'placeholderColor': '#666666'
        });
        $('#recommendations').tagsInput({
            'height': 'auto',
            'width': '100%',
            'interactive': true,
            'defaultText': 'Add More Recommendations',
            'placeholderColor': '#666666'
        });
    });
</script>
@endpush