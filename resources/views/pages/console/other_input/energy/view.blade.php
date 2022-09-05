@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/other_inputs/energy') }}">Energy and Utilities</a></li>
        <li class="breadcrumb-item active" aria-current="page">View Energy & Utility - {{$data['energy_name']}}</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap grid-margin">
                <div>
                    <h4 class="mb-3 mb-md-0">View Energy & Utility : {{$data['energy_name']}}</h4>
                </div>
                <div class="d-flex align-items-center flex-wrap text-nowrap">

                    <h5 class="mr-2">Status: <span class="badge badge-info">{{ucfirst($data['status'])}}</span></h5>
                    <a href="{{ url('/other_inputs/energy/'.___encrypt($data['energy_id']).'/edit') }}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" data-toggle="tooltip" data-placement="bottom" title="Edit Energy and Utility">
                        <i class="btn-icon-prepend" data-feather="edit"></i>
                        Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="energy_name">Energy and Utility Name
                            <span class="text-danger">*</span>
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Energy and Utility Name"></i></span>
                        </label>
                        <input type="text" class="form-control" name="" id="" readonly value="{{$data['energy_name']}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="base_unit_type">Selected Base Unit Type
                            <span class="text-danger">*</span>
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Base Unit Type"></i></span>
                        </label>
                        <input type="text" class="form-control" name="" id="" readonly value="{{$data['base_unit']}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="vendor_id">Selected Vendor / Supplier
                            <span class="text-danger">*</span>
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Vendor / Supplier"></i></span>
                        </label>
                        <input type="text" class="form-control" name="" id="" readonly value="{{$data['vendor']}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="country_id">Country
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Country"></i></span>
                        </label>
                        <input type="text" class="form-control" name="" id="" readonly value="{{$data['country']}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="state_id">State / Province
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select State / Province"></i></span>
                        </label>
                        <input type="text" class="form-control" name="" id="" readonly value="{{$data['state']}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="city_id">District / City
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select District / City"></i></span>
                        </label>
                        <input type="text" class="form-control" name="" id="" readonly value="{{$data['city']}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="city_id">Tags</label>
                        @if(!empty($data['tags']))
                        @foreach($data['tags'] as $tag)
                        <span class="badge badge-info">{{$tag}}</span>
                        @endforeach
                        @endif
                    </div>
                    <div class="form-group col-md-12">
                        <label for="description">Description
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Energy & Utility Description"></i></span>
                        </label>
                        <textarea name="description" id="description" rows="5" class="form-control" readonly>{{$data['description']}}</textarea>
                    </div>
                </div>
            </div>
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
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }
    });
</script>
@endpush