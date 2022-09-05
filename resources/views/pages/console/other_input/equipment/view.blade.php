@extends('layout.console.master')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/other_inputs/equipment')}}">Equipments</a></li>
        <li class="breadcrumb-item active" aria-current="page">View Equipment Unit - {{$equipment->equipment_name}}</li>
    </ol>
</nav>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h4 class="mb-3 mb-md-0">View Equipment Unit : {{$equipment->equipment_name}}</h4>
                </div>
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    <h5 class="mr-2">Status: <span class="badge badge-info">{{ucfirst($equipment->status)}}</span></h5>
                    <a href="{{ url('/other_inputs/equipment/'.___encrypt($equipment->id).'/edit') }}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" data-toggle="tooltip" data-placement="bottom" title="Edit Equipment Unit">
                        <i class="btn-icon-prepend" data-feather="edit"></i>
                        Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 stretch-card">
                        <div class="card shadow">
                            @if(!empty($equipment->equipment_image))
                            <img src="{{$equipment->equipment_image}}" class="img-fluid card-img-top" alt="">
                            @else
                            <img src="https://via.placeholder.com/250x250" class="img-fluid card-img-top" alt="">
                            <div class="card-body">
                                <h6 class="mt-2">Upload a different photo</h6>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile">
                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-9 stretch-card">
                        <div class="card shadow">
                            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                                <div>
                                    <h4 class="mb-3 mb-md-0">{{$equipment->equipment_name}}</h4>
                                </div>
                                <div class="d-flex align-items-center flex-wrap text-nowrap">
                                    @if(!empty($equipment->tags))
                                    <h5 class="mr-2">Tags:
                                        @foreach($equipment->tags as $tag)
                                        <span class="badge badge-info">{{$tag}}</span>
                                        @endforeach
                                    </h5>
                                    @endif
                                    <h5 class="mr-2">Availability:
                                        @if($equipment->availability == "true")
                                        <i class="fas fa-check-circle text-success" data-toggle="tooltip" data-placement="bottom" title="Availabe"></i>
                                        @else
                                        <i class="fas fa-times-circle text-danger" data-toggle="tooltip" data-placement="bottom" title="Unavailabe"></i>
                                        @endif
                                    </h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="">Installation Date</label>
                                        <input type="text" class="form-control" readonly name="" id="" value="{{dateFormate($equipment->installation_date)}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Purchased Date</label>
                                        <input type="text" class="form-control" readonly name="" id="" value="{{dateFormate($equipment->purchased_date)}}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Vendor Name</label>
                                        <input type="text" class="form-control" readonly name="" id="" value="{{$equipment->vendor->name}}">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="">Description</label>
                                        <textarea class="form-control" readonly name="" id="" rows="5">{{$equipment->description}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection