@if(!empty(_arefy($properties['sub_property']['dynamic_fields'])))
<div class="form-row">
    @php
    $count=0;
    @endphp
    @foreach($properties['sub_property']['dynamic_fields'] as $count => $fields)
    @php
    $field_name = !empty($fields['field_name'])?$fields['field_name']:'';
    $field_type = !empty($fields['field_type_id'])?$fields['field_type_id']:'';
    $unit_name = !empty($fields['unit_id'])?$fields['unit_id']:'';
    $select_list = !empty($fields['select_list'])?$fields['select_list']:[];
    $field_name = !empty($field_name)?$field_name:'';
    $field_id = str_replace(' ','_',$field_name);
    $field_id = strtolower($field_id);
    @endphp
    @if($field_type=='5')
    <div class="form-group col-md-12">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="{{$field_id}}">{{$field_name}}
                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
                </label>
                <select class="js-example-basic-single form-control prop-id" id="on_changes" alt="{{___encrypt($properties['property_id'])}}" name="dynamic_prop[{{$count}}][unit_constant_id]">
                    <option value="">Select {{$field_name}}</option>
                    @if(!empty($select_list['units']))
                    @foreach($select_list['units'] as $list)
                    <option @if($select_list['default_unit']==$list['id']) selected @endif value="{{___encrypt($list['id'])}}">{{$list['unit_name']}}</option>
                    @endforeach
                    @endif
                </select>
                <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
                <input type="hidden" name="dynamic_prop[{{$count}}][unit_id]" value="{{$unit_name}}">
            </div>
            <div class="form-group col-md-6">
                <label for="{{$field_id}}">Enter {{$field_name}}
                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
                </label>
                <input type="number" id="chem_value" min="0.0000000001" data-request="isnumeric" name="dynamic_prop[{{$count}}][value]" Placeholder="Enter {{$field_name}}" class="form-control">
            </div>
        </div>
    </div>
    @endif
    @if($field_type=='6')
    <div class="form-group col-md-12">
        <div class="form-row">
            <label for="{{$field_id}}">{{$field_name}}
                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
            </label>
            <select class="js-example-basic-single form-control prop-id" alt="{{___encrypt($properties['property_id'])}}" name="dynamic_prop[{{$count}}][unit_constant_id]">
                <option value="">Select {{$field_name}}</option>
                @if(!empty($select_list['units']))
                @foreach($select_list['units'] as $list)
                <option @if($select_list['default_unit']==$list['id']) selected @endif value="{{___encrypt($list['id'])}}">{{$list['unit_name']}}</option>
                @endforeach
                @endif
            </select>
            <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
            <input type="hidden" name="dynamic_prop[{{$count}}][unit_id]" value="{{$unit_name}}">
        </div>
    </div>
    @endif
    @if($field_type=='13')
    <div class="form-group col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="form-row">
                    @if(!empty($select_list))
                    @foreach($select_list as $key_name => $unit_list)
                    <div class="form-group col-md-6">
                        <label for="{{$key_name}}">{{$unit_list['name']}}
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_type}}"></i></span>
                        </label>
                        <select class="js-example-basic-single form-control prop-id" alt="{{___encrypt($properties['property_id'])}}" name="dynamic_prop[{{$count}}][add_more][{{$count}}][unit_constant_id][{{$key_name}}]">
                            <option value="">Select {{$unit_list['name']}}</option>
                            @if(!empty($unit_list['units']))
                            @foreach($unit_list['units'] as $list)
                            <option @if($unit_list['default_unit']==$list['id']) selected @endif value="{{___encrypt($list['id'])}}">{{$list['unit_name']}}</option>
                            @endforeach
                            @endif
                        </select>
                        <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
                        <input type="hidden" name="dynamic_prop[{{$count}}][key]" value="{{$unit_list['name']}}">
                        <input type="hidden" name="dynamic_prop[{{$count}}][add_more][{{$count}}][unit_id][{{$key_name}}]" value="{{$unit_list['id']}}">
                        <input type="hidden" name="dynamic_prop[{{$count}}][add_more][{{$count}}][key][{{$key_name}}]" value="{{$field_type}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="{{$field_id}}">Percentage
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$unit_list['name']}}"></i></span>
                        </label>
                        <input type="text" name="dynamic_prop[{{$count}}][add_more][{{$count}}][value][{{$key_name}}]" Placeholder="Enter {{$unit_list['name']}}" class="form-control">
                    </div>

                    @endforeach
                    @endif
                    @php
                    $val = implode(',',$unit_name)
                    @endphp
                    <div class="form-group col-md-12">
                        <label for="referenc_source">Reference Source</label>
                        <textarea class="form-control" placeholder="Reference Source" name="dynamic_prop[{{$count}}][add_more][{{$count}}][refrence_source]" name="refrence_source"></textarea>
                    </div>

                </div>
            </div>
            <div class="card-footer">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input add_more_recommended" name="dynamic_prop[{{$count}}][add_more][{{$count}}][recommended]" id="customSwitch{{$count}}">
                            <label class="custom-control-label" for="customSwitch{{$count}}">Recommended</label>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <button type="button" data-request="add-another" data-url="{{url('add-more-chemicals-dynamic-add-field')}}" data-types="{{$val}}" data-count="{{$count+1}}" data-new_count={{$count}} data-target="#add_more_clone_append{{$count}}" class="btn btn-icon btn-secondary btn-sm btn-copy{{$count}}" data-toggle="tooltip" data-placement="bottom" title="Add">
                            <i class="fas fa-plus-circle"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="add_more_clone_append{{$count}}"></div>
    </div>
    @endif
    @if($field_type=='1')
    <div class="form-group col-md-4">
        <label for="{{$field_id}}">{{$field_name}}
            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
        </label>
        <input type="text" name="dynamic_prop[{{$count}}][value]" id="{{$field_id}}" class="form-control">
        <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
    </div>
    @endif
    @if($field_type=='3')
    <div class="form-group col-md-4">
        <label for="{{$field_id}}">{{$field_name}}
            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
        </label>
        <input type="radio" class="form-control" id="{{$field_id}}" name="dynamic_prop[{{$count}}][value]">
        <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
    </div>
    @endif
    @if($field_type=='7')
    <div class="form-group col-md-12">
        <label for="{{$field_id}}">{{$field_name}}
            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
        </label>
        <select class="prop-id js-example-basic-multiple" alt="{{___encrypt($properties['property_id'])}}" name="dynamic_prop[{{$count}}][unit_constant_id][]" multiple="">
            <option value="">Select {{$field_name}}</option>
            @if(!empty($select_list['units']))
            @foreach($select_list['units'] as $list)
            <option value="{{___encrypt($list['id'])}}">{{$list['unit_name']}}</option>
            @endforeach
            @endif
        </select>
        <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
        <input type="hidden" name="dynamic_prop[{{$count}}][unit_id]" value="{{$unit_name}}">
    </div>
    @endif
    @if($field_type=='8')
    <div class="form-group col-md-12">
        <label for="{{$field_id}}">{{$field_name}}
            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
        </label>
        <textarea name="dynamic_prop[{{$count}}][value]" id="{{$field_id}}" class="form-control" rows="5"></textarea>
        <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
    </div>
    @endif
    @if($field_type=='4')
    <div class="form-group col-md-4">
        <label for="{{$field_id}}">{{$field_name}}
            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
        </label>
        <input type="date" name="dynamic_prop[{{$count}}][value]" id="{{$field_id}}" class="form-control">
        <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
    </div>
    @endif
    @if($field_type=='10')
    <div class="form-group col-md-4">
        <label for="{{$field_id}}">{{$field_name}}
            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
        </label>
        <input type="time" name="dynamic_prop[{{$count}}][value]" id="{{$field_id}}" class="form-control">
        <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
    </div>
    @endif
    @if($field_type=='11')
    <div class="form-group col-md-6">
        <label for="{{$field_id}}">{{$field_name}}
            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
        </label>
        <input type="file" name="dynamic_prop[{{$count}}][value]" id="{{$field_id}}" class="form-control">
        <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
    </div>
    @endif
    @if($field_type=='12')
    <div class="form-group col-md-4">
        <label for="{{$field_id}}">{{$field_name}}
            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
        </label>
        <input type="number" data-request="isnumeric" min="0.0000000001" name="dynamic_prop[{{$count}}][value]" id="{{$field_id}}" class="form-control">
        <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
    </div>
    @endif
    @if($field_type=='9')
    <div class="form-group col-md-12">
        <label for="tags_{{$field_id}}">{{$field_name}}
            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
        </label>
        <input type="text" class="form-control" id="tags_{{$field_id}}" name="dynamic_prop[{{$count}}][value]" />
        <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
    </div>
    @endif
    @if($field_type=='2')
    <div class="form-group col-md-4">
        <label class="form-check form-check-label form-check-inline">
            <input type="checkbox" id="{{$field_id}}" class="form-check-input" name="dynamic_prop[{{$count}}][value]">{{$field_name}}
        </label>
        <input type="hidden" name="dynamic_prop[{{$count}}][type]" value="{{$field_type}}">
    </div>
    @endif
    @php
    $count++;
    @endphp
    @endforeach
