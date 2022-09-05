<div class="modal fade bd-example-modal-lg" id="editconfigModal" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{url('mfg_process/simulation/'.___encrypt($data['process_dataset']['process_id']).'/dataset/'.___encrypt($data['process_dataset']['id']))}}" role="simulate-edit">
            <input type="hidden" name="_method" value="PUT">
                <div class="modal-header">
                    <h5 class="modal-title" id="userLabel">Edit Dataset</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Dataset Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Dataset Name"></i></span>
                            </label>
                            <input type="text" id="dataset_name" name="dataset_name" value="{{$data['process_dataset']['dataset_name']}}" class="form-control" value="" placeholder="Dataset Name">
                            <input type="hidden" id="process_id" name="process_id"  class="form-control" value="{{$data['process_dataset']['id']}}">
                            <input type="hidden" id="energy_data_source_input" name="energy_data_source_input" class="form-control" value="0">
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Process Simulation Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Variation Name" multiple-data-search-live="true"></i></span>
                            </label>
                            <select class="form-control" id="simulation_type" name="simulation_type" data-live-search="true" aria-readonly onchange="set_datasource_edit()">
                                <!-- <option selected disabled value="">Select Simulation Type</option> -->
                                @if(!empty($data['simulationtype']))
                                @foreach($data['simulationtype'] as $stype)
                                @if($data['process_dataset']['simulation_type']==$stype->id)
                                <option  data-energy="{{!empty($stype->enery_utilities)?1:0}}"  selected value="{{___encrypt($stype->id)}}">{{$stype->simulation_name}}</option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Mass Balance Data Source
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Data Source"></i></span>
                            </label>
                            <select class="form-control" id="mass_data_source" name="mass_data_source" data-live-search="true">
                                <!-- <option selected disabled value="">Select Data Source</option> -->
                                <option  value="{{$data['process_dataset']['data_source']['mass_balance']}}">{{$data['process_dataset']['data_source']['mass_balance']}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12" id="energy_data_source_div" style="display:none">
                            <label class="control-label">Energy Balance Data Source
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Data Source"></i></span>
                            </label>
                            <select class="form-control" id="energy_data_source" name="energy_data_source">
                                <!-- <option selected disabled value="">Select Data Source</option> -->
                                <option  value="{{$data['process_dataset']['data_source']['energy_utilities']}}" >{{$data['process_dataset']['data_source']['energy_utilities']}}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right">
                <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="simulate-edit"]' class="btn btn-sm btn-secondary submit">
                        Submit
                    </button>
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                    <button class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    set_datasource_edit();
    function set_datasource_edit(){
        var simulation_type = $("#editconfigModal #simulation_type").find(':selected').attr('data-energy');
        $("#editconfigModal #energy_data_source_input").val(simulation_type);
        if(simulation_type ==1){
            $("#editconfigModal #energy_data_source_div").show();
        }else{
            $("#editconfigModal #energy_data_source_div").hide();
        }
    }
</script>
