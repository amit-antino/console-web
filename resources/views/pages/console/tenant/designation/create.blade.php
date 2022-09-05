@extends('layout.console.master')
<!-- Begin Page Content -->
@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/@mdi/css/materialdesignicons.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('organization/')}}">Organization</a></li>
        <li class="breadcrumb-item"><a href="{{url('organization/'.$tenant_id.'/designation')}}">Designation</a></li>
        <li class="breadcrumb-item active">Add Designatiion</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('organization/'.$tenant_id.'/designation')}}" method="POST" role="designation">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Add Designation</h4>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="first_name">Designation Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Designation Name"></i></span>
                            </label>
                            <input type="text" name="name" class="form-control" placeholder="Designation Name" required>
                        </div>
                        <div class="form-group col-md-6">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Add Description"></i></span>
                            </label>
                            <textarea id="description" name="description" class="form-control" maxlength="10000" rows="5" placeholder="Description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="designation"]' class="btn btn-sm btn-secondary submit">Submit</button>
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                    <a href="" class="btn btn-danger btn-sm">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
@endpush
@push('custom-scripts')
<script src="{{ asset('assets/js/select2.js') }}"></script>
<script src="{{ asset('assets/js/tags-input.js') }}"></script>
@endpush