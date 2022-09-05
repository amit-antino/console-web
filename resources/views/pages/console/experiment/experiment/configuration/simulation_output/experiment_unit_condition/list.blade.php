@if(!empty($unit_condition))
@foreach($unit_condition as $unit_condition_val)
<tr>
    <td>{{!empty($unit_condition_val['exp_unit_name'])?$unit_condition_val['exp_unit_name']:''}}
    </td>
    <td>{{$unit_condition_val['condition_name']}}</td>
    <td>
        {{$unit_condition_val['value']}} {{empty($unit_condition_val['unit_constant_name'])?$unit_condition_val['default_constant_unit']:$unit_condition_val['unit_constant_name']}}

    </td> 
    
    <td class="text-center">
        <button type="button" data-url="{{url('experiment/experiment/edit-exp-unit-condition-popup?simulate_input_id='.___encrypt($simulate_input_id).'&id='.___encrypt($unit_condition_val['id']))}}" data-request="ajax-popup" data-count="{{$unit_condition_val['id']}}" data-target="#edit-div-unit-condition" data-tab="#editUnitconditionModal{{$unit_condition_val['id']}}" class="btn btn-sm btn-icon" data-toggle=" tooltip" data-placement="bottom" title="Edit">
            <i class="fas fa-edit text-secondary fa-xs"></i>
        </button>
    </td>
    
</tr>
@endforeach
@endif