</div>
@endif
@if(!empty(_arefy($properties['sub_property']['fields'])))
<div class="form-row">
    @php
    $count=0;
    @endphp
    @foreach($properties['sub_property']['fields'] as $count => $fields)
    @php
    $field_name = !empty($fields['field_name'])?$fields['field_name']:'';
    $field_type = !empty($fields['field_type_id'])?$fields['field_type_id']:'';
    $field_name = !empty($field_name)?$field_name:'';
    $field_id = str_replace(' ','_',$field_name);
    $field_id = strtolower($field_id);
    @endphp
    @if($field_type=='8')
    <div class="form-group col-md-12">
        <label for="{{$field_id}}">{{$field_name}}
            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
        </label>
        <textarea name="prop[{{$count}}][value]" id="{{$field_id}}" class="form-control" rows="5"></textarea>
        <input type="hidden" name="prop[{{$count}}][type]" value="{{$field_type}}">
        <input type="hidden" name="prop[{{$count}}][key]" value="{{$field_name}}">
    </div>
    @endif
    @if($field_type=='9')
    <div class="form-group col-md-12">
        <label for="tags_{{$field_id}}">{{$field_name}}
            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="{{$field_name}}"></i></span>
        </label>
        <input type="text" class="form-control" id="tags_{{$field_id}}" name="prop[{{$count}}][value]" />
        <input type="hidden" name="prop[{{$count}}][type]" value="{{$field_type}}">
        <input type="hidden" name="prop[{{$count}}][key]" value="{{$field_name}}">
    </div>
    @endif
    @if($field_type=='2')
    <div class="form-group col-md-4">
        <label class="form-check form-check-label form-check-inline">
            <input type="checkbox" id="{{$field_id}}" class="form-check-input" name="prop[{{$count}}][value]">{{$field_name}}
        </label>
        <input type="hidden" name="prop[{{$count}}][type]" value="{{$field_type}}">
        <input type="hidden" name="prop[{{$count}}][key]" value="{{$field_name}}">
    </div>
    @endif
    @php
    $count++;
    @endphp
    @endforeach
</div>
@endif
<script type="text/javascript">
    $(function() {
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }
        if ($(".js-example-basic-multiple").length) {
            $(".js-example-basic-multiple").select2();
        }
        $(".add_more_recommended").change(function() {
            $(".add_more_recommended").prop('checked', false);
            $(this).prop('checked', true);
        });

    });
</script>