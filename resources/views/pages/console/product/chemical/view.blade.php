@extends('layout.console.master')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/product/chemical') }}">Products</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$chemical->chemical_name}}</li>
    </ol>
</nav>
<div class="row">
    @if(!empty($chemical->image))

    <div class="col-md-3 stretch-card">
        <div class="card shadow">
            <img src="{{url($chemical->image)}}" class="img-fluid card-img-top" alt="">

        </div>
    </div>
    @endif

    <div class="@if(!empty($chemical->image)) col-md-9 @else col-md-12 @endif stretch-card">
        <div class="card shadow">
            <div class="card-heder text-right p-2">
                @if($chemical->product_type_id==1)
                <a href="{{url('/product/chemical/'.___encrypt($chemical->id).'/edit')}}" class="btn btn-sm btn-secondary btn-icon-text">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
                @else
                <a href="{{url('/product/generic/'.___encrypt($chemical->id).'/edit')}}" class="btn btn-sm btn-secondary btn-icon-text">
                    <i class="fas fa-edit"></i>
                    Edit
                </a>
                @endif
            </div>
            <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-line" id="lineTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-line-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Product Details</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" id="profile-line-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Properties</a>
                    </li> -->
                </ul>
                <div class="tab-content mt-3" id="lineTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-line-tab">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center flex-wrap grid-margin">
                                <div>
                                    <h5 class="mb-3 mb-md-0">{{$chemical->chemical_name}}</h5>
                                </div>
                                <div class="d-flex align-items-center flex-wrap text-nowrap">
                                    @if(!empty($chemical->tags))
                                    <h6 class="mb-3 mb-md-0">Tags:
                                        @foreach($chemical->tags as $tag)
                                        <span class="badge badge-info">{{$tag}}</span>
                                        @endforeach
                                    </h6>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <p>Molecular Formula - <b>{{$chemical->molecular_formula}}</b></p>
                                <p>Product Brand Name - <b>{{$chemical->product_brand_name}}</b></p>
                                <p>Category - <b>{{$chemical->chemicalCategory->name}}</b></p>
                                <p>Classification - <b>{{$chemical->chemicalClassification->name}}</b></p>
                                <p>EC Number - <b>{{$chemical->ec_number}}</b></p>
                                <p>Own Product - <b>@if($chemical->own_product=='1')Yes @else No @endif</b></p>
                                @if(!empty($chemical->other_name))
                                <p>Other Name:
                                    @foreach($chemical->other_name as $other_name)
                                    <span class="badge badge-info">{{$other_name}}</span>
                                    @endforeach
                                </p>
                                @endif
                                <p>IUPAC - <b>{{$chemical->iupac}}</b></p>
                                <p>INCHI - <b>{{$chemical->inchi}}</b></p>
                                <p>INCHI KEY - <b>{{$chemical->inchi_key}}</b></p>
                                @if(!empty($chemical->cas_no))
                                <p>CAS No:
                                    @foreach($chemical->cas_no as $cas_no)
                                    <span class="badge badge-info">{{$cas_no}}</span>
                                    @endforeach
                                </p>
                                @endif
                                <p>Status - <b>{{ucfirst($chemical->status)}}</b></p>
                                <p>Created Date - <b>{{date('d-m-yy', strtotime($chemical->created_at))}}</b></p>
                                <p>Notes - <b>{{$chemical->notes}}</b></p>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-line-tab">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection