<div class="modal fade" id="editconditionModalMaster{{___encrypt($count)}}" tabindex="-1" role="dialog" aria-labelledby="add_conditionLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" role="edit_form_condition{{___encrypt($count)}}" action="{{url('experiment/experiment/add_condition_list')}}">
                <input type="hidden" name="count" value="{{___encrypt($count)}}">
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
                            <label class="control-label">Select Condition
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Condition"></i></span>
                            </label>
                            <input type="hidden" name="condition_id" value="{{___encrypt($master_condition['condition_id'])}}">
                            <input type="text" class="form-control" value="{{$master_condition['condition_name']}}" readonly>
                        </div>
                        <div class="form-group col-md-12" id="associateData{{___encrypt($count)}}">
                            <div class="form-row">
                                <input type="hidden" name="unit_id" id="unit_id" value="{{___encrypt($master_condition['unit_id'])}}">
                                <div class="form-group col-md-12">
                                    <label class="control-label">Enter Value and Select Unit Type
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Value and Select Unit Type"></i></span>
                                    </label>
                                    <div class="input-group">
                                        <div class="col-md-6">
                                            <input type="number" min="0.0000000001" data-request="isnumeric" class="form-control" id="value" name="value" placeholder="Enter Value" value="{{$master_condition['value']}}" />
                                        </div>
                                        <div class="col-md-6">
                                            <select class="js-example-basic-single" id="unit_constant_id" name="unit_constant_id">
                                            <option value=""> Select Unit Type</option>
                                            @if(!empty($master_condition['unit_constants']))
                                            @foreach($master_condition['unit_constants'] as $unit_constant)
                                            @if(!empty($master_condition['unit_constant_id']))
                                            <option @if($master_condition['unit_constant_id']==$unit_constant['id']) selected @endif value="{{___encrypt($unit_constant['id'])}}">{{$unit_constant['unit_name']}}</option>
                                            @else
                                            <option @if($master_condition['default_unit']==$unit_constant['id']) selected @endif value="{{___encrypt($unit_constant['id'])}}">{{$unit_constant['unit_name']}}</option>
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
                    <button type="button" data-ajax_list="#condition_list_master" data-model_id="#editconditionModalMaster{{___encrypt($count)}}" data-target='[role="edit_form_condition{{___encrypt($count)}}"]' data-request="ajax-submit-popup-form" class="btn btn-sm btn-secondary submit">Update</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>