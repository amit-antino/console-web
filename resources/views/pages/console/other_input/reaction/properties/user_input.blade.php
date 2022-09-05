<div class="tab-pane fade show active" id="user_input" role="tabpanel" aria-labelledby="user_input_tab">
    <div class="card">
        <div class="card-header text-right">
            <button type="button" class="btn btn-sm btn-secondary btn-icon-text" data-toggle="modal" data-target="#reaction_user_input">
                <i class="btn-icon-prepend" data-feather="plus"></i> Add User Input
            </button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <th>Reaction Type</th>
                                <th>Name</th>
                                <th>Rate constant <span style="text-transform: lowercase">(k)</span></th>
                                <th>Temperature (K)</th>
                                <th>Catalyst Factor or Expression</th>
                                <th class="text-center">Actions</th>
                            </thead>
                            <tbody>
                                @if(!empty($reaction_properties))
                                @foreach($reaction_properties as $rate_user_data)
                                @if($rate_user_data->sub_type=='user_input' && $rate_user_data->type=='rate_parameter')
                                @php
                                $rate_user = $rate_user_data['properties'];
                                @endphp
                                <tr>
                                    <td>{{$rate_user['reaction_type']}}</td>
                                    <td>{{$rate_user['name']}}</td>
                                    <td>{{$rate_user['rate_constant']}}</td>
                                    <td>{{$rate_user['temperature_k']}}</td>
                                    <td>
                                        <p>Type: <b>{{$rate_user['cat_type']}}</b></p>
                                        <p>Value: <b>{{$rate_user['catalyst_factor']}}</b></p>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" data-url="{{url('/other_inputs/reaction/'.___encrypt($reaction_id).'/addprop/'.___encrypt($rate_user_data->id).'/edit?edit_type=edit-rate-user')}}" data-request="ajax-popup" data-target="#edit-div-rate-user" data-tab="#rate_user_edit{{$rate_user_data->id}}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Tenant">
                                            <i class="fas fa-edit text-secondary"></i>
                                        </a>
                                        <a href="javascript:void(0);" data-url="{{url('other_inputs/reaction/'.___encrypt($rate_user_data->reaction_id).'/addprop/'.___encrypt($rate_user_data->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btnicon" data-toggle="tooltip" data-placement="bottom" title="Delete Tenant">
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

<div class="modal fade" id="reaction_user_input" tabindex="-1" role="dialog" aria-labelledby="reaction_user_inputLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{url('/other_inputs/reaction/'.___encrypt($reaction_id).'/addprop')}}" method="POST" role="rate-user">
                <div class="modal-header">
                    <h5 class="modal-title" id="reaction_user_inputLabel">Add User Input Property</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
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
                                <option value="Forward">Forward</option>
                                <option value="Reverse">Reverse</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Name
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Name"></i></span>
                            </label>
                            <input type="text" id="name" name="name" class="form-control form-control-sm" placeholder="Enter Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="rate_constant">Rate constant (k)
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Rate constant (k)"></i></span>
                            </label>
                            <input type="text" id="rate_constant" name="rate_constant" class="form-control form-control-sm" placeholder="Enter Rate constant (k)">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="temperature_k">Temperature (K)
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Temperature (K)"></i></span>
                            </label>
                            <input type="text" id="temperature_k" name="temperature_k" class="form-control form-control-sm" placeholder="Enter Temperature (K)">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cat_type">Select Catalyst Factor or Expression
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Catalyst Factor or Expression"></i></span>
                            </label>
                            <select class="form-control form-control-sm" id="cat_type" name="cat_type">
                                <option value="" selected disabled>Select Catalyst Factor or Expression</option>
                                <option value="catalyst">Catalyst Factor</option>
                                <option value="expression">Expression</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cat_or_exp">Catalyst Factor or Expression</label>
                            <input type="text" id="cat_or_exp" name="cat_or_exp" value="" class="form-control form-control-sm" placeholder="Catalyst Factor or Expression">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="rate-user"]' class="btn btn-sm btn-secondary">Save</button>
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
<div id="edit-div-rate-user">
</div>