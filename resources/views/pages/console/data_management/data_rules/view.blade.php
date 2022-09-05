@extends('layout.console.master')
@push('plugin-styles')
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/data_management/data_curation')}}">Data Management</a></li>
        <li class="breadcrumb-item active" aria-current="page">View Data Curation</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <div class="card-header">
                <h4 class="mb-3 mb-md-0">Data Curation - {{ucfirst($data_set->name)}}
                </h4>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach(json_decode($graph_data) as $count=>$data)
                    <div class="col-md-6" id='myDiv{{$count}}'>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/js/plotly-2.6.3.min.js') }}"></script>
<script>
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
            name: 'yaxis data',
            type: 'line',
            mode: 'lines',
            // type: 'bar'
        };
        var data2 = {
            x: x1_data,
            y: y1_data,
            // type: 'bar'
            name: 'yaxis2 data',
           // yaxis: 'y2',
            type: 'scatter',
            mode: 'lines+markers',
            backgroundColor: 'rgb(255, 99, 132)'
        };
        var layout = {
            // title: 'Double Y Axis Example',
            // yaxis: {
            //     title: 'yaxis title'
            // },
            // yaxis2: {
            //     title: 'yaxis2 title',
            //     titlefont: {
            //         color: 'rgb(148, 103, 189)'
            //     },
            //     tickfont: {
            //         color: 'rgb(148, 103, 189)'
            //     },
            //     overlaying: 'y',
            //     side: 'right'
            // }
        };
        var data = [data1, data2];
        Plotly.newPlot('myDiv' + i, data, layout);
    }
</script>
@endpush