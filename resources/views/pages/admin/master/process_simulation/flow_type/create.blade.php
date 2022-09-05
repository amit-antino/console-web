<div class="modal fade bd-product-modal-md" id="FlowTypeModal" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form method="POST" action="{{url('admin/master/process_simulation/flow_type')}}" role="flow-type">
            @CSRF
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Create Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                    <div class="form-group col-md-12">
                            <label class="control-label">Flow Type <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Type"></i></span>
                            </label>
                            <select class="form-control" name="type">
                                <option value="">Select Type</option>
                                @foreach($typeList as $key=>$value)
                                <option value="{{$key}}">{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Flow Type Name <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Flow Type Name"></i></span>
                            </label>
                            <input type="text" class="form-control" name="flow_type_name" placeholder="Enter Flow Type Name">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="flow-type"]' class="btn btn-sm btn-secondary submit">
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