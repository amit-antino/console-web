@extends('layout.console.master')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/organization/vendor">Vendor</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$vendor->name}}</li>
    </ol>
</nav>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 stretch-card">
                        <div class="card shadow">
                            @if(!empty($vendor->logo))
                            <img src="{{$vendor->logo}}" class="img-fluid card-img-top" alt="">
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
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-tabs-line" id="lineTab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="home-line-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Registered Details</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="profile-line-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Locations</a>
                                    </li>
                                </ul>
                                <div class="tab-content mt-3" id="lineTabContent">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-line-tab">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5>{{$vendor->name}}</h5>
                                                <p><b>Category - </b>{{$vendor->category->category_name}}</p>
                                                <p><b>Classification - </b>{{$vendor->classification->classification_name}}</p>
                                                <p><b>Start Date - </b>{{date('d-m-yy', strtotime($vendor->start_date))}}</p>
                                                <p><b>Address - </b>{{$vendor->address}}</p>
                                                <p><b>Description - </b>{{$vendor->description}}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-line-tab">...</div>
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