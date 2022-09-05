<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin float-right mt-0 mr-0">
    <div class="d-flex align-items-center flex-wrap text-nowrap float-right mt-0 mr-0">

        @if($process_experiment_info['viewflag']=="manage")

        @php
        $per = request()->get('sub_menu_permission');
        $permission=!empty($per['variation']['method'])?$per['variation']['method']:[];
        @endphp
        @if(in_array('create',$permission))
        <button type="button" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" data-toggle="modal" data-target="#configModal" data-toggle="tooltip" data-placement="bottom" title="Save Variation">
            <i class="fas fa-plus"></i>&nbsp;&nbsp;
            Add Experiment Variation
        </button>&nbsp;
        @endif
        @if(in_array('delete',$permission))
        <div class="deletebulk_configuration" style="display: none;">
            <button type="button" onclick="bulkdelVartion()" class="btn btn-sm btn-danger btn-icon-text mt-0 mr-0 d-none d-md-block">
                <i class="fas fa-trash"></i>&nbsp;&nbsp; Delete
            </button>
        </div>
        @endif
        @endif
    </div>
</div>
<div class="card-body mb-3 grid-margin" id="view_exp_config_data">
</div>


<script>
    getConfigurationView();

    function getConfigurationView() {
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/experiment/experiment/view_exp_configuration') }}",
            method: 'POST',
            data: {
                process_experiment_id: process_experiment_id,
                viewflag: viewflag
            },
            success: function(result) {
                $('#view_exp_config_data').html(result.html);
                $('#expprofileSpinner').hide();
            }
        });
    }
</script>