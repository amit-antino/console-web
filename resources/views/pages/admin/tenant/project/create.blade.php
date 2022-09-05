<div class="modal fade bd-product-modal-lg" id="ProjectModal" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" action="{{url('admin/tenant/'.$tenant_id.'/project')}}" role="project">
            @CSRF
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Create Project</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label"> Name <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Name"></i></span>
                            </label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Name" required>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="users">Select Users
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select users"></i></span>
                            </label>
                            <select data-width="100%" class="js-example-basic-multiple" name="users[]" id="users" multiple="multiple" required>
                                @if(!empty($users))
                                @foreach($users as $user)
                                <option value="{{___encrypt($user['id'])}}">{{$user['first_name']}} {{$user['last_name']}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="5" class="form-control"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tags">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter tags"></i></span>
                            </label>
                            <input type="text" id="tags" class="tags-style" class="form-control" data-request="isalphanumeric" name="tags" placeholder="Enter tags">
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label"> Select Location
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Location"></i></span>
                            </label>
                            <select class="js-example-basic-single formcontrol"  name="location" id="location" data-request="ajax-append-fields" data-target="#location_details" data-url="{{url('admin/tenant/'.$tenant_id.'/tenant_location_fetch')}}"  >
                                {{-- <option value="">Select Location</option> --}}
                                @if(!empty($locations))
                                @foreach($locations as $location)
                                @if($location['status']=='active')
                                <option value="{{___encrypt($location['id'])}}">{{$location['location_name']}}</option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="row" id="location_details"></div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="project"]' class="btn btn-sm btn-secondary submit">
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
