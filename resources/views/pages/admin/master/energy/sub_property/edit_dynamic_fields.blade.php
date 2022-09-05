@php $total_count = count($sub_property->dynamic_fields) @endphp
@if($sub_property->dynamic_fields)
@foreach($sub_property->dynamic_fields as $count => $fields)
<div id="remove-section-dynamic{{$count}}">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="control-label">Field Name
                <span class="text-danger">*</span>
                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Field Name"></i></span>
            </label>
            <input type="text" value="{{!empty($fields['field_name'])?$fields['field_name']:''}}" class="form-control" name="dynamic_fields[{{$count}}][field_name]" placeholder="Enter Field Name">
        </div>
        <div class="form-group col-md-4">
            <label class="control-label">Field Type
                <span class="text-danger">*</span>
                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Field Type"></i></span>
            </label>
            <select class="form-control" data-request="ajax-append-fields" data-target="#sub-property-select-unit-list-{{$count}}" data-count="{{$count}}" data-url="{{url('admin/chemical-unit-select-list')}}" name="dynamic_fields[{{$count}}][field_type]">
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
            <button type="button" class="btn btn-sm btn-danger btn-icon" data-target="#remove-section-dynamic{{$count}}" data-count="{{$count}}" data-type="reactant" data-request="remove">
                <i class="fas fa-minus-circle"></i>
            </button>
        </div>
    </div>
    <div id="sub-property-select-unit-list-{{$count}}">
        @if(!empty($fields['field_type_id']) && $fields['field_type_id']=='5' || $fields['field_type_id']=='6' || $fields['field_type_id']=='7')
        <div class="form-row">
            <div class="form-group col-md-6">
                <label class="control-label">Field Name
                    <span class="text-danger">*</span>
                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Field Name"></i></span>
                </label>
                <input type="text" value="{{!empty($fields['field_name'])?$fields['field_name']:''}}" class="form-control" name="dynamic_fields[{{$count}}][field_name]" placeholder="Enter Field Name">
            </div>
            <div class="form-group col-md-5">
                <label for="">Select Product Or Unit Type
                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Product or Unit Type"></i></span>
                </label>
                @php
                $unit_name = !empty($fields['unit_id'])?$fields['unit_id']:'';
                @endphp
                <select class="js-example-basic-single" name="dynamic_fields[{{$count}}][unit_name]" data-request="ajax-append-fields" data-target="#constant-unit-list-6" data-count="0" data-url="{{url('admin/constant_unit_list')}}">
                    <option value="">Select Any</option>
                    <optgroup label="Composition / Associated">
                        @foreach($sub_props as $sub_prop)
                        @if($sub_prop->property_id == 2)
                        <option @if($unit_name==$sub_prop->id) selected @endif value="{{___encrypt($sub_prop->id)}}">{{$sub_prop->sub_property_name}}</option>
                        @endif
                        @endforeach
                    </optgroup>
                    <optgroup label="Hazard / Material Safety Data Sheets">
                        @foreach($sub_props as $sub_prop)
                        @if($sub_prop->property_id == 5)
                        <option @if($unit_name==$sub_prop->id) selected @endif value="{{___encrypt($sub_prop->id)}}">{{$sub_prop->sub_property_name}}</option>
                        @endif
                        @endforeach
                    </optgroup>
                    <optgroup label="Master Unit Types">
                        @foreach($master_units as $units)
                        <option @if($unit_name==$units->id) selected @endif value="{{___encrypt($units->id)}}">{{$units->unit_name}}</option>
                        @endforeach
                    </optgroup>
                </select>
            </div>

        </div>
        @endif
        @if(!empty($fields['field_type_id']) && $fields['field_type_id']=='13' )
        <div class="form-group col-md-6">
            <label for="">Select Chemical Or Unit Type
                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Product or Unit Type"></i></span>
            </label>
            @php
            $unit_name = !empty($fields['unit_id'])?$fields['unit_id']:'';
            @endphp
            <select class="js-example-basic-multiple" multiple name="dynamic_fields[{{$count}}][unit_name][]">
                <optgroup label="Composition / Associated">
                    @foreach($sub_props as $sub_prop)
                    @if($sub_prop->property_id == 2)
                    <option @if($unit_name==$sub_prop->id) selected @endif value="{{___encrypt($sub_prop->id)}}">{{$sub_prop->sub_property_name}}</option>
                    @endif
                    @endforeach
                </optgroup>
                <optgroup label="Hazard / Material Safety Data Sheets">
                    @foreach($sub_props as $sub_prop)
                    @if($sub_prop->property_id == 5)
                    <option @if($unit_name==$sub_prop->id) selected @endif value="{{___encrypt($sub_prop->id)}}">{{$sub_prop->sub_property_name}}</option>
                    @endif
                    @endforeach
                </optgroup>
                <optgroup label="Master Unit Types">
                    @foreach($master_units as $units)
                    <option @if($unit_name==$units->id) selected @endif value="{{___encrypt($units->id)}}">{{$units->unit_name}}</option>
                    @endforeach
                </optgroup>
            </select>
        </div>

        @endif
    </div>
</div>
@endforeach
@endif