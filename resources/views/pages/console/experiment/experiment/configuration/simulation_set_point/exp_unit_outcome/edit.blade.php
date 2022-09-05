<div class="modal fade" id="outcome_measured_data_exp_outcome_edit_modal{{$count}}" tabindex="-1" role="dialog" aria-labelledby="outcome_measured_data_exp_outcome_edit_modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{url('experiment/experiment/setpoint-exp-unit-outcome-list?process_experiment_id='.$unit_outcome['experiment_id'])}}" role="edit_output_exp_unit_outcome{{$count}}">
                <input type="hidden" name="count" value="{{$count}}">
                <input type="hidden" name="id" value="{{___encrypt($unit_outcome['id'])}}">
                <input type="hidden" name="simulate_input_id" value="{{___encrypt($simulate_input_id)}}">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase font-weight-normal" id="outcome_measured_data_exp_outcome_edit_modal">Edit Outcome</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Experiment Unit
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Experiment Unit"></i></span>
                            </label>
                            <input type="hidden" name="exp_unit_id" id="exp_unit_id" value="{{___encrypt($unit_outcome['exp_unit_id'])}}">
                            <input type="text" value="{{$unit_outcome['exp_unit_name']}}" class="form-control" readonly>

                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Outcome
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Outcome"></i></span>
                            </label>
                            <input type="hidden" name="outcome_id" id="outcome_id" value="{{___encrypt($unit_outcome['outcome_id'])}}">
                            <input type="text" value="{{$unit_outcome['outcome_name']}}" class="form-control" readonly>
                            <input type="hidden" value="{{___encrypt($unit_outcome['unit_id'])}}" name="unit_id">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Select Priority
                                <!-- <span class="text-danger">*</span> -->
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Priority"></i></span>
                            </label>
                            <select class="form-control" name="priority" id="priority">
                                <option value="">Select Priority</option>
                                @if(!empty($priority))
                                @foreach($priority as $priorities)
                                <option @if($unit_outcome['priority']==$priorities->id) selected @endif value="{{___encrypt($priorities->id)}}">{{$priorities->name}}</option>
                                @endforeach
                                @endif

                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Select Criteria
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Criteria"></i></span>
                            </label>
                            <select data-target="#setpoint-exp-unit-outcome-value{{$count}}" data-count="{{$count}}" data-method="POST" data-type="condition" data-request="ajax-append-fields" data-url="{{url('experiment/experiment/range-value-field')}}" class="form-control" id="criteria" name="criteria">
                                <option value="">Select Criteria</option>
                                @if(!empty($criteria))
                                @foreach($criteria as $criterias)
                                <option @if($unit_outcome['criteria']==$criterias->id) selected @endif value="{{___encrypt($criterias->id)}}">{{$criterias->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="control-label">Enter Value and Select Unit Type
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Value and Select Unit Type"></i></span>
                                    </label>
                                    <div class="input-group">
                                        <div class="col-md-6">
                                            <input type="number" min="0.0000000001" data-request="isnumeric" value="{{$unit_outcome['value']}}" class="form-control" id="value" name="value" placeholder="Enter Value" />
                                            <div id="setpoint-exp-unit-outcome-value{{$count}}">
                                                @if(!empty($unit_outcome['max_value']))
                                                <input type="number" min="0.0000000001" data-request="isnumeric" value="{{$unit_outcome['max_value']}}" class="form-control" id="max_value" name="max_value" placeholder="Enter Value" />
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                        <select class="js-example-basic-single" id="unit_constant_id" name="unit_constant_id">
                                            <option value="">Select Unit Type</option>
                                            @if(!empty($unit_outcome['unit_constants']))
                                            @foreach($unit_outcome['unit_constants'] as $const)
                                            @if(!empty($unit_outcome['unit_constant_id']))
                                            <option @if($unit_outcome['unit_constant_id']==$const['id']) selected @endif value="{{___encrypt($const['id'])}}">{{$const['unit_name']}}</option>
                                            @else
                                            <option @if($unit_outcome['default_unit']==$const['id']) selected @endif value="{{___encrypt($const['id'])}}">{{$const['unit_name']}}</option>
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
                </div>
                <div class="modal-footer">
                    <button type="button" data-ajax_list="#exp_unit_outcome_list" data-model_id="#outcome_measured_data_exp_outcome_edit_modal{{$count}}" data-request="ajax-submit-popup-form" data-target='[role="edit_output_exp_unit_outcome{{$count}}"]' class="btn btn-sm btn-secondary submit">Update</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>