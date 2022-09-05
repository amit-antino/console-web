@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/reports/experiment') }}">Experiments</a></li>
        <li class="breadcrumb-item active" aria-current="page">Experiment Report</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-3 mb-md-0">Report Name: {{$experiment_report->name}}</h4>
                </div>
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    <h5 class="mr-2">Generated Date: <span class="badge badge-secondary">{{$experiment_report->created_at}}</span></h5>
                    <h5 class="mr-2">Execution Time: <span class="badge badge-secondary">
                            {{ round($execution_info['value'], 5) }} {{$execution_info['unit_constants']['unit_name']}}
                            <i class="fas fa-stopwatch"></i>
                        </span>
                    </h5>
                    <h5 class="mr-2">Status:
                        @if($experiment_report->status == 'success')
                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> Success</span>
                        @elseif($experiment_report->status == 'failure')
                        <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Failed</span>
                        @else
                        <span class="badge badge-warning"><i class="fas fa-sync-alt"></i> Pending</span>
                        @endif
                    </h5>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col grid-margin stretch-card">
                        <div class="card border-left-secondary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col">
                                        <div class="h5 font-weight-bold text-secondary text-uppercase">
                                            <small>Experiment Name<br></small>
                                            {{$experiment_details['experiment_name']}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col grid-margin stretch-card">
                        <div class="card border-left-secondary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col">
                                        <div class="h5 font-weight-bold text-secondary text-uppercase">
                                            <small>Category Type<br></small>
                                            {{$experiment_details['category_name']}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!empty($experiment_details['classification_names']))
                    <div class="col grid-margin stretch-card">
                        <div class="card border-left-secondary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col">
                                        <div class="h5 font-weight-bold text-secondary text-uppercase">
                                            <small>Classification Type</small>
                                            @foreach($experiment_details['classification_names'] as $classification)
                                            <span class="badge badge-secondary">
                                                {{$classification['name']}}
                                            </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="col grid-margin stretch-card">
                        <div class="card border-left-secondary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col">
                                        <div class="h5 font-weight-bold text-secondary text-uppercase">
                                            <small>Data Source<br></small>
                                            {{$experiment_details['data_source']}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card border-left-secondary shadow h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col">
                                        <div class="h5 font-weight-bold text-secondary text-uppercase">
                                            <small>Assumptions</small>
                                        </div>
                                        <div class="p pl-3">
                                            <ol class="list-group">
                                                @if(!empty($response['assumptions']))
                                                @foreach($response['assumptions'] as $assumption)
                                                <li data-toggle="tooltip" data-placement="bottom" title="Assumptions based on Models">
                                                    {{$assumption}}
                                                </li>
                                                @endforeach
                                                @else
                                                No Record Found
                                                @endif
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 grid-margin stretch-card">
                        <div class="card border-left-secondary shadow h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col">
                                        <div class="h5 font-weight-bold text-secondary text-uppercase">
                                            <small>Recommendations</small>
                                        </div>
                                        <div class="p pl-3">
                                            <ol class="list-group">
                                                @if(!empty($response['recommendations']))
                                                @foreach($response['recommendations'] as $recommendation)
                                                <li data-toggle="tooltip" data-placement="bottom" title="Recommendations based on Models">
                                                    {{$recommendation}}
                                                </li>
                                                @endforeach
                                                @else
                                                No Record Found
                                                @endif
                                            </ol>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="text-center">
                            <div id="expprofileSpinner" class="spinner-border text-secondary" style="width: 2rem; height: 2rem;display: none; margin-top:25px;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <ul id="list-example1" class="nav nav-tabs">
                            @if(!empty($re_order_menu))
                            @foreach($re_order_menu as $menu)
                            <li class="nav-item">
                                @if($menu=="desired outcome")
                                <a class="nav-link fade show active" onclick='getView("{{$menu}}","{{($experiment_report->report_type)}}")' id="v-expdata-tab" data-toggle="tab" href="#v-expdata" role="tab" aria-controls="v-expdata" aria-selected="true">{{ucfirst($menu)}}</a>
                                @else
                                <a class="nav-link" onclick='getView("{{$menu}}","{{($experiment_report->report_type)}}")' id="v-expdata-tab" data-toggle="tab" href="#v-expdata" role="tab" aria-controls="v-expdata" aria-selected="true">{{ucfirst($menu)}}</a>
                                @endif
                            </li>
                            @endforeach
                            @endif
                        </ul>
                        <div class="tab-content tab-content-vertical border border-top-0 p-3" id="v-tabContent">
                            <div id="setData"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js')}}"></script>
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('assets/plugins/chartjs/Chart.min.js') }}"></script>
<script src="{{ asset('assets/plugins/peity/jquery.peity.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script type="text/javascript">
    function getView(value, type) {
        var id = '<?php echo $id ?>';
        $('#expprofileSpinner').show();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ url('/reports/experiment/data/') }}",
            method: 'GET',
            data: {
                value: value,
                report_id: id,
                report_type: type
            },
            success: function(result) {
                $("#homeData").css("display", "none");
                $("#setData").css("display", "");
                $('#setData').html(result.html);
                $('#expprofileSpinner').hide();
            }
        });
    }
    var r_type = '<?php echo ($experiment_report->report_type) ?>';
    if (r_type == 1) {
        getView("inputs", r_type);
    } else {
        getView("desired_outcome", r_type);
    }
</script>
@endpush