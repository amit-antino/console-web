@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/organization/vendor')}}">Vendors</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add Vendor</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <div class="card-header">
                <h4 class="mb-3 mb-md-0">Add Vendor</h4>
            </div>
            <div class="card-body">
                <form action="{{url('/organization/vendor')}}" method="POST" role="vendor" enctype="multipart/form-data">
                    @csrf
                    <h5 class="text-center mb-3 mb-md-0">Basic Information</h5>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Vendor Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Vendor Name"></i></span>
                            </label>
                            <input type="text" name="name" class="form-control" data-request="isalphanumeric" id="name" placeholder="Enter Vendor Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="category_id">Select Vendor Category
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Vendor Category"></i></span>
                            </label>
                            <select id="category_id" name="category_id" class="form-control" required>
                                <option value="">Select Vendor Category</option>
                                @if(!empty($categories))
                                @foreach($categories as $category)
                                <option value="{{___encrypt($category->id)}}">{{$category->name}}</option>
                                @endforeach
                                @endif
                            </select>
                            @if(count($categories) === 0)
                            <label for="">
                                <span class="text-danger">Please Add Vendor Category </span></label>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="classification_id">Select Vendor Classification
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Vendor Classification"></i></span>
                            </label>
                            <select required id="classification_id" name="classification_id" class="form-control">
                                <option value="">Select Vendor Classification</option>
                                @if(!empty($classifications))
                                @foreach($classifications as $classification)
                                <option value="{{___encrypt($classification->id)}}">{{$classification->name}}</option>
                                @endforeach
                                @endif
                            </select>
                            @if(count($classifications) === 0)
                            <label for="">
                                <span class="text-danger">Please Add Vendor Classification</span></label>
                            @endif
                        </div>
                        <div for="start_date" class="form-group col-md-6">
                            <label>Start Date
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Start Date"></i></span>
                            </label>
                            <input type="date" id="start_date" name="start_date" class="form-control">
                        </div>
                    </div>
                    <h5 class="text-center mb-3 mb-md-0">Registered Address Details</h5>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="address">Address
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Add Address"></i></span>
                            </label>
                            <textarea id="address" name="address" class="form-control" rows="5" placeholder="Address"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            @include('pages.location.country')
                        </div>
                        <div class="form-group col-md-6">
                            @include('pages.location.state')
                        </div>
                        <div class="form-group col-md-6">
                            @include('pages.location.city')
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pincode">Pincode / ZipCode
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Pincode / ZipCode"></i></span>
                            </label>
                            <input type="text" name="pincode" id="pincode" class="form-control" placeholder="Enter Pincode / ZipCode">
                        </div>
                    </div>
                    <h5 class="text-center mb-3 mb-md-0">General Information</h5>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="logo">Logo
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Add Logo"></i></span>
                            </label>
                            <input type="file" id="logo" name="logo" class="form-control-file">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tags">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Tags"></i></span>
                            </label>
                            <input type="text" id="tags" class="form-control" name="tags" placeholder="Enter Tags">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Add Description"></i></span>
                            </label>
                            <textarea id="description" name="description" class="form-control" data-request="isalphanumeric" maxlength="10000" rows="5" placeholder="Description"></textarea>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="vendor"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{url('/organization/vendor')}}" class="btn btn-danger btn-sm">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(function() {
        // Tags
        $('#tags').tagsInput({
            'interactive': true,
            'defaultText': 'Add More',
            'removeWithBackspace': true,
            'width': '100%',
            'height': 'auto',
            'placeholderColor': '#666666'
        });

        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }
    });
</script>
@endpush