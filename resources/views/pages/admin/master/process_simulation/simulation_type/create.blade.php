<div class="modal fade bd-product-modal-lg" id="SimulationModal" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" action="{{url('admin/master/process_simulation/simulation_type')}}" role="SimulationType">
            @CSRF
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Create Simulation Type</h5>
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
                            <input type="text" class="form-control" name="simulation_name" placeholder="Enter Simulation Name">
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Simulation Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Add Simulation Description"></i></span>
                            </label>
                            <textarea id="description" name="description" class="form-control" maxlength="10000" rows="5" placeholder="Description"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-11">
                                    <label class="control-label">Simulation Mass Balance
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Mass Balance Data Source"></i></span>
                                    </label>
                                    <input type="text" class="form-control" name="mass_balance[0][data_source]" placeholder="Enter Mass Balance Data Source">
                                </div>
                                <div class="form-group col-md-1">
                                    <label class="control-label">
                                        <span class="text-danger">&nbsp;&nbsp;</span>
                                    </label>
                                    </br>
                                    <button data-types="mass_balance" data-target="#mass_balance" data-url="{{url('admin/master/process_simulation/add-more-simulation-field/mass_balance')}}" data-request="add-another" data-count="0" type="button" class="btn btn-sm btn-secondary btn-icon" data-toggle="tooltip" data-placement="bottom" title="Add">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="mass_balance" id="mass_balance">
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-11">
                                    <label class="control-label">Simulation Energy Utilities
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Energy Utilities Data Source"></i></span>
                                    </label>
                                    <input type="text" class="form-control" name="enery_utilities[0][data_source]" placeholder="Enter Energy Utilities Data Source">
                                </div>
                                <div class="form-group col-md-1">
                                    <label class="control-label">
                                        <span class="text-danger">&nbsp;&nbsp;</span>
                                    </label>
                                    </br>
                                    <button data-types="enery_utilities" data-target="#enery_utilities" data-url="{{url('admin/master/process_simulation/add-more-simulation-field/enery_utilities')}}" data-request="add-another" data-count="0" type="button" class="btn btn-sm btn-secondary btn-icon" data-toggle="tooltip" data-placement="bottom" title="Add">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="enery_utilities" id="enery_utilities">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="SimulationType"]' class="btn btn-sm btn-secondary submit">
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