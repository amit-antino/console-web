@extends('layout.admin.master')
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
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant/')}}">Tenants</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant/manage/'.$tenant_id)}}">{{get_tenant_name($tenant_id)}} Manage</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant/'.$tenant_id.'/calc_url')}}">Calculation Services</a></li>
        <li class="breadcrumb-item active">Add Calculation Services</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('/admin/tenant/'.$tenant_id.'/calc_url')}}" method="POST" role="designation">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Add Calculation Services</h4>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="first_name">Server Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Server Type"></i></span>
                            </label>
                            <select class="form-control" name="server_type">
                                <option value="">Select Server Type</option>
                                <option value="local">Local</option>
                                <option value="stag">Staging</option>
                                <option value="dev">Development</option>
                                <option value="prod">Production</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="first_name">Calculation Services Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Calculation Services Name"></i></span>
                            </label>
                            <input type="text" name="name" class="form-control" placeholder="Calculation Services Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="first_name">Calculation Services Version
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Calculation Services Version"></i></span>
                            </label>
                            <input type="text" name="version" class="form-control" placeholder="Calculation Services Version" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="first_name">Calculation Server Url
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Calculation Server Url"></i></span>
                            </label>
                            <input type="text" name="calc_url" class="form-control" placeholder="Calculation Server Url" required>
                        </div>
                        <div class="form-group col-md-6">
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
                    <a href="{{url('/admin/tenant/'.$tenant_id.'/calc_url')}}" class="btn btn-danger btn-sm">Cancel</a>
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
<script>
    $(function() {
        $('#tags').tagsInput({
            'height': '75%',
            'width': '100%',
            'interactive': true,
            'defaultText': 'Add More Tags',
            'placeholderColor': '#666666'
        });
    });
</script>
@endpush