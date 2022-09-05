@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">User Profile</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-3 stretch-card">
        <div class="card shadow">

            @if($user_info->profile_image)
            <img src="{{url($user_info->profile_image)}}" class="card-img-top" alt="">
            <button type="button" data-url="{{url('/organization/profile/'.Auth::user()->id.'?remove=logo')}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="trash"></i>
                Delete Image
            </button>
            @else
            <img src="{{url('assets/images/user_icon.png')}}" class="card-img-top" style="width:90%;margin-top:15px;margin-left:15px" alt="">
            @endif
            <form action="{{ url('/organization/profile') }}" method="POST" role="basic_info">
                <div class="card-body">
                    <h6 class="mt-2">Upload Profile Image</h6>
                    <div class="custom-file">
                        <input type="file" name="profile_image" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Upload Profile Image</label>
                    </div>
                </div>

        </div>
    </div>
    <div class="col-md-9 stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="secuirity-tab" data-toggle="tab" href="#secuirity" role="tab" aria-controls="secuirity" aria-selected="false">Security</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="preference-tab" data-toggle="tab" href="#preference" role="tab" aria-controls="preference" aria-selected="false">Preference</a>
                    </li>
                </ul>
                <div class="tab-content border border-top-0 p-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col-md-12 stretch-card">
                                <div class="card">
                                    <div class="card-body">
                                        <input type="hidden" name="role" value="basic_info">
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <label for="first_name">First Name
                                                    <span class="text-danger">*</span>
                                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="First Name"></i></span>
                                                </label>
                                                <input type="text" name="first_name" class="form-control" placeholder="First Name" value="{{$user_info->first_name}}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="last_name">Last Name
                                                    <span class="text-danger">*</span>
                                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Last Name"></i></span>
                                                </label>
                                                <input type="text" name="last_name" class="form-control" placeholder="Last Name" value="{{$user_info->last_name}}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="email">Email Address
                                                    <span class="text-danger">*</span>
                                                    @if($user_info->email_verified)
                                                    <span class="text-success"><i class="icon-sm" data-feather="user-check" data-toggle="tooltip" data-placement="top" title="Email Address is Verified"></i></span>
                                                    @else
                                                    <span class="text-danger"><i class="icon-sm" data-feather="user-x" data-toggle="tooltip" data-placement="top" title="Email Address is Not Verified"></i></span>
                                                    @endif
                                                </label>
                                                <input type="email" oninput="this.value = this.value.toLowerCase()" disabled class="form-control" placeholder="Email Address" value="{{$user_info->email}}">
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label for="mobile_number">Mobile Number
                                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Mobile Number"></i></span>
                                                </label>
                                                <input type="number" name="mobile_number" class="form-control" placeholder="Mobile Number" value="{{$user_info->mobile_number}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="basic_info"]' class="btn btn-sm btn-secondary submit">Submit</button>
                                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            {{Config::get('constants.message.loader_button_msg')}}
                                        </button>
                                        <a href="{{ url('/organization/profile') }}" class="btn btn-sm btn-danger">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="secuirity" role="tabpanel" aria-labelledby="secuirity-tab">
                        <form action="{{ url('/organization/profile') }}" method="POST" role="secuirity">
                            <div class="card">
                                <div class="card-body">
                                    <input type="hidden" name="role" value="secuirity">
                                    <div class="form-row">
                                        <input type="hidden" oninput="this.value = this.value.toLowerCase()" disabled class="form-control" placeholder="Email Address" value="{{$user_info->email}}">

                                        <div class="form-group col-md-6">
                                            <label for="old_password">Old Password
                                                <span class="text-danger">*</span>
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Old Password"></i></span>
                                            </label>
                                            <input type="password" name="old_password" class="form-control" placeholder="Old Password">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="password">New Password
                                                <span class="text-danger">*</span>
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="New Password"></i></span>
                                            </label>
                                            <input type="password" name="password" class="form-control" placeholder="New Password">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="confirm_password">Confirm Password
                                                <span class="text-danger">*</span>
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Confirm Password"></i></span>
                                            </label>
                                            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="secuirity"]' class="btn btn-sm btn-secondary submit">Submit</button>
                                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        {{Config::get('constants.message.loader_button_msg')}}
                                    </button>
                                    <a href="{{ url('/organization/profile') }}" class="btn btn-sm btn-danger">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    @php
                    $language = !empty($user_info->settings['language'])?$user_info->settings['language']:'';
                    $timezone_id = !empty($user_info->settings['timezone'])?$user_info->settings['timezone']:0;
                    $date_format = !empty($user_info->settings['date_format'])?$user_info->settings['date_format']:'';
                    $currency_type = !empty($user_info->settings['currency_type'])?$user_info->settings['currency_type']:'';
                    @endphp
                    <div class="tab-pane fade" id="preference" role="tabpanel" aria-labelledby="preference-tab">
                        <form action="{{ url('/organization/profile') }}" method="post" role="preference">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="language">Select Language
                                                <span class="text-danger">*</span>
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Language"></i></span>
                                            </label>
                                            <select class="form-control" name="language" id="language">
                                                <option value="">Select Language</option>
                                                <option @if('english'==$language) selected @endif value="english">English</option>
                                                <option @if('german'==$language) selected @endif value="german">German</option>
                                                <option @if('dutch'==$language) selected @endif value="dutch">Dutch</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="time_zone">Select Time Zone
                                                <span class="text-danger">*</span>
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Time Zone"></i></span>
                                            </label>
                                            <select class="form-control" name="time_zone" id="time_zone" placeholder="Select Time Zone">
                                                <option value="">Select Time Zone</option>
                                                @if(!empty($timezones))
                                                @foreach($timezones as $timezone)
                                                <option @if($timezone->id==$timezone_id) selected @endif value="{{___encrypt($timezone->id)}}">{{$timezone->time_zone}}</option>
                                                @endforeach
                                                @endif

                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="currency_type">Select Currency Type
                                                <span class="text-danger">*</span>
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Currency Type"></i></span>
                                            </label>
                                            <select class="form-control" name="currency_type" id="currency_type">
                                                <option value="">Select Currency Type</option>
                                                @if(!empty($countries))
                                                @foreach($countries as $country)
                                                <option @if($country->id==$currency_type) selected @endif value="{{___encrypt($country->id)}}">{{$country->currency}}</option>
                                                @endforeach
                                                @endif

                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="date_format">Select Date Format
                                                <span class="text-danger">*</span>
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Date Format"></i></span>
                                            </label>
                                            <select class="form-control" name="date_format" id="date_format">
                                                <option value="">Select Date Format</option>
                                                <option @if('dd-mm-yyyy'==$date_format) selected @endif value="dd-mm-yyyy">DD-MM-YYYY</option>
                                                <option @if('mm-dd-yyyy'==$date_format) selected @endif value="mm-dd-yyyy">MM-DD-YYYY</option>
                                                <option @if('yyyy-mm-dd'==$date_format) selected @endif value="yyyy-mm-dd">YYYY-MM-DD</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-right">
                                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="preference"]' class="btn btn-sm btn-secondary submit">Submit</button>
                                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        {{Config::get('constants.message.loader_button_msg')}}
                                    </button>
                                    <a href="{{ url('/organization/profile') }}" class="btn btn-sm btn-danger">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                        @include('pages.console.tenant.user.settings')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if($preference=='preference')
<div class="modal fade" id="modal_preference" tabindex="-1" role="dialog" aria-labelledby="modal_preferenceLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_preferenceLabel">Preference</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Please select your preference.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Update Manually</button>
                <form action="{{ url('/organization/profile/default_preference') }}" method="POST" role="default_preference">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="default_preference"]' class="btn btn-sm btn-secondary submit">Use Default</button>
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(function() {
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }
    });
    $(window).on('load', function() {
        $('#modal_preference').modal('show');
    });
</script>
@endpush