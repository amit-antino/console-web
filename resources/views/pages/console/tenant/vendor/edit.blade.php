@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/organization/vendor">Vendors</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Vendor</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">

            <div class="card-header">
                <h4 class="mb-3 mb-md-0">Edit Vendor</h4>
            </div>
            <div class="card-body">
                <form action="{{url('/organization/vendor/'.___encrypt($vendor->id))}}" method="POST" role="vendor" enctype="multipart/form-data">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <h5 class="text-center mb-3 mb-md-0">Basic Information</h5>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="name">Vendor Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Vendor Name"></i></span>
                            </label>
                            <input type="text" value="{{$vendor->name}}" name="name" class="form-control" data-request="isalphanumeric" id="name" placeholder="Enter Vendor Name" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="vendor_category">Select Vendor Category
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Vendor Category"></i></span>
                            </label>
                            <select id="vendor_category" name="vendor_category" class="form-control" required>
                                <option value="">Select Vendor Category</option>
                                @if(!empty($VendorCategory))
                                @foreach($VendorCategory as $catval)
                                <option @if(___encrypt($vendor->category_id)==___encrypt($catval->id)) selected="" @endif value="{{___encrypt($catval->id)}}">{{$catval->name}}</option>
                                @endforeach
                                @endif
                            </select>
                            @if(count($VendorCategory) === 0)
                            <label for="">
                                <span class="text-danger">Please Add Vendor Category </span></label>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="vendor_classification">Select Vendor Classification
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Vendor Classification"></i></span>
                            </label>
                            <select required id="vendor_classification" name="vendor_classification" class="form-control">
                                <option value="">Select Vendor Classification</option>
                                @if(!empty($VendorClassification))
                                @foreach($VendorClassification as $clasval)
                                <option @if(___encrypt($vendor->classificaton_id)==___encrypt($clasval->id)) selected="" @endif value="{{___encrypt($clasval->id)}}">{{$clasval->name}}</option>
                                @endforeach
                                @endif
                            </select>
                            @if(count($VendorClassification) === 0)
                            <label for="">
                                <span class="text-danger">Please Add Vendor Classification</span></label>
                            @endif
                        </div>
                        <div for="start_date" class="form-group col-md-6">
                            <label>Start Date
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Start Date"></i></span>
                            </label>
                            <input type="date" value="{{$vendor->start_date}}" id="start_date" name="start_date" class="form-control">
                        </div>
                    </div>
                    <h5 class="text-center mb-3 mb-md-0">Registered Address Details</h5>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="address">Address
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Add Address"></i></span>
                            </label>
                            <textarea id="address" name="address" class="form-control" rows="5" placeholder="Address">{{$vendor->address}}</textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="country_id">Enter Country Name
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Country Name"></i></span>
                            </label>
                            <input type="text" id="country_id" value="{{isset($vendor->country_id)?$vendor->country_id:''}}" name="country_id" class="form-control" placeholder="Enter Country Name">
                          
                        </div>
                        <div class="form-group col-md-6">
                            <label for="state_id">Enter State Name
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter State Name"></i></span>
                            </label>
                            <input type="text" id="state_id" value="{{isset($vendor->state)?$vendor->state:''}}" name="state" class="form-control" placeholder="Enter State Name">
                           
                        </div>
                        <div class="form-group col-md-6">
                            <label for="city_id">Enter District / City
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter District / City"></i></span>
                            </label>
                            <input type="text" id="city_id" value="{{isset($vendor->city)?$vendor->city:''}}" name="city" class="form-control" placeholder="Enter District / City">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="pincode">Pincode / ZipCode
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Pincode / ZipCode"></i></span>
                            </label>
                            <input type="text" name="pincode" id="pincode" class="form-control" value="{{$vendor->pincode}}" placeholder="Enter Pincode / ZipCode">
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
                            <img src="{{$vendor->logo}}" height="100" width="100">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tags">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Tags"></i></span>
                            </label>
                            <input type="text" value="{{$vendor->tags}}" id="tags" class="form-control" name="tags" placeholder="Enter Tags">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Add Description"></i></span>
                            </label>
                            <textarea id="description" name="description" class="form-control" data-request="isalphanumeric" maxlength="10000" rows="5" placeholder="Description">{{$vendor->description}}</textarea>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="vendor"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="/organization/vendor" class="btn btn-danger btn-sm">Cancel</a>
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