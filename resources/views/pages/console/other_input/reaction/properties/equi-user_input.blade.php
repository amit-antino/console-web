<div class="tab-pane fade show active" id="equi_user_input" role="tabpanel" aria-labelledby="equi_user_input_tab">
    <div class="card">
        <div class="card-header text-right">
            <button type="button" class="btn btn-sm btn-secondary btn-icon-text" data-toggle="modal" data-target="#equi_userinput">
                <i class="btn-icon-prepend" data-feather="plus"></i> Add User Input
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th>Name</th>
                                <th>Equilibrium Constant (K<span style="text-transform: lowercase">eq)</span></th>
                                <th>Temperature (K)</th>
                                <th class="text-center">Actions</th>
                            </thead>
                            <tbody>
                                @if(!empty(_arefy($reaction_properties)))
                                @foreach($reaction_properties as $equi_user)
                                @if($equi_user->sub_type=='user_input' && $equi_user->type=='equilibrium')
                                @php
                                $equi_user_data = $equi_user->properties;
                                @endphp
                                <tr class="equi_clone_tr">
                                    <td>{{$equi_user_data['name']}}</td>
                                    <td>{{$equi_user_data['keq_value']}}</td>
                                    <td>{{$equi_user_data['temperature_k']}}</td>
                                    <td>
                                        <a href="javascript:void(0);" data-url="{{url('/other_inputs/reaction/'.___encrypt($reaction_id).'/addprop/'.___encrypt($equi_user->id).'/edit?edit_type=edit-equi-user')}}" data-request="ajax-popup" data-target="#edit-div-equi-user" data-tab="#equi_userinput{{$equi_user->id}}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Tenant">
                                            <i class="fas fa-edit text-secondary"></i>
                                        </a>
                                        <a href="javascript:void(0);" data-url="{{url('other_inputs/reaction/'.___encrypt($equi_user->reaction_id).'/addprop/'.___encrypt($equi_user->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete Tenant">
                                            <i class="fas fa-trash text-secondary"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endif
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="equi_userinput" tabindex="-1" role="dialog" aria-labelledby="equi_userinputLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{url('/other_inputs/reaction/'.___encrypt($reaction_id).'/addprop')}}" method="POST" role="equi-user">
                <div class="modal-header">
                    <h5 class="modal-title" id="equi_userinputLabel">User Input Property</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" value="{{___encrypt($reaction_id)}}" />
                    <input type="hidden" name="prop_type_name" value="equi_user">
                    <input type="hidden" name="type" value="equi_user_input">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Name
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Name"></i></span>
                            </label>
                            <input type="text" id="name" name="name" class="form-control form-control-sm" placeholder="Enter Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="keq_value">​Keq Value
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter ​Keq Value"></i></span>
                            </label>
                            <input type="text" id="keq_value" name="keq_value" class="form-control form-control-sm" placeholder="Enter ​Keq Value">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="temperature_k">Temperature (K)
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Temperature (K)"></i></span>
                            </label>
                            <input type="text" id="temperature_k" name="temperature_k" class="form-control form-control-sm" placeholder="Enter Temperature (K)">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="equi-user"]' class="btn btn-sm btn-secondary">Save</button>
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
<div id="edit-div-equi-user">
</div>