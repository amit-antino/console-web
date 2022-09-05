<div class="modal fade bd-product-modal-lg" id="unitModal" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" action="{{url('admin/master/unit_type')}}" role="UnitType">
            @CSRF
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Create Unit Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Unit Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Name"></i></span>
                            </label>
                            <input type="text" class="form-control" name="unit_name" placeholder="Enter Name">
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Unit Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Add Unit Description"></i></span>
                            </label>
                            <textarea id="unit_description" name="unit_description" class="form-control" maxlength="10000" rows="5" placeholder="Description"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Default Unit Constant Name
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Default Unit Constant Name"></i></span>
                            </label>
                            <input type="text" class="form-control" name="default_unit" placeholder="Default Unit Constant Name">
                        </div>
                        <div class="form-group col-md-12">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="control-label">Unit Constant Name
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Unit Constant Name"></i></span>
                                    </label>
                                    <input type="text" class="form-control" name="unit_constant[0][unit_name]" placeholder="Enter Unit Constant Name">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Unit Constant Symbol
                                    <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Unit Constant Symbol"></i></span>
                                    </label>
                                    <input type="text" class="form-control" name="unit_constant[0][unit_symbol]" placeholder="Enter Unit Constant Symbol">
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="control-label">
                                        <span class="text-danger">&nbsp;&nbsp;</span>
                                    </label>
                                    </br>
                                    <button data-types="constant" data-target="#constant" data-url="{{url('admin/master/unit_type/add-more-constant-field')}}" data-request="add-another" data-count="0" type="button" class="btn btn-sm btn-secondary btn-icon" data-toggle="tooltip" data-placement="bottom" title="Add">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="constant" id="constant"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="UnitType"]' class="btn btn-sm btn-secondary submit">
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