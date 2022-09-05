@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/other_inputs/energy') }}">Energy and Utilities</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add Energy and Utilities</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card">
            <form action="{{ url('/other_inputs/energy') }}" method="POST" role="energy">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Add Energy and Utilities</h4>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="energy_name">Enter Energy and Utility Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Energy and Utility Name"></i></span>
                            </label>
                            <input type="text" id="energy_name" name="energy_name" class="form-control" data-request="isalphanumeric" placeholder="Enter Energy and Utility Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="base_unit_type">Select Base Unit Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Base Unit"></i></span>
                            </label>
                            <select id="base_unit_type" name="base_unit_type" class="js-example-basic-single" required>
                                <option value="">Select Base Unit Type</option>
                                @if(!empty($unit_types))
                                @foreach($unit_types as $unit_type)
                                <option value="{{ ___encrypt($unit_type->id) }}">{{$unit_type->unit_name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="vendor_id">Select Vendor / Supplier
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Vendor / Supplier"></i></span>
                            </label>
                            <select id="vendor_id" name="vendor_id" class="js-example-basic-single" required>
                                <option value="">Select Vendor / Supplier</option>
                                @if(!empty($vendors))
                                @foreach($vendors as $vendor)
                                <option value="{{ ___encrypt($vendor->id) }}">{{$vendor->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            @include('pages.location.country')
                        </div>
                        <div class="form-group col-md-6">
                            @include('pages.location.state')
                        </div>
                        <div class="form-group col-md-6">
                            @include('pages.location.city')
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Equipment Description"></i></span>
                            </label>
                            <textarea name="description" id="description" data-request="isalphanumeric" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="tags">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Equipment Tags"></i></span>
                            </label>
                            <input type="text" id="tags" name="tags" class="form-control" placeholder="Tags">
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="energy"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{ url('/other_inputs/energy') }}" class="btn btn-sm btn-danger">Cancel</a>
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
    $(function() {
        // Tags
        $('#tags').tagsInput({
            'height': 'auto',
            'width': '100%',
            'interactive': true,
            'defaultText': 'Add More',
            'removeWithBackspace': true,
            'minChars': 0,
            'maxChars': 20,
            'placeholderColor': '#666666'
        });
        // Multi Select
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }
    });
</script>
@endpush