@if(!empty(_arefy($sub_property_field)))
@foreach($sub_property_field->dynamic_fields as $count => $fields)
@php
$field_name = !empty($fields['field_name'])?$fields['field_name']:'';
$field_type = !empty($fields['field_type'])?$fields['field_type']:'';
$unit_name = !empty($fields['unit_name'])?$fields['unit_name']:'';
$field_name = !empty($field_name)?$field_name:'';
$field_id = str_replace(' ','_',$field_name);
$field_id = strtolower($field_id);
$val_prop = $property['dynamic_prop_json'];
@endphp
@if($field_type=='Select' && $val_prop[$count]['field_type']=='Select')
<div class="form-group col-md-12">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="{{$field_id}}">{{$field_name}}
                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
            </label>
            <select class="js-example-basic-single prop-id" alt="{{___encrypt($property_id)}}" name="dynamic_prop[{{$count}}][value]">
                <option value="">Select {{$field_name}}</option>
                @if(!empty($unit_name))
                @if($unit_name=='chemical_list')
                @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.chemical_list')
                @elseif($unit_name=='p_codes' || $sub_property_field->property_id==5 && $unit_name==177)
                @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.p_code_list')
                @elseif($unit_name=='r_codes' || $sub_property_field->property_id==5 && $unit_name==180)
                @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.r_code_list')
                @elseif($unit_name=='h_codes' || $sub_property_field->property_id==5 && $unit_name==166)
                @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.h_code_list')
                @elseif($unit_name=='EU-Classification' || $sub_property_field->property_id==5 && $unit_name==163)
                @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.eu_class_list')
                @elseif($unit_name=='NFPA flammability' || $sub_property_field->property_id==5 && $unit_name==173)
                @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.nfpa_flame')
                @elseif($unit_name=='NFPA health' || $sub_property_field->property_id==5 && $unit_name==174)
                @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.nfpa_health')
                @elseif($unit_name=='NFPA reactivity' || $sub_property_field->property_id==5 && $unit_name==175)
                @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.nfpa_reactivity')
                @elseif($unit_name=='WGK substance Class' || $sub_property_field->property_id==5 && $unit_name==182)
                @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.wgk_code')
                @elseif($unit_name=='Gk-code' || $sub_property_field->property_id==5 && $unit_name==165)
                @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.gk_code')
                @elseif($unit_name=='GHS-code' || $sub_property_field->property_id==5 && $unit_name==198)
                @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.ghs_code')
                @else
                @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.unit_list')
                @endif
                @endif
            </select>
        </div>
        <div class="form-group col-md-6">
            <label for="{{$field_id}}">{{$field_name}}
                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
            </label>
            <input type="number" min="0.0000000001" data-request="isnumeric" name="dynamic_prop[{{$count}}][unit_value]" value="{{!empty($val_prop[$count]['unit_value'])?$val_prop[$count]['unit_value']:''}}" class="form-control">
        </div>
        <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
        <input type="hidden" name="dynamic_prop[{{$count}}][unit_name]" value="{{$unit_name}}">
        <input type="hidden" name="dynamic_prop[{{$count}}][key]" value="{{$field_name}}">
    </div>
