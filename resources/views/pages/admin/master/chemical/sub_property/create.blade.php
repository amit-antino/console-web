@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/master/chemical/sub_property')}}">Chemical Sub Properties</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add Chemical Sub Property</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('admin/master/chemical/sub_property/')}}" role="roles" method="POST">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Add Chemical Sub Property</h4>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="property_id">Property
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Property"></i></span>
                            </label>
                            <select id="property_id" class="form-control" name="property_id">
                                <option value="">Select Property</option>
                                @if(!empty($properties))
                                @foreach($properties as $property)
                                <option value="{{___encrypt($property->id)}}">{{$property->property_name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="sub_property_name">Sub Property Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Sub Property Name"></i></span>
                            </label>
                            <input type="text" id="sub_property_name" class="form-control" name="sub_property_name" placeholder="Enter Sub Property Name">
                        </div>
                        <div class="form-group col-md-6">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="">Field Name
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Field Name"></i></span>
                                    </label>
                                    <input type="text" class="form-control" name="dynamic_fields[0][field_name]" placeholder="Enter Field Name">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="">Field Type
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Field Type"></i></span>
                                    </label>
                                    <select class="form-control" data-request="ajax-append-fields" data-target="#sub-property-select-unit-list-6" data-count="0" data-url="{{url('admin/chemical-unit-select-list')}}" name="dynamic_fields[0][field_type]">
                                        <option value="">Select Field Type</option>
                                        <option value="1">Text Input</option>
                                        <option value="2">Checkbox Input</option>
                                        <option value="3">Radio Input</option>
                                        <option value="4">Date Input</option>
                                        <option value="5">DropDown With Input</option>
                                        <option value="6">DropDown Without Input</option>
                                        <option value="7">Multiselect Input</option>
                                        <option value="8">TextArea Input</option>
                                        <option value="9">Tags Input</option>
                                        <option value="10">Time Input</option>
                                        <option value="11">File Input</option>
                                        <option value="12">Number Input</option>
                                        <option value="13">Add More Input</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for=""><span class="text-danger">&nbsp;&nbsp;</span></label>
                                    </br>
                                    <button data-types="constant" data-target="#sub-property" data-url="{{url('/admin/master/chemical/sub_property/add-more-sub-property-field')}}" data-request="add-another" data-count="0" type="button" class="btn btn-secondary btn-sm btn-icon" data-toggle="tooltip" data-placement="bottom" title="Add">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="sub-property-select-unit-list-6" id="sub-property-select-unit-list-6"></div>
                            <div class="sub-property" id="sub-property"></div>
                        </div>
                        <div class="form-group col-md-6">
                            @include('pages.admin.master.chemical.sub_property.common-fields')
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="roles"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{ url('/admin/master/chemical/sub_property') }}" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(function() {
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }
        if ($(".js-example-basic-multiple").length) {
            $(".js-example-basic-multiple").select2();
        }
    });
</script>
@endpush