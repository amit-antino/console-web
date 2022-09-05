@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('organization/settings')}}">Organization</a></li>
        <li class="breadcrumb-item"><a href="{{url('organization/'.___encrypt($tenant->id).'/user_management')}}">User Management</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add User</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('organization/'.___encrypt($tenant->id).'/user_management')}}" method="POST" role="user">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Add User</h4>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="first_name">First Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="First Name"></i></span>
                            </label>
                            <input type="text" name="first_name" class="form-control" placeholder="First Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="last_name">Last Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Last Name"></i></span>
                            </label>
                            <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Email Address
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Email Address"></i></span>
                            </label>
                            <input type="email" oninput="this.value = this.value.toLowerCase()" name="email" class="form-control" placeholder="Email Address" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="mobile_number">Mobile Number
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Mobile Number"></i></span>
                            </label>
                            <input type="number" name="mobile_number" class="form-control" placeholder="Mobile Number">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="profile_image">Upload Profile Picture
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Upload Profile Picture"></i></span>
                            </label>
                            <div class="input-group input-group-sm mb-3">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="profile_image" name="profile_image" aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="profile_image">Upload Profile Picture</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="users">Select Designation
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
                        </div>
                        <div class="form-group col-md-6" style="display: none;">
                            <label for="users">Select Users Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select users type"></i></span>
                            </label>
                            <select data-width="100%" class="form-control js-example-basic-single" name="users_type" id="users_type"  required>
                              
                                <option value="console">Console User</option>
                            </select>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="user"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{url('organization/'.___encrypt($tenant->id).'/user_management')}}" class="btn btn-sm btn-danger">Cancel</a>
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