@if(!empty($unit_condition))
@foreach($unit_condition as $unit_condition_val)
<tr>
    <td>{{!empty($unit_condition_val['exp_unit_name'])?$unit_condition_val['exp_unit_name']:''}}
    </td>
    <td>{{$unit_condition_val['condition_name']}}</td>
    <td>{{$unit_condition_val['criteria_data']['name']}}</td>
    <td>
        {{$unit_condition_val['value']}}
        @if($unit_condition_val['criteria_data']['is_range_type']=='true')
        , {{$unit_condition_val['max_value']}}
        @endif
        {{empty($unit_condition_val['unit_constant_name'])?$unit_condition_val['default_constant_unit']:$unit_condition_val['unit_constant_name']}}

    </td>

    <td class="text-center">
        <button type="button" data-url="{{url('experiment/experiment/setpoint-unit-condition-edit-popup?simulate_input_id='.___encrypt($simulate_input_id).'&id='.___encrypt($unit_condition_val['id']))}}" data-request="ajax-popup" data-count="{{$unit_condition_val['id']}}" data-target="#edit-div-unit-condition" data-tab="#editUnitconditionModal{{$unit_condition_val['id']}}" class="btn btn-sm btn-icon" data-toggle=" tooltip" data-placement="bottom" title="Edit">
            <i class="fas fa-edit text-secondary fa-xs"></i>
        </button>
    </td>

</tr>
@endforeach
@endif