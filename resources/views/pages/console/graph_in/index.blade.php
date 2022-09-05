@extends('layout.console.master')

@push('plugin-styles')
    <link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Processing</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">Data Processing</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            {{-- <a href="javascript:void(0);" data-request="ajax-append-list" data-url="{{url('graph-in')}}" data-target="#tole_list_new" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="bottom" title="Refresh">
            <i class="btn-icon-prepend" data-feather="refresh-ccw"></i>
        </a> --}}
            <a href="javascript:void(0);" data-request="ajax-append-list" data-url="{{ url('graph-in') }}"
                data-target="#tole_list_new" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="bottom"
                title="Refresh">
                <i class="fa fa-redo fa-spin" style="display:none" id="loading_spin"></i>
                <i class="fa fa-redo" id="loading_no_spin"></i>
            </a>
            <a href="{{ url('graph-in/create') }}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
                <i class="btn-icon-prepend" data-feather="plus"></i>
                Add Tolerance Value
            </a>

        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-xl-12 stretch-card">
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">

                        <table id="tole_list" class="table table-hover mb-0">

                            <thead>
                                <tr>
                                    <!-- <th><input type="checkbox" id="example-select-all"></th> -->
                                    <th>Tolerance Value</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <div class="text-center">
                                <div id="loading_set" class="spinner-border text-secondary"
                                    style="width: 2rem; height: 2rem;display: none; margin-top:25px;">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <tbody id="tole_list_new">
                                @if (!empty($tolerances))
                                    @foreach ($tolerances as $tolerance)
                                        <tr>
                                            <!-- <td><input type="checkbox" value="{{ ___encrypt($tolerance->id) }}" class="checkSingle" name="select_all[]"></td> -->
                                            <td>{{ $tolerance->tolerance_value }}</td>

                                            <td class="text-center">
                                                @if ($tolerance->status == 'success')
                                                    <i class="fas fa-check-circle text-success" data-toggle="tooltip"
                                                        data-placement="bottom" title="Success"></i>
                                                @elseif($tolerance->status == 'failure')
                                                    <i class="fas fa-times-circle text-danger" data-toggle="tooltip"
                                                        data-placement="bottom" title="Failed"></i>
                                                @else
                                                    <i class="fas fa-sync-alt text-warning" data-toggle="tooltip"
                                                        data-placement="bottom" title="Processing"></i>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">
                                                    @if ($tolerance->status == 'success')
                                                        <a href="{{ url('/graph-in/' . ___encrypt($tolerance->id)) }}"
                                                            class="btn btn-icon" data-toggle=" tooltip"
                                                            data-placement="bottom" title="edit">
                                                            <i class="fas fa-eye text-secondary"></i>
                                                        </a>
                                                    @elseif($tolerance->status=='failure')
                                                        <a type="button" href="javascript:void(0);"
                                                            data-url="{{ url('/graph-in/' . ___encrypt($tolerance->id) . '/retry') }}"
                                                            data-method="POST" data-request="ajax-confirm"
                                                            data-ask_image="warning"
                                                            data-ask="Are you sure you want to retry?" type="button"
                                                            class="btn btn-icon" data-toggle="tooltip"
                                                            data-placement="bottom" title="Try Again">
                                                            <i class="fas fa-redo text-secondary"></i>
                                                        </a>
                                                    @endif
                                                    <a href="javascript:void(0);"
                                                        data-url="{{ url('/graph-in/' . ___encrypt($tolerance->id)) }}"
                                                        data-method="DELETE" data-request="ajax-confirm"
                                                        data-ask_image="warning" data-ask="Are you sure you want to delete?"
                                                        type="button" class="btn btn-icon" data-toggle="tooltip"
                                                        data-placement="bottom" title="Delete Data">
                                                        <i class="fas fa-trash text-secondary"></i>
                                                    </a>
                                                </div>
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
@endsection

@push('plugin-scripts')
    <script src="{{ asset('/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('/assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
    {{-- <script src="https://kit.fontawesome.com/c222dd3c0d.js" crossorigin="anonymous"></script> --}}
@endpush

@push('custom-scripts')
    <script>
        // $('#tole_list').DataTable({
        //     "iDisplayLength": 100
        // });
    </script>
@endpush
