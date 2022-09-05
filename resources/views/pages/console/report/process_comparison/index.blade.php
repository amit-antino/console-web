@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Process Simulation Comparison</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Process Simulation Comparison</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a href="{{url('reports/process_comparison/create')}}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
            <i class="fas fa-plus"></i>&nbsp;
            Add Process Simulation Comparison
        </a>
        <div class="deletebulk">
            <button type="button" data-url="{{url('/reports/process_comparison/bulk-delete')}}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
                <i class="fas fa-trash"></i>&nbsp;
                Delete
            </button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="process_simulation_comparisons" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                @if(Auth::user()->role != 'console')
                                <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                                @endif
                                <th>Report Name</th>
                                <th>Process Name</th>
                                <th>Generated Date</th>
                                <th>Report Type</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $cnt=count($process_comparsion_reports)
                            @endphp
                            @if(!empty($process_comparsion_reports))
                            @foreach($process_comparsion_reports as $k=>$v)
                            <tr>
                                @if(Auth::user()->role != 'console')
                                <td><input type="checkbox" value="{{___encrypt($v['id'])}}" class="checkSingle" name="select_all[]"></td>
                                @endif
                                <td>{{$v['report_name']}}</td>
                                <td>

                                    <ul class="list-group">
                                        @if(!empty($v['process_simulation_ids']))
                                        @foreach($v['process_simulation_ids'] as $pk=>$pv)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">

                                            <span class="badge badge-info">
                                                {{getprocessname($pv)}}
                                            </span>
                                        </li>
                                        @endforeach
                                        @endif
                                    </ul>



                                </td>
                                <td>{{$v['created_at']}}</td>

                                <td>{{$v['report_type']}}</td>

                                <td>

                                    <span class="badge badge-warning"><i class="fas fa-sync-alt"></i> Pending</span>

                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        
                                            <a href="{{ url('/reports/process_comparison/1')}}" type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="View Report">
                                                <i class="fas fa-eye text-secondary"></i>
                                            </a>
                                            @if(Auth::user()->role != 'console')
                                            <a href="javascript:void(0);" data-url="{{url('/reports/process_comparison/'.___encrypt($v['id']))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete Report">
                                                <i class="fas fa-trash text-secondary"></i> 
                                            </a>
                                            @endif
                                        
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    var cnt= '{{$cnt}}'
    if(cnt>10){
        $('#process_simulation_comparisons').DataTable();
    }
    $('.deletebulk').hide();
    $("#example-select-all").click(function() {
        if ($(this).is(":checked")) {
            $(".deletebulk").show();
        } else {
            $(".deletebulk").hide();
        }
        $('.checkSingle').not(this).prop('checked', this.checked);
        $('.checkSingle').click(function() {
            if ($('.checkSingle:checked').length == $('.checkSingle').length) {
                $('#example-select-all').prop('checked', true);
            } else {
                $('#example-select-all').prop('checked', false);
            }
        });
    });
    $('.checkSingle').click(function() {
        var len = $("[name='select_all[]']:checked").length;
        if (len > 1) {
            $(".deletebulk").show();
        } else {
            $(".deletebulk").hide();
        }
    });
</script>
@endpush