@if($select_type=='5' || $select_type=='6' || $select_type=='7')
<div class="form-row">
    @if(!empty(_arefy($master_units)))
    <div class="form-group col-md-6">
        <label class="control-label">Field Name
            <span class="text-danger">*</span>
            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Field Name"></i></span>
        </label>
        <input type="text" class="form-control" name="dynamic_fields[{{$count}}][field_name]" placeholder="Enter Field Name">
    </div>
    <div class="form-group col-md-6">
        <label for="">Select Unit Type / Product / Property / Sub Property
            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Unit Type or Product or Property or Sub Property"></i></span>
        </label>
        <select class="js-example-basic-single" name="dynamic_fields[{{$count}}][unit_name]" data-request="ajax-append-fields" data-target="#constant-unit-list-6" data-count="0" data-url="{{url('admin/constant_unit_list')}}">
            <option value="">Select Any</option>
            <optgroup label="Composition / Associated">
                @foreach($sub_props as $sub_prop)
                @if($sub_prop->property_id == 2)
                <option value="{{___encrypt($sub_prop->id)}}">{{$sub_prop->sub_property_name}}</option>
                @endif
                @endforeach
            </optgroup>
            <optgroup label="Hazard / Material Safety Data Sheets">
                @foreach($sub_props as $sub_prop)
                @if($sub_prop->property_id == 5)
                <option value="{{___encrypt($sub_prop->id)}}">{{$sub_prop->sub_property_name}}</option>
                @endif
                @endforeach
            </optgroup>
            <optgroup label="Master Unit Types">
                @foreach($master_units as $units)
                <option value="{{___encrypt($units->id)}}">{{$units->unit_name}}</option>
                @endforeach
            </optgroup>
        </select>
    </div>
    @endif
</div>
@elseif($select_type=='13')
<div class="form-row">
    @if(!empty(_arefy($master_units)))
    <div class="form-group col-md-6">
        <label class="control-label">Field Name
            <span class="text-danger">*</span>
            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Field Name"></i></span>
        </label>
        <input type="text" class="form-control" name="dynamic_fields[{{$count}}][field_name]" placeholder="Enter Field Name">
    </div>
    <div class="form-group col-md-6">
        <label for="">Select Unit Type / Product / Property / Sub Property
            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Unit Type or Product or Property or Sub Property"></i></span>
        </label>
        <select class="js-example-basic-multiple" multiple name="dynamic_fields[{{$count}}][unit_name][]">
            <option value="">Select Any</option>
            <!-- <optgroup label="Composition / Associated">
                @foreach($sub_props as $sub_prop)
                @if($sub_prop->property_id == 2)
                <option value="{{___encrypt($sub_prop->id)}}">{{$sub_prop->sub_property_name}}</option>
                @endif
                @endforeach
            </optgroup>
            <optgroup label="Hazard / Material Safety Data Sheets">
                @foreach($sub_props as $sub_prop)
                @if($sub_prop->property_id == 5)
                <option value="{{___encrypt($sub_prop->id)}}">{{$sub_prop->sub_property_name}}</option>
                @endif
                @endforeach
            </optgroup> -->
            <optgroup label="Master Unit Types">
                @foreach($master_units as $units)
                <option value="{{___encrypt($units->id)}}">{{$units->unit_name}}</option>
                @endforeach
            </optgroup>
        </select>
    </div>

    @endif
</div>
@endif
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