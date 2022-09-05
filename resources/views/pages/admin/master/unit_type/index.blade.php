@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Unit Type</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Unit Type </h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <select id="exportLink" style="display:none !important" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block col-md-3">
            <option>Export </option>
            <option id="csv">Export as CSV</option>
            <!-- <option id="excel">Export as XLS</option> -->
            <option id="json">Export as JSON</option>
        </select>
        <button type="button" data-toggle="modal" data-target="#importModel" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
            <i class="btn-icon-prepend" data-feather="download"></i>
            Import
        </button>
        <button type="button" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" data-toggle="modal" data-target="#unitModal">
            <i class="btn-icon-prepend " data-feather="plus"></i>
            Create Unit Type
        </button>
        <button type="button" data-url="{{url('/admin/master/unit_type/bulk-delete')}}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger deletebulk btn-icon-text mb-2 mb-md-0">
            <i class="btn-icon-prepend" data-feather="trash"></i>
            Delete
        </button>
    </div>
</div>

    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive1" style="overflow-x:none;">
                    <table id="class_list" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="example-select-all"></th>
                                <th>Unit Type</th>
                                <th style="display:none">Unit Constant</th>
                                <th style="display:none">Default Unit</th>
                                <th style="display:none">status</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $cnt = count($unit_types)
                            @endphp
                            @if(!empty($unit_types))
                            @foreach($unit_types as $unit)
                            @php
                            if (!empty($unit['unit_constant'])) {
                                $unit_constant = '';
                                $default_unit = '';
                                for($i=0;$i<count($unit['unit_constant']);$i++){ 
                                    if(!empty($unit['unit_constant'][$i]['unit_name'])){
                                        $unit_constant=$unit_constant.$unit['unit_constant'][$i]['unit_name'].":";
                                    }   
                                } 
                            } 
                            @endphp 
                                <tr>
                                <td><input type="checkbox" value="{{___encrypt($unit['id'])}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{$unit['unit_name']}}</td>
                                <td style="display:none">{{$unit_constant}}</td>
                                <td style="display:none">{{$default_unit}}</td>
                                <td style="display:none">{{$unit['status']}}</td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" data-url="{{url('/admin/master/unit_type/'.___encrypt($unit['id']).'?status='.$unit['status'])}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" id="customSwitch{{___encrypt($unit['id'])}}" @if($unit['status']=="pending" ) disabled @endif @if($unit['status']=='active' ) checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{___encrypt($unit['id'])}}"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a class="btn btn-icon" href="javascript:void(0);" data-url="{{url('/admin/master/unit_type/'.___encrypt($unit['id']).'/edit')}}" data-request="ajax-popup" data-target="#edit-div" data-tab="#unitModal{{___encrypt($unit['id'])}}" data-toggle="tooltip" data-placement="bottom" title="Edit Unit Type">
                                            <i class="fas fa-edit text-secondary"></i>
                                        </a>
                                        <a class="btn btn-icon" href="javascript:void(0);" data-url="{{url('admin/master/unit_type/'.___encrypt($unit['id']))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-toggle="tooltip" data-placement="bottom" title="Delete Unit Type">
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

<div class="modal fade" id="importModel" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userLabel">Import Unit Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/admin/master/unit_type/importfile') }}" method="post" enctype="multipart/form-data" role="chemicals-import">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Import Unit Type
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select csv file"></i></span>
                                <span id="sample_download_html"><a href="{{url('assets/sample/sample_unit_type.csv')}}" download=""> Sample Download</a></span>
                            </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="import_file" name="import_file">
                                <label class="custom-file-label" for="import_file">Choose File</label>
                            </div>
                            <label class="control-label"><br>OR <br>Import Unit Type using json format
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select json file"></i></span>
                                <span id="sample_download_html"><a href="{{url('assets/sample/Sample Unit Type.json')}}" download=""> Sample Download</a></span>
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
@include('pages.admin.master.unit_type.create')
<div id="edit-div">
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>

<script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/table-to-json@1.0.0/lib/jquery.tabletojson.min.js" integrity="sha256-H8xrCe0tZFi/C2CgxkmiGksqVaxhW0PFcUKZJZo1yNU=" crossorigin="anonymous"></script>
@endpush

@push('custom-scripts')
<script>
    var cnt = '{{$cnt}}'
    $(function() {
        if (cnt > 10) {
            $('#exportLink').show();
            $('#class_list').DataTable({
                "iDisplayLength": 100,
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'csv',
                        title: 'Unit Type CSV',
                        text: 'Export to CSV',
                        //Columns to export
                        exportOptions: {
                            columns: [1, 2, 3, 4]
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
                            var table = $('#class_list').tableToJSON({
                                onlyColumns: [1, 2, 3, 4]

                            });

                            $.fn.dataTable.fileSave(
                                new Blob([JSON.stringify(table, null, '\t')]),
                                'Unit Type.json'
                            )
                        }
                    })
                }
            });
        }
    });
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
        var len = $("[name='select_all[]']:checked").length;
        if (len > 1) {
            $(".deletebulk").show();
        } else {
            $(".deletebulk").hide();
        }
    });
</script>
@endpush