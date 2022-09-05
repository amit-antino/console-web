<div class="modal fade bd-product-modal-md" id="editCodeSubTypeModal{{___encrypt($cat->id)}}" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form method="POST" action="{{url('admin/master/chemical/hazard/code_sub_type/'.___encrypt($cat->id))}}" role="code-sub-type{{___encrypt($cat->id)}}">
            <input type="hidden" name="_method" value="PUT">
            @CSRF
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Edit Code Sub Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Code Type<span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Code Type"></i></span>
                            </label>
                            <select class="form-control" name="code_type_id">
                                <option value="">Code Type</option>
                                @if(!empty($code_types))
                                @foreach($code_types as $code_type)
                                <option @if(___encrypt($code_type->id)==___encrypt($cat->code_type_id)) selected="" @endif value="{{___encrypt($code_type->id)}}">{{$code_type->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Sub Code Name <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Sub Code Name"></i></span>
                            </label>
                            <input type="text" class="form-control" name="name" value="{{$cat->name}}" placeholder="Enter Sub Code Name">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="5" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="code-sub-type{{___encrypt($cat->id)}}"]' class="btn btn-sm btn-secondary submit">
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
