@if(!empty($unit_outcome))
@foreach($unit_outcome as $key => $unit_outcome_val)
<tr>

    <td>{{!empty($unit_outcome_val['exp_unit_name'])?$unit_outcome_val['exp_unit_name']:''}}</td>
    <td>{{$unit_outcome_val['outcome_name']}}</td>
    <td>
        {{$unit_outcome_val['value']}} {{empty($unit_outcome_val['unit_constant_name'])?$unit_outcome_val['default_constant_unit']:$unit_outcome_val['unit_constant_name']}}

    </td>
 
    <td class="text-center">
        <button type="button" data-url="{{url('experiment/experiment/edit-exp-unit-outcome-popup?simulate_input_id='.___encrypt($simulate_input_id).'&id='.___encrypt($unit_outcome_val['id']))}}" data-request="ajax-popup" data-count="{{$unit_outcome_val['id']}}" data-target="#output-measured-data-exp-outcome-edit-div" data-tab="#outcome_measured_data_exp_outcome_edit_modal{{$unit_outcome_val['id']}}" class="btn btn-sm btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit">
            <i class="fas fa-edit text-secondary fa-xs"></i>
        </button>
    </td>
  
</tr>
@endforeach
@endif