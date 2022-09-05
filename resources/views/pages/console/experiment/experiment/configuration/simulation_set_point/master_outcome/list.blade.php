@if(!empty($master_outcome))
@foreach($master_outcome as $key =>$outcome_val)
<tr>
    <td>{{$outcome_val['outcome_name']}}
    </td>
    <!-- <td>{{$outcome_val['priority_name']}}</td> -->
    <td>{{$outcome_val['criteria_data']['name']}}</td>
    <td>
        {{$outcome_val['value']}}
        @if($outcome_val['criteria_data']['is_range_type']=='true')
        , {{$outcome_val['max_value']}}
        @endif
        {{empty($outcome_val['unit_constant_name'])?$outcome_val['default_constant_unit']:$outcome_val['unit_constant_name']}}
    </td>
    <td class="text-center">
        <button type="button" data-url="{{url('experiment/experiment/setpoint-master-exp-outcome-edit-popup?simulate_input_id='.___encrypt($simulate_input_id).'&id='.___encrypt($outcome_val['id']))}}" data-request="ajax-popup" data-target="#edit-div-outcome-master-output" data-tab="#editoutcomeModalMaster{{$outcome_val['id']}}" class="btn btn-sm btn-icon" data-toggle=" tooltip" data-placement="bottom" title="Edit">
            <i class="fas fa-edit text-secondary fa-xs"></i>
        </button>
    </td>
</tr>
@endforeach
@endif