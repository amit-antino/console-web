@extends('layout.console.master')
@push('plugin-styles')
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/data_management/data_curation')}}">Data Management / Data Curation</a></li>
        <li class="breadcrumb-item active" aria-current="page">View Data Curation</li>
    </ol>
</nav>


<div class="card">
    <div class="">
        <div class="card-header d-flex justify-content-between align-items-center mr-2">
            <div>
                <h5 class="mr-2 text-uppercase font-weight-normal">Data Curation - {{$data_curation->data_set_experiment_id}}</h5>
            </div>
            <!-- <div class="text-left">
                <div class="btn-group btn-group-sm" role="group" aria-label="...">
                    <button class="btn btn-sm btn-secondary" onclick="chabgeView(1)">
                        <i class="fas fa-grip-lines" aria-hidden="true"></i>
                    </button>
                    <button class="btn btn-sm btn-secondary" onclick="chabgeView(2)">
                        <i class="fas fa-grip-vertical" aria-hidden="true"></i>
                    </button>
                </div>
            </div> -->
        </div>
        <div class="test card-body grid-margin mr-3">
            <div class="row">
                @foreach(json_decode($graph_data) as $count=>$data)
                <div class="col-md-12 setview" id='myDiv{{$count}}'>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/js/plotly-2.6.3.min.js') }}"></script>
@endpush
@push('custom-scripts')
<script>
    // $(function() {
    var js_data = '<?php echo $graph_data; ?>';
    var js_obj_data = JSON.parse(js_data);
    console.log(js_obj_data);
    for (let i = 0; i < js_obj_data.length; i++) {
        var x_data = js_obj_data[i]['x'][0];
        var y_data = js_obj_data[i]['y'][0];
        var x1_data = js_obj_data[i]['x'][1];
        var y1_data = js_obj_data[i]['y'][1];

        var data1 = {
            x: x_data,
            y: y_data,
            name: js_obj_data[i]['legend'][0],
            type: 'line',
            mode: 'lines',
            // type: 'bar'
        };
        var data2 = {
            x: x1_data,
            y: y1_data,
            // type: 'bar'
            name: js_obj_data[i]['legend'][1],
            // yaxis: 'y2',
            type: 'scatter',
            mode: 'lines+markers',
            backgroundColor: 'rgb(255, 99, 132)'
        };
        var layout = {
            title: js_obj_data[i]['name'],
            yaxis: {
                title: js_obj_data[i]['y_label'],
            },
            xaxis: {
                title: js_obj_data[i]['x_label'],

            }
        };
        var data = [data1, data2];
        var config = {
            scrollZoom: true,
            displaylogo: false,

            modeBarButtonsToRemove: ['pan2d', 'select2d', 'lasso2d', 'resetScale2d', 'zoomOut2d'],

        }
        Plotly.newPlot('myDiv' + i, data, layout);
    }
    //user-select-none





    // });

    function chabgeView(val) {
        alert(val);
        if (val == 2) {
            $(".setview").removeClass("col-md-12");
            $(".setview").addClass("col-md-6");
        } else {
            $(".setview").removeClass("col-md-6");
            $(".setview").addClass("col-md-12");
            // $(".setview").addClass("text-center");

        }
    }
</script>
@endpush