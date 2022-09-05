<div class="table">
    <table class="table">
        <thead>
            <th>Outcome</th>
            @if($simulate_input->simulate_input_type=='reverse')
            <!-- <th>Priority</th> -->
            <th>Criteria</th>
            @endif
            <th>Value And Unit Type</th>
            @if($viewflag!="view_config")
            <th class="text-center">Actions</th>
            @endif
        </thead>
        <tbody id="output_master_outcome_list">
        </tbody>
    </table>
</div>
<div id="edit-div-outcome-master-output"></div>