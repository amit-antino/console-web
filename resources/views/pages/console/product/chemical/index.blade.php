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
        <select id="exportLink" style="display:none !important" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block col-md-3">
            <option>Export </option>
            <option id="csv">Export as CSV</option>
            <!-- <option id="excel">Export as XLS</option> -->
            <option id="json">Export as JSON</option>
        </select>
        <button type="button" data-toggle="modal" data-target="#chemicalModel" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
            <i class="btn-icon-prepend" data-feather="download"></i>
            Import
        </button>
        <!-- <a href="{{url('coming_soon')}}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
            <i class="btn-icon-prepend" data-feather="download-cloud"></i>
            Generate Predict Properties
        </a> -->
        <div class="btn-group">
            <button type="button" class="btn btn-sm btn-secondary btn-icon-text dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Add Product</button>
            <div class="dropdown-menu">
                <a class="dropdown-item" href="{{ url('/product/chemical/create') }}">Commercial</a>
                <a class="dropdown-item" href="{{ url('/product/generic/create') }}">Generic</a>
            </div>
        </div>
    </div>
</div>

<!-- <div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="card-columns">
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                <small>Products<br></small>Pure - {{$pure_product_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-flask fa-2x text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                <small>Products<br></small>Simulated / Experiment - {{$simulated_product_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-flask fa-2x text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                <small>Products<br></small>Generic - {{$generic_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-flask fa-2x text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                <small>Products<br></small>Overall - {{$overall_count}}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-flask fa-2x text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->

<div class="row">
    <div class="col-md-12 mb-3 stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="chemical_list" class="table">
                        <thead>
                            <th>
                            </th>
                            <th style="display:none">Chemical Name</th>
                            <th style="display:none">Categories</th>
                            <th style="display:none">Classification</th>
                            <th style="display:none">Brand Name</th>
                            <th style="display:none">IUPAC</th>
                            <th style="display:none">CAS</th>
                            <th style="display:none">INCHI</th>
                            <th style="display:none">INCHI key</th>
                            <th style="display:none">EC number</th>
                            <th style="display:none">Molecular formula</th>
                            <th style="display:none">SMILES</th>
                            <th style="display:none">SMILES type</th>
                            <th style="display:none">Other names</th>
                            <th style="display:none">Tags</th>
                            <th style="display:none">Own Product</th>
                            <th style="display:none">Note</th>
                        </thead>
                        <tbody>
                            @php
                            $cnt=count($chemicals)
                            @endphp

                            @if(!empty($chemicals))
                            @foreach($chemicals as $chemical)
                            <tr>
                                <td>
                                    <div class="card border-left-secondary shadow">
                                        <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                                            <div class="h6 font-weight-bold text-secondary text-uppercase">
                                                {{$chemical->chemical_name}}
                                            </div>
                                            <div class="btn-group btn-group-sm" role="group">
                                                <a type="button" class="btn btn-icon" href="{{url('/product/chemical/'.___encrypt($chemical->id).'/addprop')}}" data-toggle="tooltip" data-placement="top" title="Manage Properties for a Product">
                                                    <i class="fas fa-cog icon-sm mr-2 text-secondary"></i>
                                                </a>
                                                <a type="button" class="btn btn-icon" href="{{url('/product/chemical/'.___encrypt($chemical->id))}}" data-toggle="tooltip" data-placement="top" title="View Product">
                                                    <i class="fas fa-eye icon-sm mr-2 text-secondary"></i>
                                                </a>
                                                @if($chemical->product_type_id==1)
                                                <a href="{{url('/product/chemical/'.___encrypt($chemical->id).'/edit')}}" type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="top" title="Edit Product">
                                                    <i class="fas fa-edit icon-sm mr-2 text-secondary"></i>
                                                </a>
                                                @else
                                                <a href="{{url('/product/generic/'.___encrypt($chemical->id).'/edit')}}" type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="top" title="Edit Product">
                                                    <i class="fas fa-edit icon-sm mr-2 text-secondary"></i>
                                                </a>
                                                @endif
                                                <a type="button" class="btn btn-icon" href="javascript:void(0);" data-url="{{url('/product/chemical/'.___encrypt($chemical->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-toggle="tooltip" data-placement="top" title="Delete Product">
                                                    <i class="fas fa-trash icon-sm mr-2 text-secondary"></i>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <p class="card-text">Classification:
                                                        <span class="badge badge-secondary" data-toggle="tooltip" data-placement="top" title="Product Classification">{{!empty($chemical->chemicalClassification->name)?$chemical->chemicalClassification->name:""}}</span>
                                                    </p>
                                                    <p class="card-text">Category:
                                                        <span class="badge badge-secondary" data-toggle="tooltip" data-placement="top" title="Product Category">{{!empty($chemical->chemicalCategory->name)?$chemical->chemicalCategory->name:""}}</span>
                                                    </p>

                                                </div>
                                                <div class="col mr-2">
                                                    <p class="card-text">Product IUPAC:
                                                        <span class="badge badge-secondary" data-toggle="tooltip" data-placement="top" title="Product International Union of Pure and Applied Chemistry - IUPAC">{{$chemical->iupac}}</span>
                                                    </p>
                                                    <p class="card-text">Product INCHI:
                                                        <span class="badge badge-secondary" data-toggle="tooltip" data-placement="top" title="Product International Chemical Identifier - INCHI">{{$chemical->inchi}}</span>
                                                    </p>
                                                    <p class="card-text">Molecular Formula:
                                                        <span class="badge badge-secondary" data-toggle="tooltip" data-placement="top" title="Product Molecular Formula">{{$chemical->molecular_formula}}</span>
                                                    </p>
                                                    <p class="card-text">CAS Number:
                                                        @php
                                                        $cas="";
                                                        @endphp
                                                        @if(!empty($chemical->cas_no))
                                                        @foreach($chemical->cas_no as $cas_no)
                                                        <span class="badge badge-secondary" data-toggle="tooltip" data-placement="top" title="Chemical Abstracts Service Number - CAS Number">{{$cas_no}}</span>
                                                        @endforeach
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-flask fa-2x text-secondary text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                                @php
                                                $list_unique=[];
                                                $molecular_formula = !empty($chemical->molecular_formula)?$chemical->molecular_formula:'';
                                                $lists="";
                                                $lists = get_list_name(!empty($chemical->cas_no)?$chemical->cas_no:'',$molecular_formula,$chemical->inchi_key,$chemical->ec_number,!empty($chemical->other_name)?$chemical->other_name:'');
                                                @endphp
                                                <p class="card-text">Regulatory List:
                                                    @if(!empty($lists))
                                                    @foreach($lists as $list_detail)
                                                    @foreach($list_detail as $list)
                                                    @php
                                                    if(!in_array($list->id, $list_unique)){
                                                    $list_unique[]=$list->id;
                                                    @endphp
                                                    <b data-url="{{url('product/chemical/list_view/'.___encrypt($list->id).'/'.___encrypt($chemical->id))}}" data-request="ajax-popup" data-target="#view_list_div" data-toggle="tooltip" data-tab="#viewListModal{{___encrypt($list->id)}}" data-placement="top" title="{{$list->hover_msg}}">
                                                        <span class="badge badge-danger">{{$list->list_name}}</span>
                                                    </b>
                                                    @php
                                                    }
                                                    @endphp
                                                    @endforeach
                                                    @endforeach
                                                    @else
                                                    <b><span class="badge badge-danger">No Records Found</span></b>
                                                    @endif
                                                </p>
                                                <span class="">
                                                    <div class="custom-control custom-switch">
                                                        <label style="padding-right:40px;padding-top:7px;">Status:</label>
                                                        <input type="checkbox" data-url="{{url('/product/chemical/'.___encrypt($chemical->id).'?status='.$chemical->status)}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to change status ?" class="custom-control-input" id="customSwitch{{___encrypt($chemical->id)}}" @if($chemical->status=='active' ) checked @endif>
                                                        <label disabled class="custom-control-label" for="customSwitch{{___encrypt($chemical->id)}}"></label>
                                                    </div>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td style="display:none">{{$chemical->chemical_name}}</td>
                                <td style="display:none">{{!empty($chemical->chemicalCategory->name)?$chemical->chemicalCategory->name:''}}</td>
                                <td style="display:none">{{!empty($chemical->chemicalClassification->name)?$chemical->chemicalClassification->name:''}}</td>
                                <td style="display:none">{{$chemical->product_brand_name}}</td>
                                <td style="display:none">{{$chemical->iupac}}</td>
                                <td style="display:none">{{implode(",",!empty($chemical->cas_no)?$chemical->cas_no:[])}}</td>
                                <td style="display:none">{{$chemical->inchi}}</td>
                                <td style="display:none">{{$chemical->inchi_key}}</td>
                                <td style="display:none">{{$chemical->ec_number}}</td>
                                <td style="display:none">{{$chemical->molecular_formula}}</td>
                                @php
                                $smiles = "";
                                $smile_types = "";
                                if(!empty($chemical->smiles)){
                                foreach($chemical->smiles as $smile){
                                $smiles = $smiles.$smile["smile"].",";
                                $smile_types = $smile_types.$smile["types"].",";
                                }
                                }

                                @endphp
                                <td style="display:none">{{rtrim($smiles,",")}}</td>
                                <td style="display:none">{{rtrim($smile_types,",")}}</td>
                                <td style="display:none">{{implode(",",!empty($chemical->other_name)?$chemical->other_name:[])}}</td>
                                <td style="display:none">{{implode(",",!empty($chemical->tags)?$chemical->tags:[])}}</td>
                                <td style="display:none">@if($chemical->own_product=='1') Yes @endif
                                    @if($chemical->own_product=='2') No @endif
                                </td>
                                <td style="display:none">{{$chemical->notes}}</td>
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
                <h5 class="modal-title" id="userLabel">Import Products</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/product/chemical/importFile') }}" method="post" enctype="multipart/form-data" role="chemicals-import">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Select Product type
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Profile"></i></span>
                            </label>
                            <select class="form-control" name="product_type_id" id="product_type_id">
                                <option value="1">Commercial</option>
                                <option value="2">Generic</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label class="control-label">Import Products using csv format
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select csv file"></i></span>
                                <span id="sample_download_html"><a href="{{url('assets/sample/sample_chemical.csv')}}" download=""> Sample Download Commercial</a></span>
                            </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="product_file" name="product_file">
                                <label class="custom-file-label" for="product_file">Choose File</label>
                            </div>
                            <label class="control-label"><br>OR <br>Import Products using json format
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select json file"></i></span>
                                <span id="sample_download_html"><a href="{{url('assets/sample/Sample Chemical.json')}}" download=""> Sample Download</a></span>
                            </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="import_json" name="import_json">
                                <label class="custom-file-label" for="import_file">Choose json File</label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="chemicals-import"]' class="btn btn-sm btn-secondary">Upload</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <button class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>

                    </div>
                </form>
                <!-- sample/generic_sample.xlsx -->
            </div>
        </div>
    </div>
</div>

<div id="view_list_div"></div>

@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>

<script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/table-to-json@1.0.0/lib/jquery.tabletojson.min.js" integrity="sha256-H8xrCe0tZFi/C2CgxkmiGksqVaxhW0PFcUKZJZo1yNU=" crossorigin="anonymous"></script>
@endpush

@push('custom-scripts')
<script>
    var cnt = '{{$cnt}}'
    //$('#exportLink').hide();
    // $("#exportLink").css("display", "none");
    if (cnt > 10) {
        $('#exportLink').show();
        $('#chemical_list').DataTable({
            "iDisplayLength": 100,
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'csv',
                    title: 'Chemical CSV',
                    text: 'Export to CSV',
                    //Columns to export
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]
                    }
                },
                {
                    text: 'JSON',
                    action: function(e, dt, button, config) {
                        var data = dt.buttons.exportData();
                        $.fn.dataTable.fileSave(
                            new Blob([JSON.stringify(data)]),
                            'Export.json'
                        );
                    }
                }
            ],
            initComplete: function() {
                var $buttons = $('.dt-buttons').hide();
                $('#exportLink').on('change', function() {
                    var btnClass = $(this).find(":selected")[0].id ?
                        '.buttons-' + $(this).find(":selected")[0].id :
                        null;
                    if (btnClass) $buttons.find(btnClass).click();
                    if (btnClass == '.buttons-json') {
                        var table = $('#chemical_list').tableToJSON({
                            onlyColumns: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16]
                        });
                        $.fn.dataTable.fileSave(
                            new Blob([JSON.stringify(table, null, '\t')]),
                            'Chemical.json'
                        )
                    }
                })
            }
        });
    }
    $('#generic_list').DataTable({
        "iDisplayLength": 100,
    });
    $('#product_type_id').on('change', function() {
        var product_type_id = $('#product_type_id').val();
        if (product_type_id == 1) {
            var val = "{{url('assets/sample/sample_chemical.csv')}}";
            var $html = '<a href="' + val + '" download=""> Sample Download Commercial</a>';
            $('#sample_download_html').html($html);
        } else {
            var val = "{{url('assets/sample/generic_sample.xlsx')}}";
            var $html = '<a href="' + val + '" download=""> Sample Download Generic</a>';
            $('#sample_download_html').html($html);
        }
    });
</script>
@endpush