</div>
@endif
@if($field_type=='dropdown_only' && $val_prop[$count]['field_type']=='dropdown_only')
<div class="form-group col-md-12">
    <div class="form-row">
        <label for="{{$field_id}}">{{$field_name}}
            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
        </label>
        <select class="js-example-basic-single prop-id" alt="{{___encrypt($property_id)}}" name="dynamic_prop[{{$count}}][value]">
            <option value="">Select {{$field_name}}</option>
            @if(!empty($unit_name))
            @if($unit_name=='chemical_list')
            @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.chemical_list')
            @elseif($unit_name=='p_codes' || $sub_property_field->property_id==5 && $unit_name==177)
            @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.p_code_list')
            @elseif($unit_name=='r_codes' || $sub_property_field->property_id==5 && $unit_name==180)
            @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.r_code_list')
            @elseif($unit_name=='h_codes' || $sub_property_field->property_id==5 && $unit_name==166)
            @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.h_code_list')
            @elseif($unit_name=='EU-Classification' || $sub_property_field->property_id==5 && $unit_name==163)
            @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.eu_class_list')
            @elseif($unit_name=='NFPA flammability' || $sub_property_field->property_id==5 && $unit_name==173)
            @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.nfpa_flame')
            @elseif($unit_name=='NFPA health' || $sub_property_field->property_id==5 && $unit_name==174)
            @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.nfpa_health')
            @elseif($unit_name=='NFPA reactivity' || $sub_property_field->property_id==5 && $unit_name==175)
            @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.nfpa_reactivity')
            @elseif($unit_name=='WGK substance Class' || $sub_property_field->property_id==5 && $unit_name==182)
            @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.wgk_code')
            @elseif($unit_name=='Gk-code' || $sub_property_field->property_id==5 && $unit_name==165)
            @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.gk_code')
            @elseif($unit_name=='GHS-code' || $sub_property_field->property_id==5 && $unit_name==198)
            @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.ghs_code')
            @else
            @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.unit_list')
            @endif
            @endif
        </select>
        <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
        <input type="hidden" name="dynamic_prop[{{$count}}][unit_name]" value="{{$unit_name}}">
        <input type="hidden" name="dynamic_prop[{{$count}}][key]" value="{{$field_name}}">
    </div>
</div>
@endif
@if($field_type=='add_more' && $val_prop[$count]['field_type']=='add_more')
@include('pages.console.product.chemical.manage_properties.edit.add_more_dynamic_edit')
@endif
@if($field_type=='text' && $val_prop[$count]['field_type']=='text')
<div class="form-group col-md-4">
    <label for="{{$field_id}}">{{$field_name}}
        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
    </label>
    <input type="text" value="{{$val_prop[$count]['field_value']}}" name="dynamic_prop[{{$count}}][value]" id="{{$field_id}}" class="form-control">
    <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
    <input type="hidden" name="dynamic_prop[{{$count}}][key]" value="{{$field_name}}">
</div>
@endif
@if($field_type=='radio' && $val_prop[$count]['field_type']=='radio')
<div class="form-group col-md-4">
    <label for="{{$field_id}}">{{$field_name}}
        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
    </label>
    <input type="radio" @if($val_prop[$count]['field_value']=='on' ) checked @endif class="form-control" id="{{$field_id}}" name="dynamic_prop[{{$count}}][value]">
    <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
    <input type="hidden" name="dynamic_prop[{{$count}}][key]" value="{{$field_name}}">
</div>
@endif
@if($field_type=='date' && $val_prop[$count]['field_type']=='date')
<div class="form-group col-md-4">
    <label for="{{$field_id}}">{{$field_name}}
        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
    </label>
    <input type="date" value="{{$val_prop[$count]['field_value']}}" name="dynamic_prop[{{$count}}][value]" id="{{$field_id}}" class="form-control">
    <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
    <input type="hidden" name="dynamic_prop[{{$count}}][key]" value="{{$field_name}}">
</div>
@endif
@if($field_type=='multiselect' && $val_prop[$count]['field_type']=='multiselect')
<div class="form-group col-md-12">
    <label for="{{$field_id}}">{{$field_name}}
        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
    </label>
    <select class="prop-id js-example-basic-multiple" alt="{{___encrypt($property_id)}}" name="dynamic_prop[{{$count}}][value][]" multiple="">
        <option value="">Select {{$field_name}}</option>
        @if(!empty($unit_name))
        @if($unit_name=='chemical_list')
        @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.chemical_list')
        @elseif($unit_name=='p_codes' || $sub_property_field->property_id==5 && $unit_name==177)
        @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.p_code_list')
        @elseif($unit_name=='r_codes' || $sub_property_field->property_id==5 && $unit_name==180)
        @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.r_code_list')
        @elseif($unit_name=='h_codes' || $sub_property_field->property_id==5 && $unit_name==166)
        @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.h_code_list')
        @elseif($unit_name=='EU-Classification' || $sub_property_field->property_id==5 && $unit_name==163)
        @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.eu_class_list')
        @elseif($unit_name=='NFPA flammability' || $sub_property_field->property_id==5 && $unit_name==173)
        @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.nfpa_flame')
        @elseif($unit_name=='NFPA health' || $sub_property_field->property_id==5 && $unit_name==174)
        @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.nfpa_health')
        @elseif($unit_name=='NFPA reactivity' || $sub_property_field->property_id==5 && $unit_name==175)
        @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.nfpa_reactivity')
        @elseif($unit_name=='WGK substance Class' || $sub_property_field->property_id==5 && $unit_name==182)
        @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.wgk_code')
        @elseif($unit_name=='Gk-code' || $sub_property_field->property_id==5 && $unit_name==165)
        @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.gk_code')
        @elseif($unit_name=='GHS-code' || $sub_property_field->property_id==5 && $unit_name==198)
        @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.ghs_code')
        @else
        @include('pages.console.product.chemical.manage_properties.edit.dynamic_select_list_edit.unit_list')
        @endif
        @endif
    </select>
    <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
    <input type="hidden" name="dynamic_prop[{{$count}}][key]" value="{{$field_name}}">
    <input type="hidden" name="dynamic_prop[{{$count}}][unit_name]" value="{{$unit_name}}">
