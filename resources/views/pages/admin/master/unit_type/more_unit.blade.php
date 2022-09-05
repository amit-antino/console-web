<div id="remove-section-{{$count+1}}">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label class="control-label">Unit Constant Name
                <span class="text-danger">*</span>
                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Unit Constant Name"></i></span>
            </label>
            <input type="text" class="form-control" name="unit_constant[{{$count+1}}][unit_name]" placeholder="Enter Unit Constant Name">
        </div>
        <div class="form-group col-md-4">
            <label class="control-label">Unit Constant Symbol
                <span class="text-danger">*</span>
                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Unit Constant Symbol"></i></span>
            </label>
            <input type="text" class="form-control" name="unit_constant[{{$count+1}}][unit_symbol]" placeholder="Enter Unit Constant Symbol">
        </div>
        <div class="form-group col-md-2">
            <label class="control-label">
                <span class="text-danger">&nbsp;&nbsp;</span>
            </label>
            <br>
            <button type="button" class="btn btn-sm btn-danger btn-icon" data-target="#remove-section-{{$count+1}}" data-count="{{$count+1}}" data-type="reactant" data-request="remove">
                <i class="fas fa-minus-circle"></i>
            </button>
        </div>
    </div>
</div>