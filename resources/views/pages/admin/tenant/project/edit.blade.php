@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant')}}">Tenants</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant/manage/'.$tenant_id)}}">{{get_tenant_name($tenant_id)}} Manage</a></li>
        <li class="breadcrumb-item active" aria-current="page">Project Edit</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form method="POST" action="{{url('admin/tenant/'.$tenant_id.'/project/'.___encrypt($project->id))}}" role="project">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productModalLabel">Edit Project</h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                    </div>
                    <input type="hidden" name="_method" value="PUT">
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label class="control-label"> Name <span class="text-danger">*</span>
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Name"></i></span>
                                </label>
                                <input type="text" class="form-control" value="{{$project->name}}" name="name" placeholder="Enter Name" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="users">Select Users
                                    <span class="text-danger">*</span>
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select users"></i></span>
                                </label>
                                <select data-width="100%" class="js-example-basic-multiple" name="users[]" id="users" multiple="multiple" required>
                                    @if(!empty($users))
                                    @foreach($users as $user)
                                    <option @if(in_array($user['id'],$project->users)) selected @endif value="{{___encrypt($user['id'])}}">{{$user['first_name']}} {{$user['last_name']}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" rows="5" class="form-control">{{$project->description}}</textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tags">Tags
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter tags"></i></span>
                                </label>
                                <input type="text" id="tags" class="tags-style" value="{{$project->tags}}" class="form-control" data-request="isalphanumeric" name="tags" placeholder="Enter tags">
                            </div>
                            <div class="form-group col-md-12">
                                <label class="control-label"> Select Location
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Location"></i></span>
                                </label>
                                <select class="js-example-basic-single formcontrol" data-live-search="true" name="location" id="location" data-request="ajax-append-fields" data-target="#location_details" data-url="{{url('admin/tenant/'.$tenant_id.'/tenant_location_fetch')}}" >
                                    {{-- <option value="">Select Location</option> --}}
                                    @if(!empty($locations))
                                    @foreach($locations as $location)
                                    @php
                                    $location_id = !empty($project->location['location'])?$project->location['location']:'';
                                    @endphp
                                    <option @if($location_id==$location['id']) selected @endif value="{{___encrypt($location['id'])}}">{{$location['location_name']}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="row" id="location_details">
                                <div class="form-group col-md-6">
                                    <label class="control-label"> Enter Country Name
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Country Name"></i></span>
                                    </label>
                                    {{-- <select name="country" id="country" class="form-control">
                                        <option value="">Select Country</option>
                                        @if(!empty($countries))
                                        @foreach($countries as $country)
                                        @php
                                        $country_id = !empty($project->location['country'])?$project->location['country']:'';
                                        @endphp
                                        <option @if($country_id==$country->id) selected @endif value="{{___encrypt($country->id)}}">{{$country->name}}</option>
                                        @endforeach
                                        @endif
                                    </select> --}}
                                    <input type="text" class="form-control" value="{{$location['country_id']}}" name="state" placeholder="Enter country Name">

                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label"> Enter State Name
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter State Name"></i></span>
                                    </label>
                                    <input type="text" class="form-control" value="{{!empty($project->location['state'])?$project->location['state']:''}}" name="state" placeholder="Enter State Name" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label"> Enter City Name
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title=" Enter City Name"></i></span>
                                    </label>
                                    <input type="text" class="form-control" name="city" value="{{!empty($project->location['city'])?$project->location['city']:''}}" placeholder=" Enter City Name" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="control-label"> Enter Geo Coordinate
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Geo Coordinate"></i></span>
                                    </label>
                                    <input type="text" value="{{!empty($project->location['geo_cordinate'])?$project->location['geo_cordinate']:''}}" class="form-control" name="geo_cordinate" placeholder="Enter Geo Coordinate" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="project"]' class="btn btn-sm btn-secondary submit">
                            Submit
                        </button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{url('admin/tenant/'.$tenant_id.'/project')}}" class="btn btn-sm btn-danger">cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
@endpush

@push('custom-scripts')

<script>
    $('#tags').tagsInput({
        'interactive': true,
        'defaultText': 'Add More',
        'removeWithBackspace': true,
        'width': '100%',
        'height': '84px',
        'placeholderColor': '#666666'
    });

    if ($(".js-example-basic-multiple").length) {
        $(".js-example-basic-multiple").select2();
    }
</script>
@endpush
