<div class="modal fade bd-product-modal-lg" id="SimulationModal{{___encrypt($simulation->id)}}" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" action="{{url('admin/master/process_simulation/simulation_type/'.___encrypt($simulation->id))}}" role="SimulationType-edit">
            <input type="hidden" name="_method" value="PUT">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Edit Simulation Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Simulation Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Simulation Name"></i></span>
                            </label>
                            <input type="text" class="form-control" name="simulation_name" value="{{$simulation->simulation_name}}" placeholder="Enter Simulation Name">
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Simulation Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Add Simulation Description"></i></span>
                            </label>
                            <textarea id="description" name="description" class="form-control" maxlength="10000" rows="5" placeholder="Description">{{$simulation->description}}</textarea>
                        </div>
                        <div class="form-group col-md-12">
                            @php
                            if(!empty($simulation->mass_balance)){
                            $total_count =
                            count($simulation->mass_balance);
                            }else{
                            $total_count=0;
                            }
                            @endphp
                            @if($simulation->mass_balance)
                            @foreach($simulation->mass_balance as $count => $mass_balance)
                            <div id="remove-section-mass_balance-{{$count}}">
                                <div class="form-row">
                                    <div class="form-group col-md-11">
                                        <input type="text" class="form-control" name="mass_balance[{{$count}}][data_source]" placeholder="Enter Mass Balance Data Source" value="{{$mass_balance['data_source']}}">
                                    </div>
                                    <div class="form-group col-md-1">
                                        <button type="button" class="btn btn-sm btn-secondary btn-icon" data-target="#remove-section-mass_balance-{{$count}}" data-count="{{$count}}" data-type="mass_balance" data-request="remove">
                                            <i class="fas fa-minus-circle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <div class="form-row">
                                <div class="form-group col-md-11">
                                    <label class="control-label">Simulation Mass Balance
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Mass Balance Data Source"></i></span>
                                    </label>
                                    <input type="text" class="form-control" name="mass_balance[{{$total_count}}][data_source]" placeholder="Enter Mass Balance Data Source">
                                </div>
                                <div class="form-group col-md-1">
                                    <label class="control-label">
                                        <span class="text-danger">&nbsp;&nbsp;</span>
                                    </label>
                                    </br>
                                    <button data-types="mass_balance" data-target="#mass_balance-edit" data-url="{{url('admin/master/process_simulation/add-more-simulation-field/mass_balance')}}" data-request="add-another" data-count="{{$total_count}}" type="button" class="btn btn-sm btn-secondary btn-icon" data-toggle="tooltip" data-placement="bottom" title="Add">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mass_balance" id="mass_balance-edit">
                            </div>
                            @php
                            if(!empty($simulation->enery_utilities)){
                            $total_count_energy =
                            count($simulation->enery_utilities);
                            }else{
                            $total_count_energy=0;
                            }
                            @endphp
                            @if($simulation->enery_utilities)
                            @foreach($simulation->enery_utilities as $count_energy => $enery_utilities)
                            <div id="remove-section-{{$count_energy}}">
                                <div class="form-row">
                                    <div class="form-group col-md-11">
                                        <input type="text" class="form-control" name="enery_utilities[{{$count_energy}}][data_source]" placeholder="Enter Energy Utilities Data Source" value="{{$enery_utilities['data_source']}}">
                                    </div>
                                    <div class="form-group col-md-1">
                                        <button type="button" class="btn btn-sm btn-secondary btn-icon" data-target="#remove-section-{{$count_energy}}" data-count="{{$count_energy}}" data-type="enery_utilities" data-request="remove">
                                            <i class="fas fa-minus-circle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            <div class="form-row">
                                <div class="form-group col-md-11">
                                    <label class="control-label">Simulation Energy Utilities
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Energy Utilities Data Source"></i></span>
                                    </label>
                                    <input type="text" class="form-control" name="enery_utilities[{{$total_count_energy}}][data_source]" placeholder="Enter Energy Utilities Data Source">
                                </div>
                                <div class="form-group col-md-1">
                                    <label class="control-label">
                                        <span class="text-danger">&nbsp;&nbsp;</span>
                                    </label>
                                    </br>
                                    <button data-types="enery_utilities" data-target="#enery_utilities-edit" data-url="{{url('admin/master/process_simulation/add-more-simulation-field/enery_utilities')}}" data-request="add-another" data-count="{{$total_count_energy}}" type="button" class="btn btn-sm btn-secondary btn-icon" data-toggle="tooltip" data-placement="bottom" title="Add">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="enery_utilities" id="enery_utilities-edit">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="SimulationType-edit"]' class="btn btn-sm btn-secondary submit">
                        Submit
                    </button>
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                    <button class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>