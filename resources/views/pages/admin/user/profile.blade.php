@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/prismjs/prism.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Profile Setting</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-3 stretch-card">
        <div class="card shadow">
            @if(!empty($user_info->profile_image))
            <img src="{{url($user_info->profile_image)}}" class="card-img-top" alt="">
            <button type="button" data-url="{{url('admin/user/profile/'.Auth::user()->id.'?remove=logo')}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="trash"></i>
                Delete Image
            </button>
            @else
            <img src="{{url('assets/images/user_icon.png')}}" class="card-img-top" style="width:90%;margin-top:15px;margin-left:15px" alt="">
            @endif
            <form action="{{url('admin/user/profile')}}" method="POST" role="basic_info">
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
        <div class="card">
            <div class="card-header">
                <h4 class="mb-3 mb-md-0">Profile Setting</h4>
            </div>
            <div class="card-body">
                <div class="example">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="true">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="secuirity-tab" data-toggle="tab" href="#secuirity" role="tab" aria-controls="secuirity" aria-selected="false">Security</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" id="information-tab" data-toggle="tab" href="#information" role="tab" aria-controls="information" aria-selected="false">Information</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link " id="prefrence-tab" data-toggle="tab" href="#prefrence" role="tab" aria-controls="prefrence" aria-selected="false">Preference</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link " id="settings-tab" data-toggle="tab" href="#settings" role="tab" aria-controls="settings" aria-selected="false">Settings</a>
                        </li> -->
                    </ul>
                    <div class="tab-content border border-top-0 p-3" id="myTabContent">
                        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            @include('pages.admin.user.basic_info')
                        </div>
                        <div class="tab-pane fade" id="secuirity" role="tabpanel" aria-labelledby="secuirity-tab">
                            @include('pages.admin.user.secuirity')
                        </div>
                        <!-- <div class="tab-pane fade" id="information" role="tabpanel" aria-labelledby="information-tab">
                            <h6 class="mb-1">Information</h6>
                            @include('pages.admin.user.information')
                        </div> -->
                        <div class="tab-pane fade" id="prefrence" role="tabpanel" aria-labelledby="prefrence-tab">
                            @include('pages.admin.user.preference')
                        </div>
                        <!-- <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                            <h6 class="mb-1">Settings</h6>
                            @include('pages.admin.user.settings')
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/prismjs/prism.js') }}"></script>
<script src="{{ asset('assets/plugins/clipboard/clipboard.min.js') }}"></script>
@endpush