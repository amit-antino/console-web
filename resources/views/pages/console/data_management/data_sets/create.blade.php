<div class="modal fade bd-product-modal-md" id="ProjectModal" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form method="POST" action="{{url('data_management/data_sets')}}" role="project">
            @CSRF
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Upload New DataSet</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-sm-12">
                            <label for="project_id">Select Project<span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Project"></i></span>
                            </label>
                            <select data-width="100%" class="js-example-basic-single" id="project_id" name="project_id">
                                <option value="">Select Project</option>
                                @if(!empty($projects))
                                @foreach($projects as $project)
                                <option value="{{___encrypt($project->id)}}">{{$project->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Dataset Name <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Dataset Name"></i></span>
                            </label>
                            <input type="text" class="form-control" name="name" placeholder="Enter  Dataset Name" required>
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

                        <div class="form-group col-md-12">
                            <label class="control-label"> Upload Files
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Uploads Files"></i></span>
                            </label>
                            <input type="file" class="form-control" name="experiment_files" placeholder="Uploads Files">
                        </div>
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