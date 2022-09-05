@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/master/energy_utilities/sub_property')}}">Sub Property</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Sub Property</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('admin/master/energy_utilities/sub_property/'.___encrypt($sub_property->id))}}" role="sub-property" method="POST">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Edit Sub Property : {{$sub_property->sub_property_name}}</h4>
                </div>
                <input type="hidden" name="_method" value="PUT">
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Main Property
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Main Property"></i></span>
                            </label>
                            <select class="form-control" name="property">
                                <option value="">Select Main Property</option>
                                @if(!empty($properties))
                                @foreach($properties as $proper)
                                <option @if($sub_property->property_id == $proper->id) selected @endif value="{{___encrypt($proper->id)}}">{{$proper->property_name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="base_unit_type">Select Base Unit Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Base Unit Type"></i></span>
                            </label>
                            <select id="base_unit_type" name="base_unit_type" class="js-example-basic-single" required>
                                <option value="">Select Base Unit Type</option>
                                @if(!empty($base_unit_types))
                                @foreach($base_unit_types as $unit_type)
                                <option @if(___encrypt($unit_type->id)==___encrypt($sub_property->base_unit)) selected @endif value="{{ ___encrypt($unit_type->id)}}">{{$unit_type->unit_name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Sub Property Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Sub Property Name"></i></span>
                            </label>
                            <input type="text" value="{{$sub_property->sub_property_name}}" class="form-control" name="sub_property_name" placeholder="Enter Sub Property Name">
                        </div>
                        <div class="form-group col-md-6">
                            @if($sub_property->fields)
                            @foreach($sub_property->fields as $count => $fields)
                            <div id="remove-section-{{$count}}">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="control-label">Field Name
                                            <span class="text-danger">*</span>
                                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Field Name"></i></span>
                                        </label>
                                        <input type="text" value="{{!empty($fields['field_name'])?$fields['field_name']:''}}" class="form-control" name="fields[{{$count}}][field_name]" placeholder="Enter Field Name">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Field Type
                                            <span class="text-danger">*</span>
                                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Field Type"></i></span>
                                        </label>
                                        <select class="form-control" data-request="ajax-append-fields" data-target="#sub-property-select-unit-list-fields-{{$count}}" data-count="{{$count}}" data-url="{{url('admin/chemical-unit-select-list')}}" name="fields[{{$count}}][field_type]">
                                            <option value="">Select Field Type</option>
                                            <option @if(!empty($fields['field_type_id']) && $fields['field_type_id']=='1' ) selected="" @endif value="1">Text Input</option>
                                            <option @if(!empty($fields['field_type_id']) && $fields['field_type_id']=='2' ) selected="" @endif value="2">Checkbox Input</option>
                                            <option @if(!empty($fields['field_type_id']) && $fields['field_type_id']=='3' ) selected="" @endif value="3">Radio Input</option>
                                            <option @if(!empty($fields['field_type_id']) && $fields['field_type_id']=='4' ) selected="" @endif value="4">Date Input</option>
                                            <option @if(!empty($fields['field_type_id']) && $fields['field_type_id']=='5' ) selected="" @endif value="5">DropDown With Input</option>
                                            <option @if(!empty($fields['field_type_id']) && $fields['field_type_id']=='6' ) selected="" @endif value="6">DropDown Without Input</option>
                                            <option @if(!empty($fields['field_type_id']) && $fields['field_type_id']=='7' ) selected="" @endif value="7">Multiselect Input</option>
                                            <option @if(!empty($fields['field_type_id']) && $fields['field_type_id']=='8' ) selected="" @endif value="8">TextArea Input</option>
                                            <option @if(!empty($fields['field_type_id']) && $fields['field_type_id']=='9' ) selected="" @endif value="9">Tags Input</option>
                                            <option @if(!empty($fields['field_type_id']) && $fields['field_type_id']=='10' ) selected="" @endif value="10">Time Input</option>
                                            <option @if(!empty($fields['field_type_id']) && $fields['field_type_id']=='11' ) selected="" @endif value="11">File Input</option>
                                            <option @if(!empty($fields['field_type_id']) && $fields['field_type_id']=='12' ) selected="" @endif value="12">Number Input</option>
                                            <option @if(!empty($fields['field_type_id']) && $fields['field_type_id']=='13' ) selected="" @endif value="13">Add More Input</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label">
                                            <span class="text-danger">&nbsp;&nbsp;</span>
                                        </label>
                                        </br>
                                        <button type="button" class="btn btn-sm btn-danger btn-icon" data-target="#remove-section-{{$count}}" data-count="{{$count}}" data-type="reactant" data-request="remove">
                                            <i class="fas fa-minus-circle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            @include('pages.admin.master.chemical.sub_property.edit_dynamic_fields')
                            @php
                            if(!empty($sub_property->dynamic_fields)){
                            $total_count = count($sub_property->dynamic_fields);
                            }else{
                            $total_count=0;
                            }
                            @endphp
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="control-label">Field Name<span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Field Name"></i></span>
                                    </label>
                                    <input type="text" class="form-control" name="dynamic_fields[{{$total_count}}][field_name]" placeholder="Enter Field Name">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Field Type<span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Field Type"></i></span>
                                    </label>
                                    <select data-request="ajax-append-fields" data-target="#sub-property-select-unit-list-fields-dynamic{{$total_count}}" data-count="{{$total_count}}" data-url="{{url('admin/chemical-unit-select-list')}}" class="form-control" name="dynamic_fields[{{$total_count}}][field_type]">
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
                                    <label class="control-label"><span class="text-danger">&nbsp;&nbsp;</span></label>
                                    </br>
                                    <button data-types="constant" data-target="#sub-property" data-url="{{url('admin/master/energy_utilities/sub_property/add-more-sub-property-field')}}" data-request="add-another" data-count="{{$total_count}}" type="button" class="btn btn-sm btn-secondary btn-icon" data-toggle="tooltip" data-placement="bottom" title="Add">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                                <div id="sub-property-select-unit-list-fields-dynamic{{$total_count}}"></div>
                            </div>
                            <div class="sub-property" id="sub-property"></div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="sub-property"]' class="btn btn-sm btn-secondary submit">Update</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                        <a href="{{ url('/admin/master/energy_utilities/sub_property') }}" class="btn btn-sm btn-danger">Cancel</a>
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