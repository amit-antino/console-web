@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/sap/cloud_connect/') }}">S4 HANA Cloud Connect</a></li>
        <li class="breadcrumb-item active">Chemical / Material Details</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Chemical / Material Details</h4>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="product_name">Chemical / Material Name
                            <span class="text-danger">*</span>
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Chemical / Material Name"></i></span>
                        </label>
                        <input type="text" class="form-control form-sontrol-sm" name="product_name" id="product_name" value="ABC Chemical" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="cas_number">CAS Number
                            <span class="text-danger">*</span>
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="CAS Number"></i></span>
                        </label>
                        <input type="text" class="form-control form-sontrol-sm" name="cas_number" id="cas_number" value="123-12-112" readonly>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="supplier_name">Supplier Name
                            <span class="text-danger">*</span>
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Supplier Name"></i></span>
                        </label>
                        <input type="text" class="form-control form-sontrol-sm" name="supplier_name" id="supplier_name" value="Acme Inc" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card shadow">
                            <div class="card-header text-center">
                                <h5 class="mb-3 mb-md-0">Reach Compliance</h4>
                            </div>
                            <div class="card-body text-center">
                                <img src="{{ asset('assets/images/reach_compliance.png') }}" class="card-img-top" style="width: 150px;" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow">
                            <div class="card-header text-center">
                                <h5 class="mb-3 mb-md-0">Sustainability Index Score</h4>
                            </div>
                            <div class="card-body text-center">
                                <div id="preview-textfield"></div>
                                <canvas id="demo"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card shadow">
                            <div class="card-header text-center">
                                <h5 class="mb-3 mb-md-0">Potential Alternatives</h4>
                            </div>
                            <div class="card-body"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script src="https://www.cssscript.com/demo/customizable-gauge-canvas/dist/gauge.js"></script>
<script type="text/javascript">
    var opts = {
        angle: -0.25,
        lineWidth: 0.2,
        radiusScale: 0.9,
        pointer: {
            length: 0.6,
            strokeWidth: 0.05,
            color: '#000000'
        },
        staticLabels: {
            font: "10px sans-serif",
            labels: [20, 40, 60, 80],
            fractionDigits: 0
        },
        staticZones: [{
                strokeStyle: "#009f00",
                min: 0,
                max: 20
            },
            {
                strokeStyle: "#437720",
                min: 20,
                max: 40
            },
            {
                strokeStyle: "#ff6500",
                min: 40,
                max: 60
            },
            {
                strokeStyle: "#ffa500",
                min: 60,
                max: 80
            },
            {
                strokeStyle: "#858585",
                min: 80,
                max: 100
            }
        ],
        limitMax: false,
        limitMin: false,
        highDpiSupport: true
    };
    var target = document.getElementById('demo'); // your canvas element
    var gauge = new Gauge(target).setOptions(opts); // create sexy gauge!
    document.getElementById("preview-textfield").className = "preview-textfield";
    gauge.setTextField(document.getElementById("preview-textfield"));
    gauge.maxValue = 100; // set max gauge value
    gauge.setMinValue(0); // set min value
    gauge.set(65); // set actual value
</script>
@endpush