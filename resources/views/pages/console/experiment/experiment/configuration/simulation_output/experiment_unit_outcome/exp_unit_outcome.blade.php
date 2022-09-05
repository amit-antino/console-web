<div class="table-responsive">
    <table class="table">
        <thead>
            <th>Experiment Unit Name</th>
            <th>Outcome</th>
            @if($simulate_input->simulate_input_type=='reverse')
            <th>Criteria</th>
          

            @endif
            <th>Value And Unit Type</th>
            @if($viewflag!="view_config")
            <th class="text-center">Actions</th>
            @endif
        </thead>
        <tbody id="exp_unit_outcome_list">
        </tbody>
    </table>
</div>
<div id="output-measured-data-exp-outcome-edit-div"></div>