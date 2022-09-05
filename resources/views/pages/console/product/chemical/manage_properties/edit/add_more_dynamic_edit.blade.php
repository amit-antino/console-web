<div class="form-group col-md-12">

    @if($val_prop[$count]['field_type']=='add_more')
    @foreach($val_prop[$count]['add_more_key'] as $new_key => $prop_value_add_more)
    <div class="form-row" id="remove-dynamic{{$new_key}}">
        @if(!empty($prop_value_add_more['unit_name']))
        @foreach($prop_value_add_more['unit_name'] as $loopss => $unit_list)
        @php
        $data_unit = \App\Models\Master\MasterUnit::where('id',$unit_list)->first();
        @endphp
        <div class="form-group col-md-3">
            <label for="{{$data_unit->id}}">{{$data_unit->unit_name}}
                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$data_unit->unit_name}}"></i></span>
            </label>
            <select class="js-example-basic-single prop-id" alt="{{___encrypt($property_id)}}" name="dynamic_prop[{{$count}}][add_more][{{$new_key}}][value][{{$loopss}}]">
                <option value="">Select {{$data_unit->unit_name}}</option>
                @if(!empty($data_unit->unit_constant))
                @foreach($data_unit->unit_constant as $units)
                <option @if($units['id']==$prop_value_add_more['field_value'][$loopss]) selected @endif value="{{___encrypt($units['id'])}}">{{$units['unit_name']}}</option>
                @endforeach
                @endif
            </select>
            <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">

            <input type="hidden" name="dynamic_prop[{{$count}}][add_more][{{$new_key}}][unit_name][{{$loopss}}]" value="{{$data_unit->id}}">
            <input type="hidden" name="dynamic_prop[{{$count}}][add_more][{{$new_key}}][key][{{$loopss}}]" value="{{$data_unit->unit_name}}">
        </div>
        <div class="form-group col-md-2">
            <label for="{{$field_id}}">{{$data_unit->unit_name}}
                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$data_unit->unit_name}}"></i></span>
            </label>
            <input type="text" value="{{$prop_value_add_more['unit_value'][$loopss]}}" name="dynamic_prop[{{$count}}][add_more][{{$new_key}}][unit_value][{{$loopss}}]" Placeholder="Enter {{$data_unit->unit_name}}" class="form-control">
        </div>
        @endforeach
        @endif
        @php
        $val = implode(',',$unit_name)
        @endphp
        <div class="form-group col-md-2">
            <button type="button" data-request="add-another" data-url="{{url('add-more-chemicals-dynamic-add-field')}}" data-types="{{$val}}" data-count="{{$new_key+1}}" data-new_count={{$count}} data-target="#add_more_clone_append{{$count}}" class="btn btn-secondary btn-icon btn-sm btn-copy{{$count}}" data-toggle="tooltip" data-placement="bottom" title="Add">
                <i class="fas fa-plus-circle"></i>
            </button>
            <button type="button" class="btn btn-sm btn-danger btn-icon">
                <i class="fas fa-minus-circle" data-target="#remove-dynamic{{$new_key}}" data-request="remove"></i>
            </button>
        </div>
    </div>
    @endforeach

    @endif

    <div id="add_more_clone_append{{$count}}"></div>
</div>