@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/sap/cloud_connect/') }}">Home S4HANA</a></li>
        <li class="breadcrumb-item active">S4 HANA Cloud Data</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">S4 HANA Cloud Data List</h4>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="sapdata_list" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                @foreach($saparr[1] as $kk => $ttt)
                                <th>{{substr($kk,2,30)}}</th>
                                @endforeach
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($saparr as $ttt)
                            <tr>
                                @foreach($ttt as $tttt)
                                <td>{{$tttt}}</td>
                                @endforeach
                                <td class="text-center">
                                    <a href="{{ url('/sap/cloud_connect/view') }}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="View Data">
                                        <i class="fas fa-eye text-secondary"></i>
                                    </a>
                                    <a href="#" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Import into Database">
                                        <i class="fas fa-cloud-download-alt text-secondary"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
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
        $('#sapdata_list').DataTable();

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
                    simreka_key: simreka_key,
                    id: '1'
                },
                success: function(data) {
                    alert(data);
                }
            });
            return false;
        });
    });
</script>
@endpush