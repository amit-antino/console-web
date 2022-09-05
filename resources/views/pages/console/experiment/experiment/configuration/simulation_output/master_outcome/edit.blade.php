<div class="modal fade" id="editoutcomeModalMaster{{$count}}" tabindex="-1" role="dialog" aria-labelledby="add_outcomeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" role="edit_form_outcome{{$count}}" action="{{url('experiment/experiment/add_condition_outcome_list')}}">
                <input type="hidden" name="count" value="{{$count}}">
                <input type="hidden" name="id" value="{{___encrypt($id)}}">
                <input type="hidden" name="simulate_input_id" value="{{___encrypt($simulate_input_id)}}">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase font-weight-normal" id="add_outcomeLabel">Edit Outcome</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Select Outcome
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Outcome"></i></span>
                            </label>
                            <input type="hidden" name="outcome_id" value="{{___encrypt($master_outcome['outcome_id'])}}">
                            <input type="text" class="form-control" value="{{$master_outcome['outcome_name']}}" readonly>
                        </div>
                        <div class="form-group col-md-12" id="associateDataOutcome{{$count}}">
                            <div class="form-row">
                                <input type="hidden" id="unit_id" name="unit_id" value="{{___encrypt($master_outcome['unit_id'])}}">
                                <div class="form-group col-md-12">
                                    <label class="control-label">Enter Value and Select Unit Type
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Value and Select Unit Type"></i></span>
                                    </label>
                                    <div class="input-group">
                                        <div class="col-md-6">
                                         <input type="number" min="0.0000000001" data-request="isnumeric" class="form-control" id="value" name="value" placeholder="Enter Value" value="{{$master_outcome['value']}}" />
                                        </div>
                                        <div class="col-md-6">
                                        <select class="js-example-basic-single form-control" id="unit_constant_id" name="unit_constant_id">
                                            <option value=""> Select Unit Type</option>
                                            @if(!empty($master_outcome['unit_constants']))
                                            @foreach($master_outcome['unit_constants'] as $unit_constant)
                                            @if(!empty($master_outcome['unit_constant_id']))
                                            <option @if($master_outcome['unit_constant_id']==$unit_constant['id']) selected @endif value="{{___encrypt($unit_constant['id'])}}">{{$unit_constant['unit_name']}}</option>
                                            @else
                                            <option @if($master_outcome['default_unit']==$unit_constant['id']) selected @endif value="{{___encrypt($unit_constant['id'])}}">{{$unit_constant['unit_name']}}</option>
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
                    <button type="button" data-ajax_list="#output_master_outcome_list" data-model_id="#editoutcomeModalMaster{{$count}}" data-request="ajax-submit-popup-form" data-target='[role="edit_form_outcome{{$count}}"]' class="btn btn-sm btn-secondary submit">Update</button>
                    <button class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>