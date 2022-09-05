<div class="modal fade capital_cost_model" id="add_capital_cost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Equipment Capital Cost </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label class="control-label">Process plant size
                            <span title="Process plant size"><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top"></i></span>
                        </label>
                        <div class="input-group">
                            <input type="number" min="0.0000000001" data-request="isnumeric" class="form-control" name="ecc_id[]" id="ecc_id" value="{{isset($data['editData']['process_plant_size']) ? $data['editData']['process_plant_size'] : '' }}">
                            <select class="form-control form-control-md" name="pps_unit[]" id="pps_unit">
                                <option value="0">Select Unit</option>
                                @if(!empty($data['capitalcost_unit']))
                                @foreach($data['capitalcost_unit'] as $mkk =>$mvv)
                                @if(isset($data['editData']['pps_unit']) && $data['editData']['pps_unit'] == $mkk )
                                <option selected value="{{$mkk}}">{{$mvv}}</option>
                                @else
                                <option selected value="{{$mkk}}">{{$mvv}}</option>
                                @endif
                                @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <select class="form-control form-control-md getpps" onchange="getpps(this.value)" name="basic[]" id="basic">
                            <option value="0">Select Flowtype</option>
                            @if(!empty($data['capitalcost_flowtype']))
                            @foreach($data['capitalcost_flowtype'] as $fk =>$fv)
                            @if(isset($data['editData']['flowtype_id']) && $data['editData']['flowtype_id'] == $fk )
                            <option selected value="{{$fk}}">{{$fv}}</option>
                            @else
                            <option value="{{$fk}}">{{$fv}}</option>
                            @endif
                            @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group col-sm-6">
                        <input type="text" disabled class="form-control pps" name="pps[]" id="pps_" value="{{isset($data['editData']['pps_reference']) ? $data['editData']['pps_reference'] : '' }}">
                        <input type="hidden" disabled class="form-control ppsid" name="ppsid[]" id="ppsid_" value="{{isset($data['editData']['pps_refrence_id']) ? $data['editData']['pps_refrence_id'] : '' }}">
                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label">Enter Capex Estimate
                            <span id="rp" title="Specific to this process only"><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top"></i></span>
                          
                        </label>
                        <div class="input-group">
                            <input type="number" min="0.0000000001" data-request="isnumeric" value="{{isset($data['editData']['capex_estimate']) ? $data['editData']['capex_estimate'] : '' }}" class="form-control" name="capex_estimate[]" id="capex_estimate">
                            <select class="form-control form-control-md" name="price[]" id="price">
                                <option value="">Select Unit</option>
                                <option {{(isset($data['editData']['capex_price_unit']) && $data['editData']['capex_price_unit']=='1' ) ? 'selected' : '' }} value="1">US $</option>
                                <option {{(isset($data['editData']['capex_price_unit']) && $data['editData']['capex_price_unit']=='4' ) ? 'selected' : '' }} value="4">Euro</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group col-sm-6">
                        <label class="control-label">Enter Reference
                            <span title="Enter Reference"><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top"></i></span>
                        </label>
                        <input type="text" class="form-control" name="capex_reference[]" id="capex_reference" value="{{isset($data['editData']['capex_reference']) ? $data['editData']['capex_reference'] : '' }}">
                        <input type="hidden" class="form-control" id="getAction" value="{{isset($data['action']) ? $data['action'] : 'add' }}">
                        <input type="hidden" class="form-control" id="capId" value="{{isset($data['editid']) ? $data['editid']: '' }}">
                        <input type="hidden" class="form-control" id="is_default" value="{{isset($data['editData']['is_default']) ? $data['editData']['is_default']: '0' }}">

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" onclick="capitalCostSave()">Save</button>
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-----    --->

<script>
    feather.replace()
  </script>