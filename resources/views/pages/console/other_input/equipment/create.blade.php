@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/other_inputs/equipment')}}">Equipments</a></li>
        <li class="breadcrumb-item active" aria-current="page">Add Equipment</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('/other_inputs/equipment')}}" role="equipment" method="POST">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Add a Equipment</h4>
                </div>
                <div class="card-body">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="equipment_name">Enter Equipment Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Equipment Name"></i></span>
                            </label>
                            <input type="text" id="equipment_name" name="equipment_name" class="form-control" data-request="isalphanumeric" placeholder="Enter Equipment Name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="installation_date">Installation Date
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Installation Date"></i></span>
                            </label>
                            <input type="date" id="installation_date" name="installation_date" class="form-control" placeholder="Installation Date">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="purchased_date">Purchased Date
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Purchased Date"></i></span>
                            </label>
                            <input type="date" id="purchased_date" name="purchased_date" class="form-control" placeholder="Purchased Date">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="vendor_id">Select Vendor / Supplier
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Vendor / Supplier"></i></span>
                            </label>
                            <select id="vendor_id" name="vendor_id" class="js-example-basic-single">
                                <option value="">Select Vendor / Supplier</option>
                                @if(!empty($vendors))
                                @foreach($vendors as $vendor)
                                <option value="{{ ___encrypt($vendor->id) }}">{{$vendor->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="availability">Select Availability
                                <span class="text-danger">*</span>
                                <i data-toggle="tooltip" title="Select Equipment Availability" class="icon-sm" data-feather="info" data-placement="top"></i>
                            </label>
                            <select class="form-control" id="availability" name="availability">
                                <option value="">Select Availability</option>
                                <option value="true">Yes</option>
                                <option value="false">No</option>
                            </select>
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
                            <label for="pincode">Pincode / Zip Code
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Pincode / Zip Code"></i></span>
                            </label>
                            <input type="number" id="pincode" name="pincode" class="form-control" placeholder="Pincode / Zip Code">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="equipment_image">Equipment Image
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Equipment Image"></i></span>
                            </label>
                            <div class="custom-file">
                                <input type="file" id="equipment_image" name="equipment_image" class="custom-file-input">
                                <label class="custom-file-label" for="equipment_image">Equipment Image</label>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Equipment Description"></i></span>
                            </label>
                            <textarea name="description" id="description" rows="5" class="form-control" data-request="isalphanumeric"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tags">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Equipment Tags"></i></span>
                            </label>
                            <input type="text" id="tags" name="tags" class="form-control" placeholder="Tags">
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="equipment"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="/other_inputs/equipment" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(function() {
        //Tags
        $('#tags').tagsInput({
            'height': 'auto',
            'width': '100%',
            'interactive': true,
            'defaultText': 'Add More',
            'removeWithBackspace': true,
            'minChars': 0,
            'maxChars': 20,
            'placeholderColor': '#666666'
        });
        //Multi Select
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }
    });
</script>
@endpush