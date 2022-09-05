<div class="tab-pane fade" id="pe_simulate_point" role="tabpanel" aria-labelledby="pe_simulate_point_tab">
    <div class="row">
        <div class="col-md-3">
            <div class="nav nav-tabs nav-tabs-vertical" id="v-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" onclick='render_list_setpoint("{{___encrypt($simulate_input->id)}}","reverse_raw_material_list")' id="reverse_raw_material-tab" data-toggle="pill" href="#reverse_raw_material" role="tab" aria-controls="reverse_raw_material" aria-selected="true">Raw Material</a>
                <a class="nav-link " onclick='render_list_setpoint("{{___encrypt($simulate_input->id)}}","setpoint_master_condition_list")' id="ex_setpoint_master_condition-tab" data-toggle="pill" href="#ex_setpoint_master_condition" role="tab" aria-controls="ex_setpoint_master_condition" aria-selected="true">Master Conditions</a>
                <a class="nav-link" onclick='render_list_setpoint("{{___encrypt($simulate_input->id)}}","setpoint_unit_condition_list")' id="setpoint_unit_condition-tab" data-toggle="pill" href="#setpoint_unit_condition" role="tab" aria-controls="setpoint_unit_condition" aria-selected="false">Exp Unit Conditions</a>
                <a class="nav-link" onclick='render_list_setpoint("{{___encrypt($simulate_input->id)}}","setpoint_master_outcome_list")' id="master_exp_output-tab" data-toggle="pill" href="#master_exp_output" role="tab" aria-controls="master_exp_output" aria-selected="false">Master Outcomes</a>
                <a class="nav-link" onclick='render_list_setpoint("{{___encrypt($simulate_input->id)}}","setpoint_exp_unit_outcome_list")' id="exp_unit_output-tab" data-toggle="pill" href="#exp_unit_output" role="tab" aria-controls="exp_unit_output" aria-selected="false">Exp Unit Outcomes</a>
            </div>
        </div>
        <div class="col-md-9">
            <div class="text-center">
                <div id="loading_set" class="spinner-border text-secondary" style="width: 2rem; height: 2rem;display: none; margin-top:25px;">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="tab-content tab-content-vertical border p-3" id="v-tabContent">
                <div class="tab-pane fade show active" id="reverse_raw_material" role="tabpanel" aria-labelledby="reverse_raw_material-tab">
                    <div class="card">
                        <div class="card-body">
                            @include('pages.console.experiment.experiment.configuration.simulation_set_point.raw_material.raw_material')
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="ex_setpoint_master_condition" role="tabpanel" aria-labelledby="ex_setpoint_master_condition-tab">

                    <div class="card">
                        <div class="card-body">
                            @include('pages.console.experiment.experiment.configuration.simulation_set_point.master_condition.master_condition')
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="master_exp_output" role="tabpanel" aria-labelledby="master_exp_output-tab">
                    <div class="card">
                        <div class="card-body">
                            @include('pages.console.experiment.experiment.configuration.simulation_set_point.master_outcome.master_outcome')
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="setpoint_unit_condition" role="tabpanel" aria-labelledby="setpoint_unit_condition-tab">
                    <div class="card">
                        <div class="card-body">
                            @include('pages.console.experiment.experiment.configuration.simulation_set_point.exp_unit_condition.exp_unit_condition')
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="exp_unit_output" role="tabpanel" aria-labelledby="exp_unit_output-tab">
                    <div class="card">
                        <div class="card-body">
                            @include('pages.console.experiment.experiment.configuration.simulation_set_point.exp_unit_outcome.exp_unit_outcome')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('custom-scripts')
<script type="text/javascript">
    $("document").ready(function() {
        setTimeout(function() {
            $("#reverse_raw_material-tab").trigger('click');
        }, 10);
    });

    function render_list_setpoint(id, $target) {
        $('#loading_set').show();
        var $this = $(this);
        var simulation_input_id = $('#dataset_edit_id').val();
        var dataset_form_type = $('#dataset_form_type').val();
        var $url = "{{url('experiment/experiment/sim_config_setpoint/list')}}";
        $.ajax({
            url: $url,
            type: "GET",
            data: {
                id: id,
                type: $target,
                simulation_input_id: simulation_input_id,
                dataset_form_type: dataset_form_type,
            },
            success: function($response) {
                if ($response.status == true) {
                    $('#' + $target).html($response.html);
                    $('#loading_set').hide();
                    return false;
                }
            },
        });
    }
</script>
@endpush