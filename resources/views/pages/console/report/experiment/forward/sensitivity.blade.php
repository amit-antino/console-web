<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active text-uppercase font-weight-normal" id="summary-tab" data-toggle="tab" href="#summary" role="tab" aria-controls="summary" aria-selected="true">Summary</a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-uppercase font-weight-normal" id="detailed-tab" data-toggle="tab" href="#detailed" role="tab" aria-controls="detailed" aria-selected="false">Detailed</a>
    </li>
</ul>
<div class="tab-content border border-top-0 p-3" id="myTabContent">
    <div class="tab-pane fade show active" id="summary" role="tabpanel" aria-labelledby="summary-tab">
        <div class="row">
            @if(!empty($data['sensitivity']['summary']['master_outcomes']))
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Sensitivity Master Outcomes</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($data['sensitivity']['summary'] as $master_outcome)
                            <div class="col-md-12 mb-3">
                                <div class="card grid-margin stretch-card">
                                    <div class="card-header">
                                        <h6 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Outcome Name: {{$master_outcome['outcome_name']}}</h6>
                                    </div>
                                    <div class="card-body">
                                        @if(!empty($master_outcome['graph']))
                                        <?php print_r($master_outcome['graph']); ?>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @if(!empty($data['sensitivity']['summary']['graphs']))
            <div class="row">
                <div class="col-md-12 mb-3 stretch-card">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                            <div>
                                <h6 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Graphical Representations</h6>
                            </div>
                            <div class="d-flex align-items-center flex-wrap text-nowrap">
                                <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                    <button class="btn btn-sm btn-secondary" onclick="chabgeView(1)">
                                        <i class="fas fa-grip-lines" aria-hidden="true"></i>
                                    </button>
                                    <button class="btn btn-sm btn-secondary" onclick="chabgeView(2)">
                                        <i class="fas fa-grip-vertical" aria-hidden="true"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($data['sensitivity']['summary']['graphs'] as $gk=>$gvv)
                                <div class="col-md-6 setview">
                                    <h6 class="card-title">#{{$gk+1}} {{str_replace("_", " ", Str::upper($gvv['name']))}}</h6>
                                    <canvas id="sensitivity_summary_graph_{{$gk}}" class="sensitivity_summary_graph_{{$gk}}"></canvas>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    @if(!empty($data['sensitivity']['detailed']['graphs']))
    <div class="tab-pane fade " id="detailed" role="tabpanel" aria-labelledby="detailed-tab">
        <div class="row">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h6 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Sensitivity Graphical Representations</h6>
                </div>
            </div>
            <div class="col-md-12 card-body mb-3 grid-margin text-center">
                <img src="{{url('assets/images/distribution.svg')}}" alt="Image" class="img-fluid" height="600" width="1000" />
            </div>
            <div class="col-md-12 mb-3 stretch-card">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                        <div>

                        </div>
                        <div class="d-flex align-items-center flex-wrap text-nowrap">
                            <div class="btn-group btn-group-sm" role="group" aria-label="...">
                                <button class="btn btn-sm btn-secondary" onclick="chabgeView(1)">
                                    <i class="fas fa-grip-lines" aria-hidden="true"></i>
                                </button>
                                <button class="btn btn-sm btn-secondary" onclick="chabgeView(2)">
                                    <i class="fas fa-grip-vertical" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($data['sensitivity']['detailed']['graphs'] as $gk=>$gvv)
                            <div class="col-md-6 setview">
                                <h6 class="card-title">#{{$gk+1}} {{str_replace("_", " ", Str::upper($gvv['name']))}}</h6>
                                <canvas id="sensitivity_detailed_graph_{{$gk}}" class="sensitivity_detailed_graph_{{$gk}}"></canvas>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
<script src="{{ asset('assets/plugins/chartjs/Chart.min.js') }}"></script>
<script>
    var sensitivity_summary_graphs = '<?php echo json_encode($data['sensitivity']['summary']['graphs'], true) ?>';
    var summary_graphs = JSON.parse(sensitivity_summary_graphs);
    if (Object.keys(summary_graphs).length != 0) {
        var dynamicColors = function() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return "rgb(" + r + "," + g + "," + b + ")";
        };
        for (let i in summary_graphs) {
            var sites = [];
            var lab = [];
            lab = ((summary_graphs[i]['graph_type'] == "bar")) ? summary_graphs[i]['y'] : summary_graphs[i]['y'];
            var site = {
                data: summary_graphs[i]['x'],
                label: summary_graphs[i]['legend'],
                backgroundColor: summary_graphs[i]['color'],
                borderColor: summary_graphs[i]['color'],
            };
            sites.push(site);
            if ($('#sensitivity_summary_graph_' + i).length) {
                new Chart($("#sensitivity_summary_graph_" + i), {
                    type: 'horizontalBar',
                    data: {
                        labels: lab,
                        datasets: sites
                    },
                    options: {
                        indexAxis: 'y',
                        elements: {
                            bar: {
                                borderWidth: 2,
                            }
                        },
                        responsive: true,
                        legend: {
                            display: true
                        },
                        scales: {
                            yAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: summary_graphs[i]['y_label']
                                }
                            }],
                            xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: summary_graphs[i]['x_label']
                                },

                            }]
                        },
                    },

                });
            }
        }
    }

    var sensitivity_detailed_graphs = '<?php echo json_encode($data['sensitivity']['detailed']['graphs'], true) ?>';
    var detailed_graphs = JSON.parse(sensitivity_detailed_graphs);
    if (Object.keys(detailed_graphs).length != 0) {
        var dynamicColors = function() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return "rgb(" + r + "," + g + "," + b + ")";
        };
        for (let i in detailed_graphs) {
            var sites = [];
            var lab = [];
            lab = ((detailed_graphs[i]['graph_type'] == "bar")) ? detailed_graphs[i]['x'] : detailed_graphs[i]['x'];
            var site = {
                data: detailed_graphs[i]['y'],
                label: detailed_graphs[i]['legend'],
                backgroundColor: detailed_graphs[i]['color'],
                borderColor: detailed_graphs[i]['color'],
            };
            sites.push(site);
            if ($('#sensitivity_detailed_graph_' + i).length) {
                new Chart($("#sensitivity_detailed_graph_" + i), {
                    type: 'horizontalBar',
                    data: {
                        labels: lab,
                        datasets: sites
                    },
                    options: {
                        indexAxis: 'x',
                        elements: {
                            bar: {
                                borderWidth: 2,
                            }
                        },
                        responsive: true,
                        legend: {
                            display: true
                        },
                        scales: {
                            yAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: detailed_graphs[i]['y_label']
                                }
                            }],
                            xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: detailed_graphs[i]['x_label']
                                },

                            }]
                        },
                    },

                });
            }
        }
    }

    function chabgeView(val) {
        if (val == 2) {
            $(".setview").removeClass("col-md-12");
            $(".setview").addClass("col-md-6");
        } else {
            $(".setview").removeClass("col-md-6");
            $(".setview").addClass("col-md-12");
        }
    }
</script>