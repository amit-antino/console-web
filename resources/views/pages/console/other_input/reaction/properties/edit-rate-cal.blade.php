<div class="modal fade" id="rate_calculation_edit{{$property->id}}" tabindex="-1" role="dialog" aria-labelledby="rate_calculationLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{url('/other_inputs/reaction/'.___encrypt($property->reaction_id).'/addprop/'.___encrypt($property->id))}}" method="POST" role="rate-cal-edit">
                <div class="modal-header">
                    <h5 class="modal-title" id="rate_calculationLabel">Edit Rate Calculation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="{{___encrypt($reaction_id)}}" />
                    <input type="hidden" name="prop_type_name" value="rate_cal">
                    <input type="hidden" name="type" value="rate_calculation">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="reaction_type">Select Reaction Type
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Reaction Type"></i></span>
                            </label>
                            <select class="form-control" id="reaction_type" name="reaction_type">
                                <option value="">Select Reaction Type</option>
                                <option @if($prop_data['reaction_type']=='Forward' ) selected @endif value="Forward">Forward</option>
                                <option @if($prop_data['reaction_type']=='Backward' ) selected @endif value="Backward">Backward</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Name
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Name"></i></span>
                            </label>
                            <input type="text" id="name" name="name" class="form-control" value="{{$prop_data['name']}}" placeholder="Enter Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="a">A
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter A"></i></span>
                            </label>
                            <input type="text" id="a_cal_edit" name="a" value="{{$prop_data['a']}}" class="form-control calculate_reaction_rate" placeholder="Enter A">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="e">E (J/mol)
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter E (J/mol)"></i></span>
                            </label>
                            <input type="text" id="e_cal_edit" value="{{$prop_data['e']}}" name="e" class="form-control calculate_reaction_rate" placeholder="Enter E (J/mol)">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="temperature_k">Temperature (K)
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Temperature (K)"></i></span>
                            </label>
                            <input type="text" onkeyup="calculation_live_eq_edit()" id="temperature_k_cal_edit" name="temperature_k" class="form-control calculate_reaction_rate" value="{{$prop_data['temperature_k']}}" placeholder="Enter Temperature (K)">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="rate_constant">Rate constant (k)
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Rate constant (k)"></i></span>
                            </label>
                            <input type="text" value="{{$prop_data['rate_constant']}}" id="rate_constant_cal_edit" name="rate_constant" readonly class="form-control" placeholder="Enter Rate constant (k)">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cat_type">Select Catalyst Factor or Expression
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Name"></i></span>
                            </label>
                            <select class="form-control" id="cat_type" name="cat_type">
                                <option value="" selected>Select Option</option>
                                <option @if($prop_data['cat_type']=='catalyst' ) selected="" @endif value="catalyst">Catalyst Factor</option>
                                <option @if($prop_data['cat_type']=='expression' ) selected="" @endif value="expression">Expression</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cat_or_exp">Catalyst Factor or Expression</label>
                            <input type="text" id="cat_or_exp" value="{{$prop_data['catalyst_factor']}}" name="cat_or_exp" value="" class="form-control" placeholder="Catalyst Factor or Expression">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="rate-cal-edit"]' class="btn btn-sm btn-secondary">Save</button>
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