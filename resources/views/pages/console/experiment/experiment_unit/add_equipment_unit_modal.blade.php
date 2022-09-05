<div class="modal fade bd-product-modal-md" id="equipmentModal" style="overflow:hidden;" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-md" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" action="{{url('organization/process_experiment/equipment_unit')}}" role="equipment_unit">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Create Equipment Unit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="equipment_unit_name">Experiment Equipment Unit Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Experiment Equipment Unit Name"></i></span>
                            </label>
                            <input type="text" class="form-control" id="equipment_unit_name" name="equipment_unit_name" placeholder="Enter Experiment Equipment Unit Name" required>
                        </div>
                        <div class="form-group col-md-6"></div>
                        <div class="form-group col-md-6">
                            <label for="conditions">Select Conditions
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Conditions"></i></span>
                            </label>
                            <select class="form-control" id="conditions" name="condition[]" multiple="multiple" required>
                                <option value="">Select Conditions</option>
                                @if(!empty($conditions))
                                @foreach($conditions as $condition)
                                <option value="{{___encrypt($condition->id)}}">{{$condition->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="outcomes">Select Outcomes
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Outcomes"></i></span>
                            </label>
                            <select class="form-control" id="outcomes" name="outcome[]" multiple="multiple" required>
                                <option value="">Select Conditions</option>
                                @if(!empty($outcomes))
                                @foreach($outcomes as $outcome)
                                <option value="{{___encrypt($outcome->id)}}">{{$outcome->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="stream_name">Number Of Input Stream
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Number Of Input Stream"></i></span>
                            </label>
                            <input type="number" name="stream_flow_input" id="stream_flow_input" class="form-control" placeholder="Enter Number Of Input Stream" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="stream_name">Number Of Output Stream
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Number Of Output Stream"></i></span>
                            </label>
                            <input type="number" name="stream_flow_output" id="stream_flow_output" class="form-control" placeholder="Enter Number Of Output Stream" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="unit_image">Select Experiment Unit Image
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Experiment Unit Image"></i></span>
                            </label>
                            <select name="unit_image" id="unit_image" class="js-example-basic-single">
                                <option value="" selected>Select Experiment Unit Image</option>
                                @if(!empty($unit_images))
                                @foreach($unit_images as $unit_image)
                                <option data-img_src="{{url($unit_image->image)}}" value="{{___encrypt($unit_image->id)}}">{{$unit_image->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="models">Select Models
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Models"></i></span>
                            </label>
                            <select name="models" id="models" class="form-control">
                                <option value="" selected>Select Models</option>
                                @if(!empty($models))
                                @foreach($models as $model_detail)
                                <option value="{{___encrypt($model_detail->id)}}">{{$model_detail->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Description"></i></span>
                            </label>
                            <textarea name="description" id="description" rows="5" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="experiment_unit_form" value="experiment_unit_form">
                <div class="modal-footer">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="equipment_unit"]' class="btn btn-sm btn-secondary submit">
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