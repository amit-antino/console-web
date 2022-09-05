@extends('layout.console.master')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/product/chemical') }}">Products</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$generic->chemical_name}}</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-3 stretch-card">
        <div class="card shadow">
            @if(!empty($generic->image))
            <img src="{{$generic->image}}" class="img-fluid card-img-top" alt="">
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
            <div class="card-heder text-right p-2">
                <a href="{{url('/product/generic/'.___encrypt($generic->id).'/edit')}}" class="btn btn-sm btn-secondary btn-icon-text">
                    <i class="btn-icon-prepend" data-feather="edit"></i>
                    Edit
                </a>
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-line" id="lineTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-line-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Product Details</a>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="lineTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-line-tab">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center flex-wrap grid-margin">
                                <div>
                                    <h5 class="mb-3 mb-md-0">{{$generic->name}}</h5>
                                </div>
                                <div class="d-flex align-items-center flex-wrap text-nowrap">
                                    @if(!empty($generic->tags))
                                    <h6 class="mb-3 mb-md-0">Tags:
                                        @foreach($generic->tags as $tag)
                                        <span class="badge badge-info">{{$tag}}</span>
                                        @endforeach
                                    </h6>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <p>Product Brand Name - <b>{{$generic->product_brand_name}}</b></p>
                                <p>Category - <b>{{$generic->chemicalCategory->name}}</b></p>
                                <p>Classification - <b>{{$generic->chemicalClassification->name}}</b></p>
                                <p>Own Product - <b>@if($generic->own_product=='1')Yes @else No @endif</b></p>
                                @if(!empty($generic->other_name))
                                <p>Other Name:
                                    @foreach($generic->other_name as $other_name)
                                    <span class="badge badge-info">{{$other_name}}</span>
                                    @endforeach
                                </p>
                                @endif
                                <p>Status - <b>{{ucfirst($generic->status)}}</b></p>
                                <p>Created Date - <b>{{date('d-m-yy', strtotime($generic->created_at))}}</b></p>
                                <p>Notes - <b>{{$generic->notes}}</b></p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection