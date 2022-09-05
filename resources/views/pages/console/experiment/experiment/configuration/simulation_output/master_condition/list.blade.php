@if(!empty($master_condition))
@foreach($master_condition as $count => $master_val)
<tr>
    <td>{{$master_val['condition_name']}}</td>
    <td>
        {{$master_val['value']}} {{empty($master_val['unit_constant_name'])?$master_val['default_constant_unit']:$master_val['unit_constant_name']}}
    </td>
    <td class="text-center">
        <button type="button" data-url="{{url('experiment/experiment/edit_master_condition_output_popup?simulate_input_id='.___encrypt($simulate_input_id).'&id='.___encrypt($master_val['id']))}}" data-request="ajax-popup" data-target="#edit-div-condition-master" data-tab="#editconditionModalMaster{{___encrypt($master_val['id'])}}" class="btn btn-sm btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit">
            <i class="fas fa-edit text-secondary fa-xs"></i>
        </button>
    </td>
</tr>
@endforeach
@endif