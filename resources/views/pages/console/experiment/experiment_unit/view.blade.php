@extends('layout.console.master')

@push('plugin-styles')
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/experiment/experiment_units') }}">Experiment Units</a></li>
        <li class="breadcrumb-item active" aria-current="page">View Experiment Unit - {{$response_data['name']}}</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap grid-margin">
                <div>
                    <h4 class="mb-3 mb-md-0">View Experiment Unit : {{$response_data['name']}}</h4>
                </div>
                <div class="d-flex align-items-center flex-wrap text-nowrap">

                    <h5 class="mr-2">Status: <span class="badge badge-info">{{ucfirst($response_data['status'])}}</span></h5>
                    <a href="{{ url('/experiment/experiment_units/'.___encrypt($response_data['id']).'/edit') }}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" data-toggle="tooltip" data-placement="bottom" title="Edit experiment unit">
                        <i class="btn-icon-prepend" data-feather="edit"></i>
                        Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="color_code">Selected Experiment Unit Image
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Selected Experiment Unit Image"></i></span>
                        </label>
                        @if($response_data['exp_equip_unit'])
                        <img src="{{asset($response_data['exp_equip_unit']['equip_unit_img_url'])}}" alt="" class="img-fluid">
                        @else
                        <img src="" alt="" class="img-fluid">
                        @endif
                    </div>
                    <div class="form-group col-md-9">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="exp_unit_name">Experiment Unit Name
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title=" Experiment Unit Name"></i></span>
                                </label>
                                <input type="text" class="form-control" id="exp_unit_name" name="exp_unit_name" value="{{$response_data['name']}}" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="streams">Streams and Flow Types
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Streams and Flow Types"></i></span>
                                </label>
                                <ul class="list-group">
                                    @if(!empty($response_data['streams']))
                                    @foreach($response_data['streams'] as $stream)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{$stream['stream_name']}}
                                        @if($stream['flow_type'] == "input")
                                        <p>
                                            {{Str::upper($stream['flow_type'])}}
                                            <span class="badge badge-info"><i class="fas fa-arrow-circle-down" data-toggle="tooltip" data-placement="top" title="Input Flow Type"></i></span>
                                        </p>
                                        @else
                                        <p>
                                            {{Str::upper($stream['flow_type'])}}
                                            <span class="badge badge-info"><i class="fas fa-arrow-circle-up" data-toggle="tooltip" data-placement="top" title="Output Flow Type"></i></span>
                                        </p>
                                        @endif
                                    </li>
                                    @endforeach
                                    @else
                                    <li class="list-group-item">
                                        No Streams Added
                                    </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="condition">Selected Conditions
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Selected Conditions"></i></span>
                                </label>
                                <ul class="list-group">

                                    @if(!empty($response_data['conditions']))
                                    @foreach($response_data['conditions'] as $condition)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{$condition['name']}}
                                        <span class="badge badge-info">
                                            Associated Unit Type - {{$condition['unit_type']}}
                                        </span>
                                    </li>
                                    @endforeach
                                    @else
                                    <li class="list-group-item">No master conditions are being selected</li>
                                    @endif
                                </ul>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="name">Selected Outcomes
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Selected Outcomes"></i></span>
                                </label>
                                <ul class="list-group">
                                    @if(!empty($response_data['outcomes']))
                                    @foreach($response_data['outcomes'] as $outcome)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{$outcome['name']}}
                                        <span class="badge badge-info">
                                            Associated Unit Type - {{$outcome['unit_type']}}
                                        </span>
                                    </li>
                                    @endforeach
                                    @else
                                    <li class="list-group-item">No master outcomes are being selected</li>
                                    @endif
                                </ul>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exp_description">Tags</label>
                                @if(!empty($response_data['tags']))
                                @foreach($response_data['tags'] as $tag)
                                <span class="badge badge-info">{{$tag}}</span>
                                @endforeach
                                @endif
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exp_description">Description
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Description"></i></span>
                                </label>
                                <textarea name="exp_description" id="exp_description" rows="5" class="form-control" readonly>{{$response_data['description']}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
@endpush