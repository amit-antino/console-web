@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/product/chemical') }}">Products</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Generic Product : <b>{{$generic->name}}</b></li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card">
            <form method="POST" action="{{ url('/product/generic/'.___encrypt($generic->id)) }}" role="generics">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Edit Generic Product : {{$generic->name}}</h4>
                </div>
                <div class="card-body">
                    <input type="hidden" name="_method" value="PUT">
                    @CSRF
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label class="control-label">Generic Name <i data-toggle="tooltip" title="" data-original-title="Enter Generic Name. Should be single phrase. Can have multiple words. Example: Butanol." class="mdi mdi-information-outline"></i></label>
                            <input type="text" class="form-control" name="name" placeholder="Enter Generic Name" value="{{$generic->chemical_name}}">
                        </div>
                        <input type="hidden" value="{{___encrypt('2')}}" name="product_type_id">
                        <div class="form-group col-md-6">
                            <label for="category_id">Select Category
                                <span class="text-danger">*</span>
                                <i data-toggle="tooltip" title="Select Categoris. Select from dropdown" class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <select class="form-control" id="category_id" name="category_id">
                                <option value="">Select Category</option>
                                @if(!empty($categories))
                                @foreach($categories as $category)
                                <option {{ (___encrypt($generic->category_id) == ___encrypt($category->id)) ? "selected" : "" }} value="{{___encrypt($category->id)}}">{{$category->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="classification_id">Select Classification
                                <span class="text-danger">*</span>
                                <i data-toggle="tooltip" title="Select Classification" class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <select class="form-control" id="classification_id" name="classification_id">
                                @if(!empty($classifications))
                                @foreach($classifications as $classification)
                                <option {{ (___encrypt($generic->classification_id) == ___encrypt($classification->id)) ? "selected" : "" }} value="{{___encrypt($classification->id)}}">{{$classification->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="product_brand_name">Product Brand Name
                                <i data-toggle="tooltip" title="Enter Chemical Brand Name. You can enter maximum 20 values comma seperated. Example: Omeprazole." class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <input type="text" class="form-control" id="product_brand_name" name="product_brand_name" value="{{$generic->product_brand_name}}" placeholder="Enter Product Brand Name">
                        </div>
                        <!-- <div class="form-group col-md-6">
                            <label for="vendor_list">Select Vendors
                                <i data-toggle="tooltip" title="Select Suppliers and Vendors. You can select maximum 50 manufacturers from the dropdown." class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <select class="js-example-basic-multiple" id="vendor_list" name="vendor_list[]" multiple="multiple" placeholder="Select Vendors">
                                <option value="">Select Vendors</option>
                                @if(!empty($vendors))
                                @foreach($vendors as $vendor)
                                <option value="{{___encrypt($vendor->id)}}">{{$vendor->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div> -->
                        <div class="form-group col-md-6">
                            <label for="own_product">Own Product</label>
                            <select class="form-control" name="own_product" id="own_product">
                                <option value="">Own Product</option>
                                <option @if($generic->own_product=='1') selected="" @endif value="1">Yes</option>
                                <option @if($generic->own_product=='2') selected="" @endif value="2">No</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="other_name">Other Names
                                <i data-toggle="tooltip" title="Enter Other Names. You can enter maximum 200 values comma seperated" class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            @php
                            $other_name = implode(",",!empty($generic->other_name)?$generic->other_name:[]);
                            @endphp
                            <input type="text" value="{{$other_name}}" class="form-control" id="other_name" name="other_name" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tags">Tags
                                <i data-toggle="tooltip" title="Enter tags. You can enter maximum 16 values comma seperated" class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            @php
                            $tags = implode(",",!empty($generic->tags)?$generic->tags:[]);
                            @endphp
                            <input type="text" class="form-control" value="{{$tags}}" id="tags" name="tags" />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="image">Upload File
                                <i data-toggle="tooltip" title="upload_image. Maximum file size is 1 MB" class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="image" name="image">
                                <label class="custom-file-label" for="image">Choose File</label>
                            </div>
                            <img src="{{url($generic->image)}}" class="img-responsive " height="150" width="200" alt="">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="notes">Note
                                <i data-toggle="tooltip" title="Add Notes. You can enter maximum 500 words. " class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <textarea class="form-control" id="notes" name="notes" rows="5" placeholder="Enter Note">{{$generic->notes}}</textarea>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="generics"]' class="btn btn-sm btn-secondary submit">Update</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{ url('/product/chemical') }}" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
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
<script>
    $(function() {
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }

        if ($(".js-example-basic-multiple").length) {
            $(".js-example-basic-multiple").select2();
        }

        $('#other_name').tagsInput({
            'height': 'auto',
            'width': '100%',
            'interactive': true,
            'defaultText': 'Add Other Names',
            'placeholderColor': '#666666'
        });

        $('#tags').tagsInput({
            'height': 'auto',
            'width': '100%',
            'interactive': true,
            'defaultText': 'Add More Tags',
            'placeholderColor': '#666666'
        });
    });
</script>
@endpush