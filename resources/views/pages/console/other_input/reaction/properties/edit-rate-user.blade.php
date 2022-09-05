<div class="modal fade" id="rate_user_edit{{$property->id}}" tabindex="-1" role="dialog" aria-labelledby="reaction_user_inputLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{url('/other_inputs/reaction/'.$reaction_id.'/addprop/'.___encrypt($property->id))}}" method="POST" role="rate-user-edit">
                <div class="modal-header">
                    <h5 class="modal-title" id="reaction_user_inputLabel">Edit User Input </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="{{___encrypt($reaction_id)}}" />
                    <input type="hidden" name="prop_type_name" value="rate_user">
                    <input type="hidden" name="type" value="rate_user_input">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="reaction_type">Select Reaction Type
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Reaction Type"></i></span>
                            </label>
                            <select class="form-control form-control-sm" id="reaction_type" name="reaction_type">
                                <option value="">Select Reaction Type</option>
                                <option @if($prop_data['reaction_type']=='Forward' ) selected @endif value="Forward">Forward</option>
                                <option @if($prop_data['reaction_type']=='Backward' ) selected @endif value="Backward">Backward</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Name
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Name"></i></span>
                            </label>
                            <input type="text" id="name" name="name" value="{{$prop_data['name']}}" class="form-control form-control-sm" placeholder="Enter Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="rate_constant">Rate constant (k)
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Rate constant (k)"></i></span>
                            </label>
                            <input type="text" id="rate_constant" value="{{$prop_data['rate_constant']}}" name="rate_constant" class="form-control form-control-sm" placeholder="Enter Rate constant (k)">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="temperature_k">Temperature (K)
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Temperature (K)"></i></span>
                            </label>
                            <input type="text" id="temperature_k" value="{{$prop_data['temperature_k']}}" name="temperature_k" class="form-control form-control-sm" placeholder="Enter Temperature (K)">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cat_type">Select Catalyst Factor or Expression
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Catalyst Factor or Expression"></i></span>
                            </label>
                            <select class="form-control form-control-sm" id="cat_type" name="cat_type">
                                <option value="" selected disabled>Select Catalyst Factor or Expression</option>
                                <option @if($prop_data['cat_type']=='catalyst' ) selected @endif value="catalyst">Catalyst Factor</option>
                                <option @if($prop_data['cat_type']=='expression' ) selected @endif value="expression">Expression</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cat_or_exp">Catalyst Factor or Expression</label>
                            <input type="text" id="cat_or_exp" value="{{$prop_data['catalyst_factor']}}" name="cat_or_exp" value="" class="form-control form-control-sm" placeholder="Catalyst Factor or Expression">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="rate-user-edit"]' class="btn btn-sm btn-secondary">Save</button>
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>