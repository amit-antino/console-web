@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/other_inputs/energy')}}">Energy and Utilities</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit <b>{{$energy_utility->energy_name}}</b> Energy & Utility</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{ url('/other_inputs/energy/'.___encrypt($energy_utility->id)) }}" method="POST" role="energy">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Edit Energy & Utility : {{$energy_utility->energy_name}}</h5>
                </div>
                <div class="card-body">
                    <input type="hidden" name="_method" value="PUT">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="energy_name">Enter Energy and Utility Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Energy and Utility Name"></i></span>
                            </label>
                            <input type="text" id="energy_name" name="energy_name" class="form-control" data-request="isalphanumeric" value="{{$energy_utility->energy_name}}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="base_unit_type">Select Base Unit Type
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Base Unit Type"></i></span>
                            </label>
                            <select id="base_unit_type" name="base_unit_type" class="js-example-basic-single" required>
                                <option value="">Select Base Unit Type</option>
                                @if(!empty($unit_types))
                                @foreach($unit_types as $unit_type)
                                <option @if(___encrypt($unit_type->id)==___encrypt($energy_utility->base_unit_type)) selected @endif value="{{ ___encrypt($unit_type->id)}}">{{$unit_type->unit_name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="vendor_id">Select Vendor
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Vendor"></i></span>
                            </label>
                            <select id="vendor_id" name="vendor_id" class="js-example-basic-single" required>
                                <option value="">Select Vendor / Supplier</option>
                                @if(!empty($vendors))
                                @foreach($vendors as $vendor)
                                <option @if(___encrypt($vendor->id)==___encrypt($energy_utility->vendor_id)) selected @endif value="{{ ___encrypt($vendor->id) }}">{{$vendor->name}}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="country_id">Enter Country Name
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Country Name"></i></span>
                            </label>
                            <input type="text" id="country_id" value="{{isset($energy_utility->country_id)?$energy_utility->country_id:''}}" name="country_id" class="form-control" placeholder="Enter Country Name">
                            <!-- <select id="country_id" name="country_id" data-url="{{url('state')}}" data-type="form" data-request="ajax-append-fields" data-target="#state_id" class="js-example-basic-single">
                                <option value="">Select Country</option>
                                @php
                                $country = \App\Models\Country::get();
                                @endphp
                                @if(!empty($country))
                                @foreach($country as $countries)
                                <option @if(___encrypt($countries->id)==___encrypt($energy_utility->country_id)) selected @endif value="{{___encrypt($countries->id)}}">{{$countries->name}}</option>
                                @endforeach
                                @endif
                            </select> -->
                        </div>
                        <div class="form-group col-md-6">
                            <label for="state_id">Enter State Name
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter State Name"></i></span>
                            </label>
                            <input type="text" id="state_id" value="{{isset($energy_utility->state)?$energy_utility->state:''}}" name="state" class="form-control" placeholder="Enter State Name">
                           
                        </div>
                        <div class="form-group col-md-6">
                            <label for="city_id">Enter District / City
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter District / City"></i></span>
                            </label>
                            <input type="text" id="city_id" value="{{isset($energy_utility->city)?$energy_utility->city:''}}" name="city" class="form-control" placeholder="Enter District / City">
                          
                        </div>
                        <div class="form-group col-md-12">
                            <label for="description">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Equipment Description"></i></span>
                            </label>
                            <textarea name="description" id="description" rows="5" class="form-control" data-request="isalphanumeric">{{$energy_utility->description}}</textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="tags">Tags
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Equipment Tags"></i></span>
                            </label>
                            @php
                            $tags = implode(",",!empty($energy_utility->tags)?$energy_utility->tags:[]);
                            @endphp
                            <input type="text" id="tags" name="tags" class="form-control" value="{{$tags}}">
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="energy"]' class="btn btn-sm btn-secondary submit">Submit</button>
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                    <a href="{{ url('/other_inputs/energy') }}" class="btn btn-sm btn-danger">Cancel</a>
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

    });
</script>
@endpush