@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/tenant') }}">Tenants</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/tenant/manage/' . ___encrypt($tenant->id)) }}">{{ $tenant->name }}</a></li>
        <li class="breadcrumb-item active" aria-current="page"> Documentations</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">{{ $tenant->name }} - Documentations</h4>
    </div>
</div>
<form action="{{url('/admin/tenant/'.___encrypt($tenant->id).'/document_update/'.___encrypt($tenant->id))}}" method="POST" role="document_update">
    <input type="hidden" name="_method" value="PUT">
    <div class="card-body">
        <div class="form-group col-md-12">
            <div class="card shadow">
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <h6>Quick Start Guide Document</h6>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="quick_start_doc" id="quick_start_doc">
                                <label class="custom-file-label" for="quick_start_doc">Quick Start Guide Document</label>
                            </div>
                            @if(!empty($quick_start_doc))
                            <label><a href="{{url($quick_start_doc)}}"><span class="fa fa-download">Click Here For Download</span></a></label>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <h6>Experiment Guide Document</h6>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="experiment_doc" id="experiment_doc">
                                <label class="custom-file-label" for="experiment_doc">Experiment Guide Document</label>
                            </div>
                            @if(!empty($experiment_doc))
                            <label><a href="{{url($experiment_doc)}}"><span class="fa fa-download">Click Here For Download</span></a></label>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <h6>Report Guide Document</h6>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="report_doc" id="report_doc">
                                <label class="custom-file-label" for="report_doc">Report Guide Document</label>
                            </div>
                            @if(!empty($report_doc))
                            <label><a href="{{url($report_doc)}}"><span class="fa fa-download">Click Here For Download</span></a></label>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <h6>Benchmark Document</h6>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="benchmark_doc" id="benchmark_doc">
                                <label class="custom-file-label" for="benchmark_doc">Benchmark Document</label>
                            </div>
                            @if(!empty($benchmark_doc))
                            <label><a href="{{url($benchmark_doc)}}"><span class="fa fa-download">Click Here For Download</span></a></label>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="document_update"]' class="btn btn-sm btn-secondary submit">Submit</button>
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                    <a href="{{url('/admin/tenant')}}" class="btn btn-sm btn-danger">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
@endpush