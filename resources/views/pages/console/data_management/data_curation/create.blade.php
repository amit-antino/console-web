<div class="modal fade bd-product-modal-md" id="ProjectModal" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <form method="POST" action="{{url('data_management/data_curation')}}" role="project">
            @CSRF
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Upload New Cuaration</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-sm-12">
                            <label for="simulation_input_id">Select Dataset<span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Dataset"></i></span>
                            </label>
                            <select data-width="100%" data-request="ajax-append-fields" data-target="#experiment_list" data-url="{{url('data_management/data_sets/ajax_list')}}" class="form-control js-example-basic-single" id="simulation_input_id" name="simulation_input_id">
                                <option value="">Select Dataset</option>
                                @if(!empty($datasets))
                                @foreach($datasets as $dataset)
                                <option value="{{___encrypt($dataset->id)}}">{{$dataset->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="curation_rule_id">Select Curation Rule<span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Curation Rule"></i></span>
                            </label>
                            <select data-width="100%" class="js-example-basic-single" id="curation_rule_id" name="curation_rule_id">
                                <option value="">Select Curation Rule</option>
                                @if(!empty($curation_rule))
                                @foreach($curation_rule as $rule)
                                <option value="{{___encrypt($rule->id)}}">{{$rule->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="experiment_id">Select Experiment<span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Experiment"></i></span>
                            </label>
                            <select data-width="100%" class="form-control js-example-basic-single" id="experiment_list" name="experiment">
                                <option value="">Select Experiment</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Enter Coefficient  of Variation Value <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Coefficient  of Variation Value"></i></span>
                            </label>
                            <input type="number" class="form-control" name="variation_coeficient" placeholder="Enter Coefficient  of Variation Value">
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Enter Smoothness Factor Value <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Smoothness Factor Value"></i></span>
                            </label>
                            <input type="number" class="form-control" name="smoothness_factor" placeholder="Enter Smoothness Factor Value">
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-request="ajax-submit" data-target='[role="project"]' class="btn btn-sm btn-secondary submit">
                        Submit
                    </button>
                    <button class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>