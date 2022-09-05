@extends('layout.console.master')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/other_inputs/reaction')}}">Reactions</a></li>
        <li class="breadcrumb-item active" aria-current="page">View Reaction{{$reaction->reaction_name}}</li>
    </ol>
</nav>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h4 class="mb-3 mb-md-0">View Reaction : {{$reaction->reaction_name}}</h4>
                </div>
                <div class="d-flex align-items-center flex-wrap text-nowrap">


                    <h5 class="mr-2">Status: <span class="badge badge-info">{{ucfirst($reaction->status)}}</span></h5>
                    <a href="{{ url('/other_inputs/reaction/'.___encrypt($reaction->id).'/edit') }}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" data-toggle="tooltip" data-placement="bottom" title="Edit Reaction">
                        <i class="btn-icon-prepend" data-feather="edit"></i>
                        Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="">Reaction Source</label>
                        <input type="text" class="form-control" readonly name="" id="" value="{{$reaction->reaction_source}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Reaction Phase</label>
                        <input type="text" class="form-control" readonly name="" id="" value="{{ucfirst($reaction->select_phase)}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Stoichiometric Balance</label>
                        <input type="text" class="form-control" readonly name="" id="" value="{{$reaction->balance}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Reactants</label>
                        <ul class="list-group">

                            @if(!empty($reactant_component))
                            @foreach($reactant_component as $ck=>$cv)
                            <li class="list-group-item">
                                {{$cv['chemical_name']}}
                            </li>
                            @endforeach

                            @endif


                        </ul>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Products</label>
                        <ul class="list-group">

                            @if(!empty($product_component))
                            @foreach($product_component as $ck=>$cv)
                            <li class="list-group-item">
                                {{$cv['chemical_name']}}
                            </li>
                            @endforeach

                            @endif


                        </ul>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Chemical Equation</label>
                        <input type="text" class="form-control" readonly name="" id="" value="{{$reaction->chemical_reaction_left}}{{$reaction->chemical_reaction_right}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Rate Equation</label>
                        <input type="text" class="form-control" readonly name="" id="" value="{{$reaction->balance}}">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Tags</label>
                        @if(!empty($reaction->tags))
                        @foreach($reaction->tags as $tag)
                        <span class="badge badge-info">{{$tag}}</span>
                        @endforeach
                        @endif
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Description</label>
                        <textarea class="form-control" readonly name="" id="" rows="5">{{$reaction->description}}</textarea>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="">Notes</label>
                        {!!$reaction->notes!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection