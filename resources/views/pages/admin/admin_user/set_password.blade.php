@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/admin_users')}}">Admin Users</a></li>
        <li class="breadcrumb-item active" aria-current="page">Set New Password</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 stretch-card ">
        <div class="card shadow">
            <form action="{{url('/admin/admin_users/'.___encrypt($user_id).'/set-password')}}" method="POST" role="admin_users">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Set New Password</h4>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="email">New Password
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter New Password"></i></span>
                            </label>
                            <input type="password" name="password" class="form-control" placeholder="Enter New Password" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="mobile_number">Confirm Password
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Confirm Password"></i></span>
                            </label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="admin_users"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{url('/admin/admin_users/'.___encrypt($user_id))}}" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(function() {
        // Tags
        // $('#tags').tagsInput({
        //     'interactive': true,
        //     'defaultText': 'Add More',
        //     'removeWithBackspace': true,
        //     'minChars': 0,
        //     'maxChars': 20,
        //     'placeholderColor': '#666666'
        // });
        // Multi Select
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }
    });
</script>
@endpush