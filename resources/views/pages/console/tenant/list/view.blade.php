@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/organization/list')}}">Lists</a></li>
        <li class="breadcrumb-item active" aria-current="page">View List - {{$list_data->list_name}}</li>
    </ol>
</nav>
<div class="row">
    <div class="col-lg-12">
        <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                <div>
                    <h4 class="mb-3 mb-md-0">View list : {{$list_data->list_name}}</h4>
                </div>
                <div class="d-flex align-items-center flex-wrap text-nowrap">
                    <a href="{{ url('/organization/list/'.___encrypt($list_data->id).'/edit') }}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" data-toggle="tooltip" data-placement="bottom" title="Edit Regulatory Lists">
                        <i class="btn-icon-prepend" data-feather="edit"></i>
                        Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                        <div>
                            <h5 class="mb-3 mb-md-0">{{$list_data->list_name}}</h5>
                        </div>
                        <div class="d-flex align-items-center flex-wrap text-nowrap">
                            @if(!empty($list_data->tags))
                            <h5>Tags:
                                @foreach($list_data->tags as $tag)
                                <span class="badge badge-info">{{$tag}}</span>
                                @endforeach
                                @else
                            </h5>
                            @endif
                            <a class="btn btn-sm btn-secondary" data-toggle="collapse" href="#product_list" role="button" aria-expanded="false" aria-controls="product_list">
                                Product List
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="">Category Name: <span class="badge badge-info">{{!empty($list_data->categoryList->category_name) ? $list_data->categoryList->category_name : ''}}</span></label>
                                <!-- <label for="">Category Name</label>
                                <input type="text" class="form-control" readonly name="" id="" value="{{!empty($list_data->categoryList->category_name) ? $list_data->categoryList->category_name : ''}}"> -->
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Classification Name: <span class="badge badge-info">{{!empty($list_data->classificationList->classification_name) ? $list_data->classificationList->classification_name : ''}}</span></label>
                                <!-- <label for="">Classification Name</label>
                                <input type="text" class="form-control" readonly name="" id="" value="{{$list_data->classificationList->classification_name}}" /> -->
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Color Code: <span class="badge badge-info">{{ucfirst($list_data->color_code)}}</span></label>
                                <!-- <label for="">Color Code</label>
                                <input type="text" class="form-control" readonly name="" id="" value="{{ucfirst($list_data->color_code)}}" /> -->
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Match Type: <span class="badge badge-info">
                                {{($list_data->match_type == "col_based") ? "Column Based" : ''}}
                                {{($list_data->match_type == "conditional") ? "Conditional" : ''}}
                                </span></label>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Region : <span class="badge badge-info">
                                {{($list_data->region == "all") ? "All" : ''}}
                                {{($list_data->region == "spc") ? "Specific Region" : ''}}
                                </span></label>
                            </div>
                            <!-- <div class="form-group col-md-4">
                                <label for="">Source Name</label>
                                <input type="text" class="form-control" readonly name="" id="" value="{{ucfirst($list_data->source_name)}}">
                            </div> -->
                            <div class="form-group col-md-4">
                            <label for="">Source URL : <span class="badge badge-info">{{ucfirst($list_data->source_url)}}</span></label>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Compiled By : <span class="badge badge-info">
                                    {{($list_data->compilation == "int") ? "Internal" : ''}}
                                    {{($list_data->compilation == "ext") ? "External" : ''}}
                                </span></label>
                            </div>
                            <div class="form-group col-md-4">
                            <label for="">On Hover Message : <span class="badge badge-info">{{ucfirst($list_data->hover_msg)}}</span></label>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">Description
                                    <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Description"></i></span>
                                </label>
                                <textarea name="" id="" rows="5" class="form-control" readonly>{{$list_data->description}}</textarea>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Created Date & Time: <span class="badge badge-info">{{date('d/m/Y h:i:s A', strtotime($list_data->created_at))}}</span></label>
                                <!-- <label for="">Created Date & Time</label>
                                <input type="datetime" class="form-control" name="" id="" readonly value="{{date('d/m/Y h:i:s A', strtotime($list_data->created_at))}}"> -->
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Updated Date & Time: <span class="badge badge-info">{{date('d/m/Y h:i:s A', strtotime($list_data->updated_at))}}</span></label>
                                <!-- <label for="">Updated Date & Time</label>
                                <input type="datetime" class="form-control" name="" id="" readonly value="{{date('d/m/Y h:i:s A', strtotime($list_data->updated_at))}}"> -->
                            </div>
                            <div class="form-group col-md-4">
                                <label for="">Status: <span class="badge badge-info">{{ucfirst($list_data->status)}}</span></label>
                                <!-- <label for="">Status</label>
                                <input type="text" class="form-control" name="" id="" readonly value="{{ucfirst($list_data->status)}}"> -->
                            </div>
                        </div>
                        <div class="collapse" id="product_list">
                            <div class="card card-body">
                                <div class="table-responsive">
                                    <table id="products_list" class="table table-hover table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="max-width:500px">Chemical Name</th>
                                                <th>Hazards</th>
                                                <th>RSL Limit</th>
                                                <th>List Name</th>
                                                <th>Source</th>
                                                <th>Organization</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($list_data->chemicalLists))
                                            @foreach($list_data->chemicalLists as $chemicals)
                                            @if(!empty($chemicals->hazard_code))
                                            @endif
                                            <tr>
                                                <td style="width:550px;white-space:normal">
                                                    <p><b>{{$chemicals->chemical_name}}</b></p>
                                                    <p>Other Name : <b>{{$chemicals->other_name}}</b></p>
                                                    <p>CAS : <b>@foreach($chemicals->cas as $cas)
                                                    <span class="badge badge-info">{{$cas}}</span>
                                                    @endforeach</b></p>
                                                    <p>Smiles : <b>{{$chemicals->smiles}}</b></p>
                                                    <p>INCHI : <b>{{$chemicals->inchi_key}}</b></p>
                                                    <p>EC NUmber : <b>{{$chemicals->ec_number}}</b></p>
                                                    <p>IUPAC : <b>{{$chemicals->iupac}}</b></p>
                                                    <p>Molecular Formula : <b>{{$chemicals->molecular_formula}}</b></p>
                                                </td>
                                                <td style="width:350px;white-space:normal">
                                                    @php
                                                    $picto_path="";
                                                    if(!empty($chemicals->hazard_pictogram_details->pictogram_id)){
                                                        $picto_path = get_pictogram_path($chemicals->hazard_pictogram_details->pictogram_id);
                                                    }
                                                    @endphp
                                                    <p>Class : <b>{{$chemicals->hazard_class}}</b></p>
                                                    <p>Code : <b>{{$chemicals->hazard_code}}</b>
                                                    @if(!empty($picto_path))
                                                    <img src="{{url(!empty($picto_path)?$picto_path:'')}}" height="50" width="50">
                                                    @endif
                                                    </p>
                                                    <p>Statement : <b>{{$chemicals->hazard_statement}}</b></p>
                                                    <p>EU Hazard Statement : <b>{{$chemicals->eu_hazard_statement}}</b></p>
                                                </td>
                                                <td>{{$chemicals->rsl_limits_table}}</td>
                                                <td>{{$chemicals->list_name}}</td>
                                                <td>{{$chemicals->source}}</td>
                                                <td>{{$chemicals->organization}}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
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

@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(function() {
        $('#products_list').DataTable();
    });
</script>
@endpush