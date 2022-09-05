<div class="modal fade bd-product-modal-md" id="editConditionModal{{___encrypt($condition->id)}}" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form method="POST" action="{{url('admin/tenant/'.$tenant_id.'/experiment/condition/'.___encrypt($condition->id))}}" role="condition-edit">
            <input type="hidden" name="_method" value="PUT">
            @CSRF
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Edit Experiment Condition</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Experiment Condition Name <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Experiment Condition Name"></i></span>
                            </label>
                            <input type="text" value="{{$condition->name}}" class="form-control" name="name" placeholder="Enter Experiment Condition Name" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Select Unit type <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Unit Type"></i></span>
                            </label>
                            </br>
                            <select class="form-control" name="unit_type">
                                <option value="">Select Unit Type</option>
                                @if(!empty($data['MasterUnit']))
                                @foreach($data['MasterUnit'] as $k=>$v)
                                <option @if($v['id']==$condition->unittype) selected="" @endif value="{{___encrypt($v['id'])}}">{{$v['unit_name']}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Equipment Description"></i></span>
                            </label>
                            <textarea name="description" id="description" rows="5" class="form-control">{{$condition->description}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="condition-edit"]' class="btn btn-sm btn-secondary submit">
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
<script>
    if ($(".js-example-basic-single").length) {
        $(".js-example-basic-single").select2();
    }
</script>