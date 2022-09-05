<div class="modal fade" id="equi_userinput{{$property->id}}" tabindex="-1" role="dialog" aria-labelledby="equi_userinputLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{url('/other_inputs/reaction/'.$reaction_id.'/addprop/'.___encrypt($property->id))}}" method="POST" role="equi-user-edit">
                <div class="modal-header">
                    <h5 class="modal-title" id="equi_userinputLabel">Edit User Input</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="id" value="{{___encrypt($reaction_id)}}" />
                    <input type="hidden" name="prop_type_name" value="equi_user">
                    <input type="hidden" name="type" value="equi_user_input">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Name
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Name"></i></span>
                            </label>
                            <input type="text" value="{{$prop_data['name']}}" id="name" name="name" class="form-control form-control-sm" placeholder="Enter Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="keq_value">​Keq Value
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter ​Keq Value"></i></span>
                            </label>
                            <input type="text" value="{{$prop_data['keq_value']}}" id="keq_value" name="keq_value" class="form-control form-control-sm" placeholder="Enter ​Keq Value">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="temperature_k">Temperature (K)
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Temperature (K)"></i></span>
                            </label>
                            <input type="text" value="{{$prop_data['temperature_k']}}" id="temperature_k" name="temperature_k" class="form-control form-control-sm" placeholder="Enter Temperature (K)">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="equi-user-edit"]' class="btn btn-sm btn-secondary">Save</button>
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