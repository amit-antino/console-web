<div class="modal fade bd-product-modal-lg" id="unitModal{{___encrypt($unit['id'])}}" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" action="{{url('admin/master/unit_type/'.___encrypt($unit['id']))}}" role="UnitTypeEdit{{___encrypt($unit['id'])}}">
            <div class="modal-content">
                <input type="hidden" name="_method" value="PUT">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel">Edit Unit Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Unit Name <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Name"></i></span>
                            </label>
                            <input type="text" class="form-control" value="{{$unit->unit_name}}" name="unit_name" placeholder="Enter Name">
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Unit Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Add Unit Description"></i></span>
                            </label>
                            <textarea id="unit_description" name="unit_description" class="form-control" maxlength="10000" rows="5" placeholder="Description">{{$unit->description}}</textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Default Unit Constant Name
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Default Unit Constant Name"></i></span>
                            </label>
                            <!-- <input type="text" class="form-control" value="{{$unit->default_unit}}" name="default_unit" placeholder="Default Unit Constant Name"> -->
                            <select class="from-control" name="default_unit">
                                <option value="">Select Default Unit</option>
                                @if(!empty($unit->unit_constant))
                                @foreach($unit->unit_constant as $keys => $unit_constant)
                                <option @if($unit->default_unit==$unit_constant['id']) selected @endif value="{{___encrypt($unit_constant['id'])}}">{{$unit_constant['unit_name']}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            @if(!empty($unit->unit_constant))
                            @php
                            $total_count = count($unit->unit_constant);
                            $total_count=$total_count+1;
                            $count=1;
                            @endphp
                            @foreach($unit->unit_constant as $keys => $unit_constant)
                            <div id="remove-section-{{$count}}">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label class="control-label">Unit Constant Name<span class="text-danger">*</span>
                                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Unit Constant Name"></i></span>
                                        </label>
                                        <input type="text" class="form-control" name="unit_constant[{{$count}}][unit_name]" placeholder="Enter Unit Constant Name" value="{{$unit_constant['unit_name']}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label class="control-label">Unit Constant Symbol
                                            <span class="text-danger">*</span>
                                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Unit Constant Symbol"></i></span>
                                        </label>
                                        <input type="text" class="form-control" name="unit_constant[{{$count}}][unit_symbol]" placeholder="Enter Unit Constant Symbol" value="{{$unit_constant['unit_symbol']}}">
                                        <input type="hidden" name="unit_constant[{{$count}}][id]" value="{{$unit_constant['id']}}">
                                    </div>
                                    <div class="form-group col-md-2">
                                        <label class="control-label"><span class="text-danger">&nbsp;&nbsp;</span></label>
                                        </br>
                                        <button type="button" class="btn btn-sm btn-danger btn-icon" data-target="#remove-section-{{$count}}" data-count="{{$count}}" data-request="remove">
                                            <i class="fas fa-minus-circle"></i>
                                        </button>
                                        <button data-types="constant" data-target="#constant-edit" data-url="{{url('admin/master/unit_type/add-more-constant-field')}}" data-request="add-another" data-count="{{$total_count}}" type="button" class="btn btn-sm btn-secondary btn-icon" data-toggle="tooltip" data-placement="bottom" title="Add">
                                            <i class="fas fa-plus-circle"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @php $count++;@endphp
                            @endforeach
                            @else
                            @php $total_count = 1 @endphp
                            @endif
                            <!-- <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label class="control-label">Unit Constant Name<span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Unit Constant Name"></i></span>
                                    </label>
                                    <input type="text" class="form-control" name="unit_constant[{{$total_count}}][unit_name]" placeholder="Enter Unit Constant Name">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">Unit Constant Symbol<span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Unit Constant Symbol"></i></span>
                                    </label>
                                    <input type="text" class="form-control" name="unit_constant[{{$total_count}}][unit_symbol]" placeholder="Enter Unit Constant Symbol">
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="control-label"><span class="text-danger">&nbsp;&nbsp;</span></label>
                                    </br>
                                    <button data-types="constant" data-target="#constant-edit" data-url="{{url('admin/master/unit_type/add-more-constant-field')}}" data-request="add-another" data-count="{{$total_count}}" type="button" class="btn btn-sm btn-secondary btn-icon" data-toggle="tooltip" data-placement="bottom" title="Add">
                                        <i class="fas fa-plus-circle"></i>
                                    </button>
                                </div>
                            </div> -->
                            <div class="constant-edit" id="constant-edit">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="UnitTypeEdit{{___encrypt($unit['id'])}}"]' class="btn btn-sm btn-secondary submit">
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