<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('/admin/tenant/')}}" method="POST" role="tenant">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Add Tenant</h4>
                </div>
                <div class="card-body">
                    <input type="hidden" name="role" value="tenant">
                    <input type="hidden" name="tenant_id" value="{{request()->query('tenant_id')}}">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="organization_name"> Organization Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Organization Name"></i></span>
                            </label>
                            <input type="text" name="organization_name" class="form-control form-control-sm" value="{{!empty($tenant->organization_name)?$tenant->organization_name:''}}" placeholder="Enter Organization Name" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="account_name"> Account Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Account Name"></i></span>
                            </label>
                            <input type="text" name="account_name" class="form-control form-control-sm" value="{{!empty($tenant->account_name)?$tenant->account_name:''}}" placeholder="Enter Account Name" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="organization_type"> Organization Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Organization Type"></i></span>
                            </label>
                            <select id="organization_type" name="organization_type" class="form-control form-control-sm" required>
                                <option value=""> Organization Type</option>
                                @if(!empty($tenant_master->organization_type))
                                @foreach($tenant_master->organization_type as $key => $type)
                                @if(!empty($tenant->organization_type))
                                <option @if($tenant->organization_type==$type) selected @endif value="{{$type}}">{{$type}}</option>
                                @else
                                <option value="{{$type}}">{{$type}}</option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tags">Select Plan
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Plan"></i></span>
                            </label>
                            <select name="plan_list" id="plan_list" class="form-control form-control-sm" required>
                                <option value="">Select Plan</option>
                                @if(!empty($tenant_master->plan))
                                @foreach($tenant_master->plan as $key => $plan)
                                @if(!empty($tenant->plan_id))
                                <option @if($tenant->plan_id==$key+1) selected @endif value="{{$key+1}}">{{$plan}}</option>
                                @else
                                <option value="{{$key+1}}">{{$plan}}</option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="organization_logo">Upload Organization Logo</label>
                            <div class="input-group input-group-sm mb-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="organization_logo" name="organization_logo" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="organization_logo">Choose file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description / Note
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Description / Note"></i></span>
                            </label>
                            <textarea name="description" id="description" rows="5" class="form-control">{{!empty($tenant->description)?$tenant->description:''}}</textarea>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="tenant"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="/admin/tenant" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>