<div class="modal fade" id="editUnitconditionModal{{$count}}" tabindex="-1" role="dialog" aria-labelledby="add_conditionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{url('experiment/experiment/add-exp-unit-condition-list?process_experiment_id='.$unit_condition['experiment_id'])}}" role="edit_output_exp_unit_condition{{$count}}">
                <input type="hidden" name="id" value="{{___encrypt($id)}}">
                <input type="hidden" name="simulate_input_id" value="{{___encrypt($simulate_input_id)}}">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase font-weight-normal" id="add_conditionLabel">Edit Condition</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Experiment Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Experiment"></i></span>
                            </label>
                            <input type="hidden" name="exp_unit_id" id="exp_unit_id" value="{{___encrypt($unit_condition['exp_unit_id'])}}" class="form-control">
                            <input type="text" value="{{$unit_condition['exp_unit_name']}}" class="form-control" readonly>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="control-label">Condition
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Condition"></i></span>
                                    </label>
                                    <input type="hidden" name="condition_id" id="condition_id" value="{{___encrypt($unit_condition['condition_id'])}}" class="form-control">
                                    <input type="text" value="{{$unit_condition['condition_name']}}" class="form-control" readonly>
                                </div>

                                <input type="hidden" name="unit_id" id="unit_id" value="{{___encrypt($unit_condition['unit_id'])}}">
                                <div class="form-group col-md-12">
                                    <label class="control-label">Enter Value and Select Unit Type
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Value and Select Unit Type"></i></span>
                                    </label>
                                    <div class="input-group">
                                        <input type="number" min="0.0000000001" data-request="isnumeric" value="{{$unit_condition['value']}}" class="form-control" id="value" name="value" placeholder="Enter Value" />
                                        <select class="js-example-basic-single" id="unit_constant_id" name="unit_constant_id">
                                            <option value=""> Select Unit Type</option>
                                            @if(!empty($unit_condition['unit_constants']))
                                            @foreach($unit_condition['unit_constants'] as $const)
                                            @if(!empty($unit_condition['unit_constant_id']))
                                            <option @if($unit_condition['unit_constant_id']==$const['id']) selected @endif value="{{___encrypt($const['id'])}}">{{$const['unit_name']}}</option>
                                            @else
                                            <option @if($unit_condition['default_unit']==$const['id']) selected @endif value="{{___encrypt($const['id'])}}">{{$const['unit_name']}}</option>
                                            @endif
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-ajax_list="#exp_unit_condition_list" data-model_id="#editUnitconditionModal{{$count}}" data-request="ajax-submit-popup-form" data-target='[role="edit_output_exp_unit_condition{{$count}}"]' class="btn btn-sm btn-secondary submit">Update</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>