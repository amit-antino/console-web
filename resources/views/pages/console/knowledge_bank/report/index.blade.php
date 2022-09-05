@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Knowledge Bank Report </li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Report</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="user_list" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" name="select_all" value="1" id="example-select-all"></th>
                                <th>Report Name</th>
                                <th>Process Name</th>
                                <th>Generated Date</th>
                                <th>Main Feedstock</th>
                                <th>Main Product</th>
                                <th>Report Type</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>

                                <td><input type="checkbox" name="select_all"></td>
                                <td>Glutamic acid calculation </td>
                                <td> Process 1 </td>
                                <td>2015-12-28 12:05:53</td>
                                <td> Test</td>
                                <td> Test</td>
                                <td>
                                    Report 1
                                </td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch15" checked>
                                        <label class="custom-control-label" for="customSwitch15"></label>
                                    </div>
                                </td>
                                <td> 
                                    <a href="#" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Copy">
                                            <i  class="fas fa-download text-secondary"></i>
                                        </a> &nbsp;
                                    <a href="#" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                            <i class="fas fa-trash text-secondary"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/promise-polyfill/polyfill.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    //$('#user_list').DataTable();
</script>
@endpush