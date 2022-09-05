<div class="modal fade bd-product-modal-md" id="RuleModel" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form method="POST" action="{{url('data_management/data_rules')}}" role="curation_rule">
            @CSRF
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Add New Curation Rule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-sm-12">
                            <label for="rule_name">Enter Rule Name<span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Rule Name"></i></span>
                            </label>
                            <input type="text" class="form-control" name="rule_name" placeholder="Enter Rule Name">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="tags">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter tags"></i></span>
                            </label>
                            <input type="text" id="tags" class="tags-style" class="form-control" data-request="isalphanumeric" name="tags" placeholder="Enter tags">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-request="ajax-submit" data-target='[role="curation_rule"]' class="btn btn-sm btn-secondary submit">
                        Submit
                    </button>
                    <button class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>