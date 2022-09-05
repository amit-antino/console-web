<div class="modal fade bd-product-modal-md" id="editFlowTypeModal{{___encrypt($type->id)}}" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form method="POST" action="{{url('admin/master/process_simulation/flow_type/'.___encrypt($type->id))}}" role="flow-type-edit">
            <input type="hidden" name="_method" value="PUT">
            @CSRF
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Edit Flow Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Select Flow Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Flow Type"></i></span>
                            </label>
                            <select class="form-control" name="type">
                                <option value="">Select Flow Type</option>
                                @foreach($typeList as $key=>$value)
                                <option value="{{$key}}" {{$type->type==$key?'selected':''}}>{{$value}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Flow Type Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Flow Type Name"></i></span>
                            </label>
                            <input type="text" value="{{$type->flow_type_name}}" class="form-control" name="flow_type_name" placeholder="Enter Flow Type Name">
                        </div>
                      
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="flow-type-edit"]' class="btn btn-sm btn-secondary submit">
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