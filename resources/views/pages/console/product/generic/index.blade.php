@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Products</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Products</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <button type="button" data-toggle="modal" data-target="#chemicalModel" class="btn btn-sm btn-outline-info btn-icon-text mr-2 d-none d-md-block">
            <i class="btn-icon-prepend" data-feather="download"></i>
            Import
        </button>
        <button type="button" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
            <i class="btn-icon-prepend" data-feather="download-cloud"></i>
            Generate Predict Properties
        </button>
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Create or Add Product</button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ url('/product/chemical/create') }}">Commercial</a>
                <a class="dropdown-item" href="{{ url('/product/generic/create') }}">Generic</a>
            </div>
        </div>
        <div class="deletebulk">
            <button type="button" data-url="{{ url('/product/chemical/bulk-delete') }}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="trash"></i>
                Delete
            </button>
        </div>
    </div>
</div>

<div class="row flex-grow">
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline">
                    <h6 class="card-title mb-0">Pure Products</h6>
                </div>
                <div class="row">
                    <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2">{{$pure_product_count}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline">
                    <h6 class="card-title mb-0">Simulated / Experiment Products</h6>
                </div>
                <div class="row">
                    <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2">{{$simulated_product_count}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline">
                    <h6 class="card-title mb-0">Generic Products</h6>
                </div>
                <div class="row">
                    <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2">{{$generic_count}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3 grid-margin stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-baseline">
                    <h6 class="card-title mb-0">Overall Products</h6>
                </div>
                <div class="row">
                    <div class="col-6 col-md-12 col-xl-5">
                        <h3 class="mb-2">{{$overall_count}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="chemical_list" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="example-select-all"></th>
                                <th>Product Details</th>
                                <th>Classification</th>
                                <th>Categories</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $cnt=count($generics)
                            @endphp
                            @if(!empty($generics))
                            @foreach($generics as $generic)
                            <tr>
                                <td><input type="checkbox" value="{{___encrypt($generic->id)}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{$generic->name}}</td>
                                <td>{{$generic->chemicalClassification->name}}</td>
                                <td>{{$generic->chemicalCategory->name}}</td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" data-url="{{url('/product/generic/'.___encrypt($generic->id).'?status='.$generic->status)}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" class="custom-control-input" id="customSwitch{{___encrypt($generic->id)}}" @if($generic->status=='active' ) checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{___encrypt($generic->id)}}"></label>
                                    </div>
                                </td>
                                <td>
                                    <!-- <a href="{{url('/product/generic/'.___encrypt($generic->id).'/addprop')}}" class="btn btn-sm btn-secondary" data-toggle="tooltip" data-placement="top" title="Manage Properties for a Generic">
                                        <i class="fas fa-cogs text-white"></i>
                                    </a> -->


                                    <div class="btn-group btn-group-sm" role="group">

                                        <a href="{{url('/product/generic/'.___encrypt($generic->id))}}" class="btn btn-icon" data-toggle="tooltip" data-placement="top" title="View Generic">
                                            <i class="fas fa-eye text-secondary"></i>
                                        </a>
                                        <a href="{{url('/product/generic/'.___encrypt($generic->id).'/edit')}}" class="btn btn-icon" data-toggle="tooltip" data-placement="top" title="Edit Generic">
                                            <i class="fas fa-edit text-secondary"></i>
                                        </a>
                                        <a href="javascript:void(0);" data-url="{{url('/product/generic/'.___encrypt($generic->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="top" title="Delete Generic">
                                            <i class="fas fa-trash text-secondary"></i>
                                        </a>

                                    </div>
                                </td>
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
<div class="modal fade" id="chemicalModel" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userLabel">Create Chemical</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/product/chemical/importFile') }}" method="post" enctype="multipart/form-data" role="chemicals-import">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Import CSV
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Profile"></i></span>
                            </label>
                            <input type="file" id="select_file" name="select_file" class="form-control-file">
                        </div>
                    </div>
                    <hr>
                    <div class="text-right">
                        <a href="{{ url('sample_import/chemical_sample_format.xlsx') }}" download="" class="btn btn-info">Download Sample</a>
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="chemicals-import"]' class="btn btn-sm btn-secondary">Upload</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    var cnt = '{{$cnt}}'
    if (cnt > 10) {
        $('#chemical_list').DataTable();
    }

    $(".deletebulk").hide();
    $("#example-select-all").click(function() {
        if ($(this).is(":checked")) {
            $(".deletebulk").show();
        } else {
            $(".deletebulk").hide();
        }
        $('.checkSingle').not(this).prop('checked', this.checked);
    });

    $('.checkSingle').click(function() {
        if ($('.checkSingle:checked').length == $('.checkSingle').length) {
            $('#example-select-all').prop('checked', true);
        } else {
            $('#example-select-all').prop('checked', false);
        }
    });
</script>
@endpush