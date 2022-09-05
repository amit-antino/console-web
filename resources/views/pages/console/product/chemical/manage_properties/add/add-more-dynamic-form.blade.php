<div class="card" id="add_more_clone{{$count+1}}">
    <div class="card-body">
        <div class="form-row">
            @if(!empty($select_list))
            @foreach($select_list as $key_name => $unit_list)
            <div class="form-group col-md-6">
                <label for="{{$unit_list['id']}}">{{$unit_list['name']}}
                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$unit_list['name']}}"></i></span>
                </label>
                <select class="js-example-basic-single form-control prop-id" alt="{{___encrypt($property_id)}}" name="dynamic_prop[{{$new_count}}][add_more][{{$count}}][unit_constant_id][{{$key_name}}]">
                    <option value="">Select {{$unit_list['name']}}</option>
                    @if(!empty($unit_list['units']))
                    @foreach($unit_list['units'] as $list)
                    <option @if($unit_list['default_unit']==$list['id']) selected @endif value="{{___encrypt($list['id'])}}">{{$list['unit_name']}}</option>
                    @endforeach
                    @endif
                </select>
            </div>
            <input type="hidden" name="dynamic_prop[{{$new_count}}][add_more][{{$count}}][key][{{$key_name}}]" value="{{$unit_list['name']}}">
            <input type="hidden" name="dynamic_prop[{{$new_count}}][add_more][{{$count}}][unit_id][{{$key_name}}]" value="{{$unit_list['id']}}">
            <input type="hidden" name="dynamic_prop[{{$new_count}}][type]" value="13">
            <input type="hidden" name="dynamic_prop[{{$new_count}}][key]" value="{{$unit_list['name']}}">
            <div class="form-group col-md-6">
                <label for="{{___encrypt($unit_list['id'])}}">Percentage
                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Percentage"></i></span>
                </label>
                <input type="number" data-request="numeric" name="dynamic_prop[{{$new_count}}][add_more][{{$count}}][value][{{$key_name}}]" Placeholder="Enter Percentage" class="form-control">
            </div>
            @endforeach
            @endif
            <div class="form-group col-md-12">
                <label for="referenc_source">Reference Source</label>
                <textarea class="form-control" placeholder="Reference Source" name="dynamic_prop[{{$new_count}}][add_more][{{$count}}][refrence_source]"></textarea>
            </div>
        </div>
    </div>
    <div class="card-footer">
        <div class="form-row">
            <div class="form-group col-md-6">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input add_more_recommended" name="dynamic_prop[{{$new_count}}][add_more][{{$count}}][recommended]" id="customSwitch{{$count+1}}"">
                <label class=" custom-control-label" for="customSwitch{{$count+1}}">Recommended</label>
                </div>
            </div>
            <div class="form-group col-md-6">
                <button type="button" class="btn btn-sm btn-danger btn-icon">
                    <i class="fas fa-minus-circle" data-target="#add_more_clone{{$count+1}}" data-count="{{$count+1}}" data-request="remove"></i>
                </button>
            </div>
        </div>
    </div>
</div>