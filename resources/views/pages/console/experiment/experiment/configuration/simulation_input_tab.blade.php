<div class="tab-content profile-tab" id="myTabContent">
    <div class="text-center">
        <div id="loading" class="spinner-border text-secondary" style="width: 2rem; height: 2rem;display: none; margin-top:25px;">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <div class="tab-pane fade show active " id="raw_material" role="tabpanel" aria-labelledby="raw_material-tab">
        <div class="card">
            <div class="card-body">
                @if($simulate_input->simulate_input_type=='forward')
                @include('pages.console.experiment.experiment.configuration.simulation_output.raw_material.raw_material')
                @else
                @include('pages.console.experiment.experiment.configuration.simulation_set_point.raw_material.raw_material')
                @endif
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="master_condition" role="tabpanel" aria-labelledby="master_condition-tab">
        <div class="card">
            <div class="card-body">
                @include('pages.console.experiment.experiment.configuration.simulation_output.master_condition.master_condition')
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="master_outcome" role="tabpanel" aria-labelledby="ex_unit_condition-tab">
        <div class="card">
            <div class="card-body">
                @include('pages.console.experiment.experiment.configuration.simulation_output.master_outcome.master_outcome')
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="ex_unit_condition" role="tabpanel" aria-labelledby="master_outcome-tab">
        <div class="card">
            <div class="card-body">
                @include('pages.console.experiment.experiment.configuration.simulation_output.experiment_unit_condition.exp_unit_condition')
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="ex_unit_outcome" role="tabpanel" aria-labelledby="ex_unit_outcome-tab">
        <div class="card">
            <div class="card-body">
                @include('pages.console.experiment.experiment.configuration.simulation_output.experiment_unit_outcome.exp_unit_outcome')
            </div>
        </div>
    </div>
    <div class="tab-pane fade" id="simulation_type_tab" role="tabpanel" aria-labelledby="simulation_type_tab-tab">
        <div class="card">
            <div class="card-body">
                @include('pages.console.experiment.experiment.configuration.simulation_output.simulation_type.simulation_type')
            </div>
        </div>
    </div>
</div>