    @php
    $cnt = count($experiment_reports);
    @endphp
    @if (!empty($experiment_reports))
    @foreach ($experiment_reports as $report)
    @php
    $reportId=___encrypt($report['id']);
    @endphp
    <tr>
        @if (Auth::user()->role != 'console')
        <td>
            <input type="checkbox" value="{{ ___encrypt($report['id']) }}" class="checkSingle" name="select_all[]">
        </td>
        @endif
        <td>{{ $report['report_name'] }}
            <a href="javascript:void(0);" onclick="editreportName('{{$reportId}}')" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Report Name">
                <i class="fas fa-edit text-secondary"></i>
            </a>
        </td>
        <td class="text-wrap width-250">
            @if(!empty($report['experiment_deleted_at']))
            {{$report['experiment_name'] }}
            @else
            <a href="{{url('experiment/experiment/'.___encrypt($report['experiment_id']).'/view')}}" target="_blank"> {{$report['experiment_name'] }} </a>
            @endif
        </td>
        <td class="text-wrap width-250">
            @if(!empty($report['variation_deleted_at']) || !empty($report['experiment_deleted_at']))
            {{ $report['configuration_name'] }}
            @else
            <a href="{{url('experiment/experiment/'.___encrypt($report['experiment_id']).'/manage')}}" target="_blank">{{ $report['configuration_name'] }} </a>
            @endif

        </td>
        <td class="text-wrap width-250">
            @if(!empty($report['simulation_input_deleted_at']) || !empty($report['experiment_deleted_at']) || !empty($report['variation_deleted_at']))
            {{ str_replace('_', ' ', $report['dataset']) }}
            @else
            <a href="{{url('experiment/experiment/'.___encrypt($report['variation_id']).'/sim_config?apply_config='.___encrypt($report['simulation_input_id']))}}" target="_blank">{{ str_replace('_', ' ', $report['dataset']) }} </a>
            @endif
        </td>
        <td class="width-200">{{ ucfirst($report['simulate_input_type']) }}</td>
        <td class="text-wrap width-200">{{ $report['created_by'] }}</td>
        <td class="text-center text-wrap width-200">
            {{ dateTimeFormate($report['created_at']) }}
        </td>
        <td class="text-center">
            <span class="hide_status">{{$report['status']}}</span>

            @if ($report['status'] == 'success')
            <i class="fas fa-check-circle text-success" data-toggle="tooltip" data-placement="bottom" title="Success"></i>
            @elseif($report['status'] == 'failure')
            <i class="fas fa-times-circle text-danger" data-toggle="tooltip" data-placement="bottom" title="Failed"></i>
            @else
            <i class="fas fa-sync-alt text-warning" data-toggle="tooltip" data-placement="bottom" title="Processing"></i>
            @endif
        </td>
        <td class="text-center">
            @if ($report['status'] == 'success')
            <input type="hidden" value="{{$report['status']}}">
            <a href="{{ url('/reports/experiment/' . ___encrypt($report['id']) . '?report_type=' . ___encrypt($report['report_type'])) }}" type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="View Report">
                <i class="fas fa-eye text-secondary"></i>

            </a>
            @elseif($report['status'] == 'failure')
            <input type="hidden" value="{{$report['status']}}">
            <!-- <a href="{{ url('/reports/experiment/' . ___encrypt($report['id']) . '?report_type=' . ___encrypt($report['report_type'])) }}"
                                                            type="button" class="dropdown-item" data-toggle="tooltip"
                                                            data-placement="bottom" title="View Report">
                                                            <i class="fas fa-eye"></i> View
                                                        </a> -->
            <a type="button" href="javascript:void(0);" data-url="{{ url('/reports/experiment/' . ___encrypt($report['id']) . '/retry') }}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to retry?" type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Try Again">
                <i class="fas fa-redo text-secondary"></i>
            </a>
            @endif
            @if (Auth::user()->role != 'console')
            <a type="button" href="javascript:void(0);" data-url="{{ url('/reports/experiment/' . ___encrypt($report['id'])) }}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" type="button" class="btn btn-icon" data-placement="bottom" title="Delete Report">
                <i class="fas fa-trash text-secondary"></i>
            </a>
            @endif
        </td>
    </tr>
    @endforeach
    @endif
    <script>
        $('.hide_status').hide();
        $("#example-select-all").click(function() {
        $('.checkSingle').not(this).prop('checked', this.checked);
        var len = $("[name='select_all[]']:checked").length;
        if (len > 1) {
            $(".deletebulk").show();
        } else {
            $(".deletebulk").hide();
        }
    });
    $('.checkSingle').click(function() {
        var len = $("[name='select_all[]']:checked").length;
        if (len > 1) {
            $(".deletebulk").show();
        } else {
            $(".deletebulk").hide();
        }
        if (len == $('.checkSingle').length) {
            $('#example-select-all').prop('checked', true);
        } else {
            $('#example-select-all').prop('checked', false);
        }
    });
    </script>