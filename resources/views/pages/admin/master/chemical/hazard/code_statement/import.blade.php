<div class="modal fade bd-product-modal-md" id="CodeStatementImportModal" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form method="POST" action="{{url('admin/master/chemical/hazard/code_statement_import')}}" role="code_statement_import">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Import Code Statement</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Code Statement File <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Code Statement File"></i></span>
                            </label>
                            <input type="file" class="form-control" name="code_statement_file">
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Type <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Type"></i></span>
                            </label>
                            <select data-url="{{url('admin/master/chemical/hazard/sub_code_type_list')}}" data-type="form" data-request="ajax-append-fields" data-target="#sub_code_type_import" class="form-control" name="type">
                                <option value="">Select Type</option>
                                @if(!empty($code_types))
                                @foreach($code_types as $code_type)
                                <option value="{{___encrypt($code_type->id)}}">{{$code_type->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Sub Code Type <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Type"></i></span>
                            </label>
                            <select class="form-control" id="sub_code_type_import" name="sub_code_type">
                                <option value="">Select Sub Code Type</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="code_statement_import"]' class="btn btn-sm btn-secondary submit">
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