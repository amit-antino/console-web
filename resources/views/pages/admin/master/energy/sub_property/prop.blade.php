<div id="remove-section-{{$count+1}}">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="control-label">Field Name<span class="text-danger">*</span>
                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Unit Constant Name"></i></span>
            </label>
            <input type="text" class="form-control" name="dynamic_fields[{{$count+1}}][field_name]" placeholder="Enter Field Name">
        </div>
        <div class="form-group col-md-4">
            <label class="control-label">Field Type<span class="text-danger">*</span>
                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Field Type"></i></span>
            </label>
            <select class="form-control" data-request="ajax-append-fields" data-target="#sub-property-select-unit-list-{{$count+1}}" data-count="{{$count+1}}" data-url="{{url('admin/chemical-unit-select-list')}}" name="dynamic_fields[{{$count+1}}][field_type]">
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
            <button type="button" class="btn btn-sm btn-danger btn-icon">
                <i class="fas fa-minus-circle" data-target="#remove-section-{{$count+1}}" data-count="{{$count+1}}" data-type="reactant" data-request="remove"></i>
            </button>
        </div>
    </div>
    <div class="sub-property-select-unit-list-{{$count+1}}" id="sub-property-select-unit-list-{{$count+1}}"></div>
</div>