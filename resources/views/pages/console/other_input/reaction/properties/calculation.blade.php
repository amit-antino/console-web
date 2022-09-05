<div class="tab-pane fade" id="calculation" role="tabpanel" aria-labelledby="calculation_tab">
    <div class="card">
        <div class="card-header text-right">
            <button type="button" class="btn btn-sm btn-secondary btn-icon-text" data-toggle="modal" data-target="#rate_calculation">
                <i class="btn-icon-prepend" data-feather="plus"></i> Add Calculation
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
                                <th>A</th>
                                <th>E(J/mol)</th>
                                <th>Temperature (K)</th>
                                <th>Rate Constant <span style="text-transform: lowercase">(k)</span></th>
                                <th>Catalyst Factor or Expression</th>
                                <th class="text-center">Actions</th>
                            </thead>
                            <tbody>
                                @if(!empty($reaction_properties))
                                @foreach($reaction_properties as $rate_cal)
                                @if($rate_cal->sub_type=='calculation' && $rate_cal->type=='rate_parameter')
                                @php
                                $rate_cal_data = $rate_cal->properties;
                                @endphp
                                <tr>
                                    <td>{{$rate_cal_data['reaction_type']}}</td>
                                    <td>{{$rate_cal_data['name']}}</td>
                                    <td>{{$rate_cal_data['a']}}</td>
                                    <td>{{$rate_cal_data['e']}}</td>
                                    <td>{{$rate_cal_data['temperature_k']}}</td>
                                    <td>{{$rate_cal_data['rate_constant']}}</td>
                                    <td>
                                        <p>Type: <b>{{$rate_cal_data['cat_type']}}</b></p>
                                        <p>Value: <b>{{$rate_cal_data['catalyst_factor']}}</b></p>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" data-url="{{url('/other_inputs/reaction/'.___encrypt($reaction_id).'/addprop/'.___encrypt($rate_cal->id).'/edit?edit_type=edit-rate-cal')}}" data-request="ajax-popup" data-target="#edit-div-rate-cal" data-tab="#rate_calculation_edit{{$rate_cal->id}}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Tenant">
                                            <i class="fas fa-edit text-secondary"></i>
                                        </a>
                                        <a href="javascript:void(0);" data-url="{{url('other_inputs/reaction/'.___encrypt($rate_cal->reaction_id).'/addprop/'.___encrypt($rate_cal->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete Tenant">
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
<div class="modal fade" id="rate_calculation" tabindex="-1" role="dialog" aria-labelledby="rate_calculationLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form action="{{url('/other_inputs/reaction/'.___encrypt($reaction_id).'/addprop')}}" method="POST" role="rate-cal">
                <div class="modal-header">
                    <h5 class="modal-title" id="rate_calculationLabel">Add Rate Calculation Property</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" name="id" value="{{___encrypt($reaction_id)}}" />
                    <input type="hidden" name="prop_type_name" value="rate_cal">
                    <input type="hidden" name="type" value="rate_calculation">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="reaction_type">Select Reaction Type
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Reaction Type"></i></span>
                            </label>
                            <select class="form-control form-control-sm" id="reaction_type" name="reaction_type">
                                <option value="">Select Reaction Type</option>
                                <option value="Forward">Forward</option>
                                <option value="Backward">Backward</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">Name
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Name"></i></span>
                            </label>
                            <input type="text" id="name" name="name" class="form-control form-control-sm" placeholder="Enter Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="a">A
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter A"></i></span>
                            </label>
                            <input type="text" id="a_cal" name="a" class="form-control form-control-sm calculate_reaction_rate" placeholder="Enter A">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="e">E (J/mol)
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter E (J/mol)"></i></span>
                            </label>
                            <input type="text" id="e_cal" name="e" class="form-control form-control-sm calculate_reaction_rate" placeholder="Enter E (J/mol)">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="temperature_k">Temperature (K)
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Temperature (K)"></i></span>
                            </label>
                            <input type="text" onkeyup="calculation_live_eq()" id="temperature_k_cal" name="temperature_k" class="form-control form-control-sm calculate_reaction_rate" placeholder="Enter Temperature (K)">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="rate_constant">Rate constant (k)
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Rate constant (k)"></i></span>
                            </label>
                            <input type="text" id="rate_constant_cal" name="rate_constant" readonly class="form-control form-control-sm" placeholder="Enter Rate constant (k)">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cat_type">Select Catalyst Factor or Expression
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Name"></i></span>
                            </label>
                            <select class="form-control form-control-sm" id="cat_type" name="cat_type">
                                <option value="" selected disabled>Select Option</option>
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
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="rate-cal"]' class="btn btn-sm btn-secondary">Save</button>
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
<div id="edit-div-rate-cal">
</div>