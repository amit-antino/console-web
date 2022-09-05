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
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant/'.$tenant_id.'/user_group')}}">User Group</a></li>
        <li class="breadcrumb-item active">Add User Group</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('admin/tenant/'.$tenant_id.'/user_group')}}" method="POST" role="dept">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Add User Group</h4>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="first_name">User Group Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="User Group"></i></span>
                            </label>
                            <input type="text" name="name" class="form-control" placeholder="User Group Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="users">Select Users
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select users"></i></span>
                            </label>
                            <select data-width="100%" class="form-control js-example-basic-multiple" name="users[]" id="users" multiple="multiple" required>
                                @if(!empty($users))
                                @foreach($users as $user)
                                <option value="{{___encrypt($user['id'])}}">{{$user['first_name']}} {{$user['last_name']}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <!-- <div class="form-group col-md-6">
                            <label for="users">Select Designation
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Designation"></i></span>
                            </label>
                            <select data-width="100%" class="form-control" name="designation" id="designation">
                                <option value="">Select Designation</option>
                                @if(!empty($designation))
                                @foreach($designation as $desig)
                                <option value="{{___encrypt($desig['id'])}}">{{$desig['name']}} </option>
                                @endforeach
                                @endif
                            </select>
                        </div> -->
                        <div class="form-group col-md-6">
                            <label for="description">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Add Description"></i></span>
                            </label>
                            <textarea id="description" name="description" class="form-control" maxlength="10000" rows="5" placeholder="Description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="dept"]' class="btn btn-sm btn-secondary submit">Submit</button>
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                    <a href="{{url('/admin/tenant/'.$tenant_id.'/user_group')}}" class="btn btn-danger btn-sm">Cancel</a>
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
<script>
    if ($(".js-example-basic-multiple").length) {
        $(".js-example-basic-multiple").select2();
    }
</script>
@endpush