</div>
@endif
@if($field_type=='textarea' && $val_prop[$count]['field_type']=='textarea')
<div class="form-group col-md-12">
    <label for="{{$field_id}}">{{$field_name}}
        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
    </label>
    <textarea name="dynamic_prop[{{$count}}][value]" rows="5" id="{{$field_id}}" class="form-control">{{$val_prop[$count]['field_value']}}</textarea>
    <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
    <input type="hidden" name="dynamic_prop[{{$count}}][key]" value="{{$field_name}}">
</div>
@endif
@if($field_type=='time' && $val_prop[$count]['field_type']=='time')
<div class="form-group col-md-4">
    <label for="{{$field_id}}">{{$field_name}}
        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
    </label>
    <input type="time" value="{{$val_prop[$count]['field_value']}}" name="dynamic_prop[{{$count}}][value]" id="{{$field_id}}" class="form-control">
    <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
    <input type="hidden" name="dynamic_prop[{{$count}}][key]" value="{{$field_name}}">
</div>
@endif
@if($field_type=='file' && $val_prop[$count]['field_type']=='file')
<div class="form-group col-md-12">
    <label for="{{$field_id}}">{{$field_name}}
        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
    </label>
    <input type="file" name="dynamic_prop[{{$count}}][value]" id="{{$field_id}}" class="form-control">
    <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
    <input type="hidden" name="dynamic_prop[{{$count}}][key]" value="{{$field_name}}">
</div>
@endif
@if($field_type=='Number' && $val_prop[$count]['field_type']=='Number')
<div class="form-group col-md-4">
    <label for="{{$field_id}}">{{$field_name}}
        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
    </label>
    <input type="number" min="0.0000000001" data-request="isnumeric" value="{{$val_prop[$count]['field_value']}}" name="dynamic_prop[{{$count}}][value]" id="{{$field_id}}" class="form-control">
    <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
    <input type="hidden" name="dynamic_prop[{{$count}}][key]" value="{{$field_name}}">
</div>
@endif
@if($field_type=='tags' && $val_prop[$count]['field_type']=='tags')
<div class="form-group col-md-12">
    <label for="{{$field_id}}">{{$field_name}}
        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
    </label>
    <input type="text" class="form-control" id="tags" name="dynamic_prop[{{$count}}][value]" value="{{$val_prop[$count]['field_value']}}" />
    <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
    <input type="hidden" name="dynamic_prop[{{$count}}][key]" value="{{$field_name}}">
</div>
@endif
@if($field_type=='checkbox' && $val_prop[$count]['field_type']=='checkbox')
<div class="form-group col-md-4">
    <label class="form-check form-check-label form-check-inline">
        <input type="checkbox" @if($val_prop[$count]['field_value']=='on' ) checked @endif id="{{$field_id}}" class="form-check-input" name="dynamic_prop[{{$count}}][value]">{{$field_name}}
    </label>
    <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
    <input type="hidden" name="dynamic_prop[{{$count}}][key]" value="{{$field_name}}">
</div>
@endif
@endforeach
@endif