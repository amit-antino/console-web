@extends('layout.console.master')
@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/experiment/experiment') }}">Experiments</a></li>
        <li class="breadcrumb-item active" aria-current="page">Experiment Profile - {{$process_experiment_info['name']}}</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="mb-3 mb-md-0">Experiment Profile : {{$process_experiment_info['name']}}</h4>
                </div>
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    <h5 class="mr-2">Status: <span class="badge badge-info">{{ucfirst($process_experiment_info['status'])}}</span></h5>
                    <a href="{{ url('/experiment/experiment/'.___encrypt($process_experiment_info['id']).'/edit') }}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" data-toggle="tooltip" data-placement="bottom" title="Edit Experiment">
                        <i class="btn-icon-prepend" data-feather="edit"></i>
                        Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="">Experiment Name: <span class="badge badge-info">{{$process_experiment_info['name']}}</span></label>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">Category: <span class="badge badge-info">{{$process_experiment_info['category']}}</span></label>
                                <label for="">Classification:
                                    @if(!empty($process_experiment_info['classification']))
                                    @foreach($process_experiment_info['classification'] as $classification)
                                    <span class="badge badge-info">
                                        {{$classification['name']}}
                                    </span>
                                    @endforeach
                                    @endif
                                </label>
                                <label for="">Data Source: <span class="badge badge-info">{{$process_experiment_info['data_source']}}</span></label>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">Selected Experiment Units</label>
                                <ul class="list-group">
                                    @if(!empty($process_experiment_info['experiment_units']))
                                    @foreach($process_experiment_info['experiment_units'] as $experiment_unit)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        {{$experiment_unit['experiment_unit_name']}}
                                        <span class="badge badge-info" data-toggle="tooltip" data-placement="bottom" title="Experiment Unit Name">{{$experiment_unit['experiment_equipment_unit']['experiment_unit_name']}}</span>
                                    </li>
                                    @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">Selected Products:
                                    @if(!empty($process_experiment_info['product_list']))
                                    @foreach($process_experiment_info['product_list'] as $product)
                                    <span class="badge badge-info">
                                        {{$product['name']}}
                                    </span>
                                    @endforeach
                                    @endif
                                </label>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">Selected Energy Utilities:
                                    @if(!empty($process_experiment_info['energy_list']))
                                    @foreach($process_experiment_info['energy_list'] as $energy_utility)
                                    <span class="badge badge-info">
                                        {{$energy_utility['energy_name']}}
                                    </span>
                                    @endforeach
                                    @endif
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="">Selected Main Product Input:
                                    @if(!empty($process_experiment_info['main_product_inputs']))
                                    @foreach($process_experiment_info['main_product_inputs'] as $product)
                                    <span class="badge badge-info">
                                        {{$product['name']}}
                                    </span>
                                    @endforeach
                                    @endif
                                </label>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">Selected Main Product Output:
                                    @if(!empty($process_experiment_info['main_product_outputs']))
                                    @foreach($process_experiment_info['main_product_outputs'] as $product)
                                    <span class="badge badge-info">
                                        {{$product['name']}}
                                    </span>
                                    @endforeach
                                    @endif
                                </label>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">Description</label>
                                <textarea class="form-control" rows="5" readonly>{{$process_experiment_info['description']}}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="">Tags</label>
                        @if(!empty($process_experiment_info['tags']))
                        @foreach($process_experiment_info['tags'] as $tag)
                        <span class="badge badge-info">{{$tag}}</span>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection