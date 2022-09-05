<div class="modal fade bd-product-modal-md" id="editoutcomeModal{{___encrypt($outcome->id)}}" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form method="POST" action="{{url('admin/tenant/'.$tenant_id.'/experiment/outcome/'.___encrypt($outcome->id))}}" role="outcome-edit">
            <input type="hidden" name="_method" value="PUT">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Edit Experiment Outcome</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Experiment Outcome Name <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Experiment Outcome Name"></i></span>
                            </label>
                            <input type="text" value="{{$outcome->name}}" class="form-control" name="name" placeholder="Enter Experiment Outcome Name" required>
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
                                <option @if($outcome->unittype==$v['id']) selected="" @endif value="{{___encrypt($v['id'])}}">{{$v['unit_name']}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Equipment Description"></i></span>
                            </label>
                            <textarea name="description" id="description" rows="5" class="form-control">{{$outcome->description}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="outcome-edit"]' class="btn btn-sm btn-secondary submit">
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