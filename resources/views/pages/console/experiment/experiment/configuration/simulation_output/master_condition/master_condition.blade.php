<div class="table">
    <table id="simoutput_master_condition" class="table">
        <thead>
            <th>Condition</th>
            @if($simulate_input->simulate_input_type=='reverse')
            <th>Criteria</th>
            @endif
            <th>Value and Unit Type</th>
            @if($viewflag!="view_config")
            <th class="text-center">Actions</th>
            @endif
        </thead>
        <tbody id="condition_list_master">
        </tbody>
    </table>
</div>

<div id="edit-div-condition-master"></div>