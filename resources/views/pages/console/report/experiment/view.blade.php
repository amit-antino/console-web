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
                    <h4 class="mb-3 mb-md-0">Report Name: </h4>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="text-center">
                            <div id="expprofileSpinner1" class="spinner-border text-secondary" style="width: 2rem; height: 2rem;display: none; margin-top:25px;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
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
    function getCharts() {
        $("#setData").css("display", "none");
        $("#homeData").css("display", "");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/reports/experiment/chart',
            type: 'get',
            success: function(results) {
                object = JSON.parse(results);
                console.log(object['bublechart']);
                var dynamicColors = function() {
                    var r = Math.floor(Math.random() * 255);
                    var g = Math.floor(Math.random() * 255);
                    var b = Math.floor(Math.random() * 255);
                    return "rgb(" + r + "," + g + "," + b + ")";
                };
                var sites = [];
                for (var i = 0; i < object['bublechart'].length; i++) {
                    var site = {
                        label: object['bublechart'][i].labeldata,
                        backgroundColor: dynamicColors(),
                        borderColor: "rgb(69,70,72)",
                        radius: 10,
                        borderWidth: 1,
                        hoverBorderWidth: 2,
                        hoverRadius: 5,
                        data: [{
                            x: Number(object['bublechart'][i].x),
                            y: Number(object['bublechart'][i].y),
                            r: 15
                        }]
                    };
                    sites.push(site);
                }
                console.log(sites);
                if ($('#chartjsBubble').length) {
                    new Chart($('#chartjsBubble'), {
                        type: 'bubble',
                        data: {
                            labels: "Algae",
                            datasets: sites
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    scaleLabel: {
                                        display: true,
                                        labelString: "GHG"
                                    }
                                }],
                                xAxes: [{
                                    scaleLabel: {
                                        display: true,
                                        labelString: "Water Use"
                                    }
                                }]
                            }
                        }
                    });
                }
                let lableBar = [];
                let dataBar = [];
                obj = object['barchart'];
                for (i in obj) {
                    lableBar.push(obj[i].yarn);
                    dataBar.push(obj[i].price);
                }
                if ($('#chartjsBar').length) {
                    new Chart($("#chartjsBar"), {
                        type: 'bar',
                        data: {
                            labels: lableBar,
                            datasets: [{
                                label: "Product Price",
                                backgroundColor: dynamicColors,
                                data: dataBar
                            }]
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    scaleLabel: {
                                        display: false,
                                        labelString: "Price (EUR/Kg)"
                                    }
                                }],
                                xAxes: [{
                                    scaleLabel: {
                                        display: false,
                                        labelString: "GDP (PPP)"
                                    }
                                }]
                            }
                        }
                    });
                }
            }
        });
        $('#expprofileSpinner1').hide();
    }
</script>
@endpush