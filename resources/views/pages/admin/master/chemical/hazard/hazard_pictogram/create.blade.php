<div class="modal fade bd-product-modal-md" id="HazardPictogramModal" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form method="POST" action="{{url('admin/master/chemical/hazard/hazard_pictogram')}}" role="hazard-pictogram">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Create Hazard pictogram</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Hazard Pictogram <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Hazard Pictogram Name"></i></span>
                            </label>
                            <input type="file" class="form-control" name="hazard_pictogram">
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Hazard Pictogram Title<span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Hazard Pictogram Title"></i></span>
                            </label>
                            <input type="text" class="form-control" name="title" placeholder="Enter Hazard Pictogram Title">
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Hazard Pictogram Code <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Hazard Pictogram Code"></i></span>
                            </label>
                            <input type="text" class="form-control" name="code" placeholder="Enter Hazard Pictogram Code">
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Hazard Pictogram Description<span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Hazard Pictogram Description"></i></span>
                            </label>
                            <textarea class="form-control" name="description" rows="5" placeholder="Enter Hazard Pictogram Description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="hazard-pictogram"]' class="btn btn-sm btn-secondary submit">
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