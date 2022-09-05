<div class="form-row" id="remove-section-{{$count+1}}">
    <div class="form-group col-md-6">
        <label for="">Experiment Unit Name
            <span class="text-danger">*</span>
            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Experiment Unit Name"></i></span>
        </label>
        <input type="text" name="unit[{{$count+1}}][unit]" class="form-control" value="">
    </div>
    <div class="form-group col-md-4">
        <label for="experiment_unit">Select Experiment Unit
            <span class="text-danger">*</span>
            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Experiment Unit"></i></span>
        </label>
        <select data-width="100%" class="js-example-basic-single" name="unit[{{$count+1}}][exp_unit]">
            <option value="">Select Experiment Unit</option>
            @if(!empty($experiment_units))
            @foreach($experiment_units as $experiment_unit)
            <option value="{{___encrypt($experiment_unit->id)}}">{{$experiment_unit->experiment_unit_name}}</option>
            @endforeach
            @else
            <option value="">Select Experiment Unit</option>
            @endif
        </select>
    </div>
    <div class="form-group col-md-2">
        <label id="action_tour_id">&nbsp;
        </label><br>
        <button type="button" class="btn btn-icon tr_clone_remove">
            <i class="fas fa-minus text-danger" data-target="#remove-section-{{$count+1}}" data-count="{{$count+1}}" data-request="remove"></i>
        </button>
    </div>
</div>