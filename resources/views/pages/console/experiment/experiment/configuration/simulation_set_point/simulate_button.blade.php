<form method="POST" action="{{url('experiment/experiment/simlated_updated_setpoint')}}" role='simlated_updated_setpoint'>
    <input type="hidden" name="process_experiment_id" value="{{$config->process_exp_id}}">
    <input type="hidden" name="experiment_variation_id" value="{{$config->id}}">
    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="simlated_updated_setpoint"]' class="btn btn-sm btn-secondary float-right text-white">Simulate Set Point</button>
</form>