@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant/')}}">Tenants</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant/manage/'.$tenant_id)}}">{{get_tenant_name($tenant_id)}} Manage</a></li>
        <li class="breadcrumb-item active">User Group</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">User Group</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <select id="exportLink" style="display:none !important" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block col-md-3">
            <option>Export </option>
            <option id="csv">Export as CSV</option>
            <!-- <option id="excel">Export as XLS</option> -->
            <option id="json">Export as JSON</option>
        </select>
        <!-- <button type="button" data-toggle="modal" data-target="#importModel" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
            <i class="btn-icon-prepend" data-feather="download"></i>
            Import
        </button> -->
        <a href="{{ url('/admin/tenant/'.$tenant_id.'/user_group/create') }}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
            <i class="btn-icon-prepend" data-feather="user-plus"></i>
            Add User Group
        </a>
        <div class="deletebulk">
            <button type="button" data-url="{{ url('/admin/tenant/'.$tenant_id.'/user_group/bulk-delete') }}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger btn-icon-text" style="width:140%;">
                <i class="btn-icon-prepend" data-feather="trash"></i>
                Delete
            </button>
        </div>
    </div>
</div>

@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p>{{ $message }}</p>
</div>
@endif
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="department_list" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="example-select-all"></th>
                                <th>User Group Name</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $cnt = count($data->user_group)
                            @endphp
                            @if(!empty($data->user_group))
                            @foreach($data->user_group as $key =>$val)
                            <tr>
                                <td><input type="checkbox" value="{{___encrypt($val['id'])}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{ $val['name']}} </td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" data-ask="Are you sure you want to change status?" data-url="{{url('/admin/tenant/'.$tenant_id.'/user_group/'.___encrypt($val['id']).'?status='.$val['status'])}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" class="custom-control-input" id="customSwitch{{___encrypt($val['id'])}}" @if($val['status']=='active' ) checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{___encrypt($val['id'])}}"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">

                                        <a href="{{ url('/admin/tenant/'.$tenant_id.'/user_group/'.___encrypt($val['id']).'/edit')}}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit user group">
                                            <i class="fa fa-edit text-secondry"></i>
                                        </a>
                                        <a href="javascript:void(0);" data-url="{{ url('/admin/tenant/'.$tenant_id.'/user_group/'.___encrypt($val['id']))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete User Group">
                                            <i class="fas fa-trash text-secondry"></i>
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
<div class="modal fade" id="importModel" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userLabel">Import User Group</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/admin/tenant/'.$tenant_id.'/user_group/importfile') }}" method="post" enctype="multipart/form-data" role="chemicals-import">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Import User Group
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select csv file"></i></span>
                                <span id="sample_download_html"><a href="{{url('assets/sample/sample_user_group.csv')}}" download=""> Sample Download</a></span>
                            </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="import_file" name="import_file">
                                <label class="custom-file-label" for="import_file">Choose File</label>
                            </div>
                            <label class="control-label"><br>OR <br>Import User Group using json format
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select json file"></i></span>
                                <span id="sample_download_html"><a href="{{url('assets/sample/Sample User Group.json')}}" download=""> Sample Download</a></span>
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
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/promise-polyfill/polyfill.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    var cnt = '{{$cnt}}'
    if (cnt > 0) {
        $('#exportLink').show();
        $('#department_list').DataTable({
            "iDisplayLength": 100,
            dom: 'Bfrtip',
            buttons: [{
                extend: 'csv',
                title: 'User Group CSV',
                text: 'Export to CSV',
                //Columns to export
                exportOptions: {
                    columns: [1, 2, 3, 4]
                }
            }, ],
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
                            'User Group.json'
                        )
                    }
                })
            }
        });
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
        var len = $("[name='select_all[]']:checked").length;
        if (len > 1) {
            $(".deletebulk").show();
        } else {
            $(".deletebulk").hide();
        }
    });
</script>
@endpush
