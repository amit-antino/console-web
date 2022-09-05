<ul class="nav nav-tabs nav-tabs-line" id=" myTab" role="tablist">
    @if(!empty($data['keyresults']['summary']))
    <li class="nav-item">
        <a class="nav-link active font-weight-normal text-uppercase" id="summary-tab" data-toggle="tab" href="#summary" role="tab" aria-controls="summary" aria-selected="true">Summary</a>
    </li>
    @endif
    @if(!empty($data['keyresults']['detailed']))
    <li class="nav-item">
        <a class="nav-link font-weight-normal text-uppercase {{!empty($data['keyresults']['summary'])?'':'active'}}" id="detailed-tab" data-toggle="tab" href="#detailed" role="tab" aria-controls="detailed" aria-selected="false">Detailed</a>
    </li>
    @endif
</ul>
<div class="tab-content mt-3" id="myTabContent">
    <div class="tab-pane fade {{!empty($data['keyresults']['summary'])?'show active':''}} " id="summary" role="tabpanel" aria-labelledby="summary-tab">
        <div class="row">
            <div class="col-md-12 mb-3">
                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div>
                        <h6 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Master Outcomes</h6>
                    </div>
                </div>
                <div class="">
                    <div class="table-responsive">
                        <table id="key_result_outcome" class="table">
                            <thead>
                                <th>Outcome Name</th>
                                <th>Value </th>
                            </thead>
                            <tbody class="font-weight-normal">
                                @if(!empty($data['keyresults']['summary']))
                                @foreach($data['keyresults']['summary'] as $master_outcomes)
                                <tr>
                                    <td>{{$master_outcomes['outcome_name']}}</td>
                                    <td>
                                        {{number_format((float)$master_outcomes['value'], 3, '.', '')}}
                                        {{(!empty($master_outcomes['unit_constant_name']))?$master_outcomes['unit_constant_name']['unit_constant']['unit_name']:'-'}}
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
    @if(!empty($data['keyresults']['detailed']))
    <div class="tab-pane fade {{!empty($data['keyresults']['summary'])?'':'show active'}}" id="detailed" role="tabpanel" aria-labelledby="detailed-tab">
        <div class="">
            <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                <div>
                    <h6 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Unit Outcomes</h6>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($data['keyresults']['detailed'] as $experiment_unit_outcomes)
            @if(!empty($experiment_unit_outcomes['outcomes']))
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-header">
                        <h6 class="text-uppercase font-weight-normal">Experiment Unit Name:
                            {{str_replace("_", " ", $experiment_unit_outcomes['experiment_unit_name'])}}
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="process_experiment_reports" class="table table-hover mb-0">
                                <thead>
                                    <th>Experimental Outcome</th>
                                    <th>Value</th>
                                </thead>
                                <tbody>
                                    @foreach($experiment_unit_outcomes['outcomes'] as
                                    $outcomes)
                                    <tr>
                                        <td class="">{{$outcomes['outcome_name']}}</td>
                                        <td>{{number_format((float)$outcomes['value'], 3, '.', '')}} {{$outcomes['unit_constant_name']}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
        <hr>
        <div class="row">
            @if(!empty($data['keyresults']['key_graph_line']))
            @foreach($data['keyresults']['key_graph_line'] as $gk=>$gv)
            <div class="col-md-6 setview" id="key_{{$gk}}">
            </div>
            @endforeach
            @endif
        </div>
    </div>
</div>
@endif
</div>
<script src="{{ asset('assets/plugins/ploty/ploty.min.js')}}"></script>
<script>
    var objline = '<?php echo json_encode($data['keyresults']['key_graph_line']) ?>';
    var plotyObject = JSON.parse(objline);
    var objlayout = '<?php echo json_encode($data['keyresults']['layout']) ?>';
    var layoutObject = JSON.parse(objlayout);   
    var x = [];


    var sites = [];
    var layouts = [];

    var dynamicColors = function() {
        var r = Math.floor(Math.random() * 255);
        var g = Math.floor(Math.random() * 255);
        var b = Math.floor(Math.random() * 255);
        return "rgb(" + r + "," + g + "," + b + ")";
    };
    var cnt = 0;
    for (let ii in plotyObject) {

        var sites = [];
        var layarr = [];

        for (let j in plotyObject[ii]) {
            var trace = {
                x: plotyObject[ii][j]['x'],
                y: plotyObject[ii][j]['y'],
                type: plotyObject[ii][j]['type'],
                showlegend: true,
                mode: plotyObject[ii][j]['mode'],
                name: plotyObject[ii][j]['name'],
                // marker: {
                //     color: plotyObject[ii][j]['line']['color'],
                //     dash:  plotyObject[ii][j]['line']['dash'],
                //     size: 5,
                //     fillmode: "overlay",
                //     solidity: 0.2
                // },
                line: {
                    dash: plotyObject[ii][j]['line']['dash'],
                    width: 4,
                    color: plotyObject[ii][j]['line']['color'],
                }
            };
            sites.push(trace);
            var layout = {
                size: 12,
                symbol: 'circle',
                fillmode: "overlay",
                solidity: 0.2,
                title: "#" + (parseInt(ii) + 1) + " " + layoutObject[ii]['title']['text'].replaceAll('_', ' '),
                xaxis: {
                    title: layoutObject[ii]['xaxis']['title']['text']
                },
                yaxis: {
                    title: layoutObject[ii]['yaxis']['title']['text']
                },
                showlegend: true,
                legend: {
                    "orientation": "h",
                    "x": "1",
                    "xanchor": "right",
                    "y": "1.02",
                    "yanchor": "bottom"
                }
            }
            var config = {
                scrollZoom: true,
                displaylogo: false
            }
            Plotly.newPlot("key_" + ii, sites, layout, config);
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
