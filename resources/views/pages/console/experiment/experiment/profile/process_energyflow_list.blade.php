<div class="col-md-12 table-responsive">
    <table id="" class="tablemb-0">
        <thead>
            <th class="text-center align-middle"><input type="checkbox" id="example-select-all_en"></th>
            <th>Energy Stream Name</th>
            <th>Stream Flow type</th>
            <th>Experiment Unit</th>
            <th>Energy Utility</th>
            <th>Input/Output</th>
            <th class="text-center">Actions</th>
        </thead>
        <tbody>
            @if(!empty($process_experiment_info['expEnergyFlowArr']))
            @foreach($process_experiment_info['expEnergyFlowArr'] as $process_energy_key =>$process_energy_value)
            <tr>
                <td><input type="checkbox" value="{{___encrypt($process_energy_value['energy_flow_id'])}}" class="checkSingle_en" name="select_all_en[]"></td>
                <td>{{$process_energy_value['stream_name']}}</td>
                <td>{{$process_energy_value['stream_flowtype']}}</td>
                <td>
                    @if(!empty($process_experiment_info['experiment_units']))
                    @foreach($process_experiment_info['experiment_units'] as $experiment_unit)
                    @if($experiment_unit['id'] == $process_energy_value['experiment_unit_name'] )
                    <span>{{$experiment_unit['experiment_unit_name']}}</span>
                    @endif
                    @endforeach
                    @endif
                </td>
                <td>{{$process_energy_value['energy_utility_name']}}</td>
                <td>{{$process_energy_value['inputoutput']}}</td>
                <td>
                    <a href="javascript:void(0);" data-url="{{url('/experiment/process_exp_energflow/'.___encrypt($process_energy_value['energy_flow_id']).'/edit')}}" data-request="ajax-popup" data-target="#editenergyflow" data-tab="#ef{{$process_energy_value['energy_flow_id']}}" class="btn btn-sm btn-warning text-white btn-icon-text" data-toggle="tooltip" data-placement="bottom" title="Edit Data">
                        <i class="fas fa-edit  text-white"></i>
                    </a>
                    <a href="javascript:void(0);" data-url="{{ url('/experiment/process_exp_energflow/'.___encrypt($process_energy_value['energy_flow_id'])) }}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger btn-icon-text" data-toggle="tooltip" data-placement="bottom" title="Delete">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="6" class="text-center">No Record Found</td>
            </tr>
            @endif
        </tbody>
    </table>
</div>
<script>
    $("#example-select-all_en").click(function() {
        if ($(this).is(":checked")) {
            $(".deletebulk_en").show();
        } else {
            $(".deletebulk_en").hide();
        }
        $('.checkSingle_en').not(this).prop('checked', this.checked);
        $('.checkSingle_en').click(function() {
            if ($('.checkSingle_en: checked ').length == $('.checkSingle_en').length) {
                $('#example-select-all_en').prop('checked', true);
            } else {
                $('#example-select-all_en').prop('checked', false);
            }
        });
    });
    $('.checkSingle_en').click(function() {
        var len = $("[name='select_all_en[]']:checked").length;
        if (len > 1) {
            $(".deletebulk_en").show();
        } else {
            $(".deletebulk_en").hide();
        }
    });
</script>