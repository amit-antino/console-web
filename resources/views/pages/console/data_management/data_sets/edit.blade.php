<div class="modal fade bd-product-modal-md" id="editProjectModal{{___encrypt($data_set->id)}}" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form method="POST" action="{{url('data_management/data_sets/'.___encrypt($data_set->id))}}" role="project">
            @CSRF
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">View DataSet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-sm-12">
                            <label for="project_id">Select Project</label>
                            <!-- <select data-width="100%" class="js-example-basic-single" id="project_id" name="project_id">
                                @if(!empty($projects))
                                @foreach($projects as $project)
                                <option value="{{___encrypt($project->id)}}">{{$project->name}}</option>
                                @endforeach
                                @endif
                            </select> -->
                            <input type="text" class="form-control" disabled value="{{$project_name}}">
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Dataset Name <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Dataset Name"></i></span>
                            </label>
                            <input type="text" class="form-control" disabled value="{{$data_set->name}}" name="name" placeholder="Enter  Dataset Name" required>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" rows="5" disabled class="form-control">{{$data_set->description}}</textarea>
                        </div>
                        <!-- <div class="form-group col-md-6">
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
                        </div> -->
                        <div class="form-group col-md-12">
                            <label for="tags">Tags</label>

                            <input type="text" class="form-control" value="{{$data_set->tags}}" name="tags" disabled>
                        </div>
                        <!-- <div class="form-group col-md-6">
                            <label class="control-label"> Select Country
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Country"></i></span>
                            </label>
                            <select name="country" id="country" class="form-control">
                                <option value="">Select Country</option>
                                @if(!empty($countries))
                                @foreach($countries as $country)
                                <option value="{{___encrypt($country->id)}}">{{$country->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label"> Enter State Name
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter State Name"></i></span>
                            </label>
                            <input type="text" class="form-control" name="state" placeholder="Enter State Name" required>
                        </div> -->
                        <!-- <div class="form-group col-md-6">
                            <label class="control-label"> Enter City Name
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title=" Enter City Name"></i></span>
                            </label>
                            <input type="text" class="form-control" name="city" placeholder=" Enter City Name" required>
                        </div> -->
                        <!-- <div class="form-group col-md-12">
                            <label class="control-label"> Uploads Files
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Uploads Files"></i></span>
                            </label>
                            <input type="file" class="form-control" name="experiment_files" placeholder="Uploads Files">
                        </div> -->
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" data-request="ajax-submit" data-target='[role="project"]' class="btn btn-sm btn-secondary submit">
                        Submit
                    </button> -->
                    <button class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>