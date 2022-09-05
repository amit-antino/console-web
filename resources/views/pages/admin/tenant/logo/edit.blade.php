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
        <li class="breadcrumb-item active" aria-current="page">Banner and Logo Images</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">{{ $tenant->name }} - Banner and Logo Images</h4>
    </div>
</div>
<form action="{{url('/admin/tenant/'.___encrypt($tenant->id).'/logo_image/'.___encrypt($tenant->id))}}" method="POST" role="tenant">
    <input type="hidden" name="_method" value="PUT">
    <div class="card-body">
        <div class="form-row">
            <div class="form-group col-md-12">
                <div class="card shadow">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col-md-4">
                                <h6>Upload main logo <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="File size should be less than 1 mb."></i></span></h6></h6>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="main_logo" id="main_logo">
                                    <label class="custom-file-label" for="main_logo">Upload Main Logo</label>
                                </div>
                                <div>&nbsp;</div>
                                <div class="card shadow" id="main_logo_remove">
                                    @if(!empty($main_logo))
                                    <img src="{{url($main_logo)}}" class="img-fluid card-img-top" style="height: 200px;" alt="">
                                    <button type="button" data-target="#main_logo_remove" data-url="{{url('/admin/tenant/'.___encrypt($tenant->id).'/logo_image/'.___encrypt($tenant->id).'?remove=main_logo')}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
                                        <i class="btn-icon-prepend" data-feather="trash"></i>
                                        Delete Image
                                    </button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h6>Upload auth banner image  <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="File size should be less than 1 mb."></i></span></h6>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="banner_image" id="banner_img">
                                    <label class="custom-file-label" for="banner_img">Upload auth banner image</label>
                                </div>
                                <div>&nbsp;</div>
                                <div class="card shadow" id="banner_image_remove">
                                    @if(!empty($banner_img))
                                    <img src="{{url($banner_img)}}" class="img-fluid card-img-top" style="height: 200px;" alt="">
                                    <button type="button" data-target="#banner_image_remove" data-url="{{url('/admin/tenant/'.___encrypt($tenant->id).'/logo_image/'.___encrypt($tenant->id).'?remove=banner_img')}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
                                        <i class="btn-icon-prepend" data-feather="trash"></i>
                                        Delete Image
                                    </button>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <h6>Upload auth logo image <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="File size should be less than 1 mb."></i></span></h6></h6>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="auth_logo" id="auth_logo">
                                    <label class="custom-file-label" for="auth_logo">Upload auth logo image</label>
                                </div>
                                <div>&nbsp;</div>
                                <div class="card shadow" id="auth_logo_remove">
                                    @if(!empty($auth_logo))
                                    <img src="{{url($auth_logo)}}" class="img-fluid card-img-top" style="height: 200px;" alt="">
                                    <button type="button" data-url="{{url('/admin/tenant/'.___encrypt($tenant->id).'/logo_image/'.___encrypt($tenant->id).'?remove=auth_logo')}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-target="#auth_logo_remove" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
                                        <i class="btn-icon-prepend" data-feather="trash"></i>
                                        Delete Image
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="tenant"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{url('/admin/tenant')}}" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
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
<script>
    function getData()
    {
        $.ajax({
        url: "{{url('/admin/tenant/'.___encrypt($tenant->id).'/logo_image/'.___encrypt($tenant->id).'?remove=auth_logo')}}",
        type: "GET",
        dataType: "JSON",
        processData: false,
        contentType: false,
        success: function ($response) {
           console.log($response);
        },
        });
    }
</script>
@push('custom-scripts')
<!--  -->
@endpush