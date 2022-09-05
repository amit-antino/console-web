@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">S4 HANA Cloud Connect</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">S4 HANA Cloud Connect</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <button type="button" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" data-toggle="modal" data-target="#exampleModal">
            <i class="btn-icon-prepend" data-feather="cpu"></i>
            Connect with S4 HANA
        </button>

        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <a href="{{ url('/sap/cloud_connect/showdata') }}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
                <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                View Data
            </a>
        </div>
        <button type="button" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
            <i class="btn-icon-prepend" data-feather="download-cloud"></i>
            Import CSV
        </button>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="product_list" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                                <th>Chemical / Material Name</th>
                                <th>CAS Number</th>
                                <th>Object ID</th>
                                <th>Supplier</th>
                                <th>Tags</th>
                                <th>Data Availability</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="checkbox" name="select_all"></td>
                                <td>Sodium Hydroxide</td>
                                <td>123-2345-23</td>
                                <td>SA218Q</td>
                                <td>BASF</td>
                                <td></td>
                                <td><span class="badge badge-secondary">Good</span></td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch15" checked>
                                        <label class="custom-control-label" for="customSwitch15"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{ url('/sap/cloud_connect/view') }}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="View Data">
                                                <i class="fas fa-eye text-secondary"></i>
                                            </a>
                                            <a href="#" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Import into Database">
                                                <i class="fas fa-cloud-download-alt text-secondary "></i>
                                            </a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="select_all"></td>
                                <td>Sodium Chloride</td>
                                <td>123-2345-24</td>
                                <td>SA218Q</td>
                                <td>SABIC</td>
                                <td></td>
                                <td><span class="badge badge-success">Excellent</span></td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch15" checked>
                                        <label class="custom-control-label" for="customSwitch15"></label>
                                    </div>
                                </td>
                                <td class="text-center">


                                    <div class="btn-group btn-group-sm" role="group">
                                        
                                            <a href="{{ url('/sap/cloud_connect/view') }}" class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="View Data">
                                                <i class="fas fa-eye text-secondary"></i>
                                            </a>
                                            <a href="#" class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="Import into Database">
                                                <i class="fas fa-cloud-download-alt  text-secondary"></i> 
                                            </a>
                                    </div>

                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="select_all"></td>
                                <td>Hydrochoric Acid</td>
                                <td>123-2345-25</td>
                                <td>SA218Q</td>
                                <td>DSM</td>
                                <td></td>
                                <td><span class="badge badge-success">Excellent</span></td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch15" checked>
                                        <label class="custom-control-label" for="customSwitch15"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cogs fa-sm"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                            <a href="{{ url('/sap/cloud_connect/view') }}" class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="View Data">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="#" class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="Import into Database">
                                                <i class="fas fa-cloud-download-alt "></i> Import into Database
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="select_all"></td>
                                <td>Sulphuric Acid</td>
                                <td>123-2345-26</td>
                                <td>SA218Q</td>
                                <td>OERLIKON</td>
                                <td></td>
                                <td><span class="badge badge-success">Excellent</span></td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch15" checked>
                                        <label class="custom-control-label" for="customSwitch15"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cogs fa-sm"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                            <a href="{{ url('/sap/cloud_connect/view') }}" class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="View Data">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="#" class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="Import into Database">
                                                <i class="fas fa-cloud-download-alt "></i> Import into Database
                                            </a>


                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="select_all"></td>
                                <td>Propane</td>
                                <td>123-2345-27</td>
                                <td>SA218Q</td>
                                <td>BASF</td>
                                <td></td>
                                <td><span class="badge badge-secondary">Good</span></td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch15" checked>
                                        <label class="custom-control-label" for="customSwitch15"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cogs fa-sm"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                            <a href="{{ url('/sap/cloud_connect/view') }}" class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="View Data">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="#" class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="Import into Database">
                                                <i class="fas fa-cloud-download-alt "></i> Import into Database
                                            </a>


                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="select_all"></td>
                                <td>Ethane</td>
                                <td>123-2345-28</td>
                                <td>SA218Q</td>
                                <td>SABIC</td>
                                <td></td>
                                <td><span class="badge badge-success">Excellent</span></td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch15" checked>
                                        <label class="custom-control-label" for="customSwitch15"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cogs fa-sm"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                            <a href="{{ url('/sap/cloud_connect/view') }}" class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="View Data">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="#" class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="Import into Database">
                                                <i class="fas fa-cloud-download-alt "></i> Import into Database
                                            </a>


                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="select_all"></td>
                                <td>Ethanol</td>
                                <td>123-2345-29</td>
                                <td>SA218Q</td>
                                <td>DSM</td>
                                <td></td>
                                <td><span class="badge badge-info">Fair</span></td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch15" checked>
                                        <label class="custom-control-label" for="customSwitch15"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cogs fa-sm"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                            <a href="{{ url('/sap/cloud_connect/view') }}" class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="View Data">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="#" class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="Import into Database">
                                                <i class="fas fa-cloud-download-alt "></i> Import into Database
                                            </a>


                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="select_all"></td>
                                <td>Propanol</td>
                                <td>123-2345-30</td>
                                <td>SA218Q</td>
                                <td>OERLIKON</td>
                                <td></td>
                                <td><span class="badge badge-light">Low</span></td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch15">
                                        <label class="custom-control-label" for="customSwitch15"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cogs fa-sm"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                            <a href="{{ url('/sap/cloud_connect/view') }}" class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="View Data">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="#" class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="Import into Database">
                                                <i class="fas fa-cloud-download-alt "></i> Import into Database
                                            </a>


                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="select_all"></td>
                                <td>Sodium Chloride</td>
                                <td>123-2345-31</td>
                                <td>SA218Q</td>
                                <td>OERLIKON</td>
                                <td></td>
                                <td><span class="badge badge-danger">Very Low</span></td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch15">
                                        <label class="custom-control-label" for="customSwitch15"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cogs fa-sm"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                            <a href="{{ url('/sap/cloud_connect/view') }}" class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="View Data">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="#" class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="Import into Database">
                                                <i class="fas fa-cloud-download-alt "></i> Import into Database
                                            </a>


                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="select_all"></td>
                                <td>Toluene</td>
                                <td>123-2345-32</td>
                                <td>SA218Q</td>
                                <td>SABIC</td>
                                <td></td>
                                <td><span class="badge badge-danger">Very Low</span></td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch15">
                                        <label class="custom-control-label" for="customSwitch15"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button id="btnGroupDrop1" type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cogs fa-sm"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">

                                            <a href="{{ url('/sap/cloud_connect/view') }}" class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="View Data">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="#" class="dropdown-item" data-toggle="tooltip" data-placement="bottom" title="Import into Database">
                                                <i class="fas fa-cloud-download-alt "></i> Import into Database
                                            </a>


                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Connect S4 HANA</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="connection_url">Connection URL
                            <span class="text-danger">*</span>
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Connection URL"></i></span>
                        </label>
                        <input type="text" class="form-control form-sontrol-sm" name="connection_url" id="connection_url" value="https://sandbox.api.sap.com/s4hanacloud/sap/opu/odata/sap/API_MATERIAL_STOCK_SRV/A_MaterialStock">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="api_key">API Key
                            <span class="text-danger">*</span>
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="API Key"></i></span>
                        </label>
                        <input type="text" class="form-control form-sontrol-sm" name="api_key" id="api_key" value="zHuLOdpGLCocHTGAxbteTnCxoKFRAZLe">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="simreka_key">Simreka Key
                            <span class="text-danger">*</span>
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Simreka Key"></i></span>
                        </label>
                        <input type="text" class="form-control form-sontrol-sm" name="simreka_key" id="simreka_key" value="2184Q18">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="gets4hana" class="btn btn-secondary">Connect Now</button>
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
<script>
    $(function() {
        $('#product_list').DataTable();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '#gets4hana', function(e) {
            e.preventDefault();
            $('#psdatasourcSpinner').show();
            var connurl = $("#connection_url").val();
            var api_key = $("#api_key").val();
            var simreka_key = $("#simreka_key").val();
            $.ajax({
                type: 'POST',
                url: '/sap/cloud_connect/',
                data: {
                    connurl: connurl,
                    api_key: api_key,
                    simreka_key: simreka_key
                },
                success: function(data) {
                    alert(data);
                    location.href = "/sap/cloud_connect";
                    return false;
                }
            });
            return false;
        });
    });
</script>
@endpush