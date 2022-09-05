@extends('layout.console.master')
@php
$per = request()->get('sub_menu_permission');
$permission=!empty($per['profile']['method'])?$per['profile']['method']:[];
@endphp
@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Experiment Units</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Experiment Units</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <!-- <select id="exportLink" style="display:none !important" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block col-md-3">
            <option>Export </option>
            <option id="csv">Export as CSV</option>
            <option id="json">Export as JSON</option>
        </select> -->
        @if(in_array('create',$permission))
        <!-- <button type="button" data-toggle="modal" data-target="#importModel" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
            <i class="btn-icon-prepend" >
            Import
        </button> -->
        <a href="{{ url('/experiment/experiment_units/create') }}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
            <i class="btn-icon-prepend fas fa-plus" ></i>
            Add Experiment Unit
        </a>
        @endif
        @if(in_array('delete',$permission))
        <div class="deletebulk">
            <button type="button" data-url="{{url('/experiment/experiment_units/bulk-delete')}}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
                <i class="btn-icon-prepend fas fa-trash" ></i>
                Delete
            </button>
        </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="experiment_units" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="example-select-all"></th>
                                <th>Name</th>
                                <th>Equipment Unit Name</th>
                                <th>Conditions</th>
                                <th>Outcome</th>
                                <th>Streams</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $cnt=count($data);
                            @endphp
                            @if(!empty($data))
                            @foreach($data as $key =>$value)
                            @php
                            $equipment_unit = get_experiment_unit($value->id);
                            @endphp
                            <tr>
                                <td><input type="checkbox" value="{{___encrypt($value->id)}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{$value->experiment_unit_name}}</td>
                                <td>{{!empty($value->exp_equip_unit->equipment_name)?$value->exp_equip_unit->equipment_name:''}}</td>
                                <td>{{count($equipment_unit['condition'])}}</td>
                                <td>{{count($equipment_unit['outcome'])}}</td>
                                <td>{{count($equipment_unit['stream_flow'])}}</td>
                                <td>{{date('d/m/Y h:i:s A', strtotime($value->created_at))}}</td>
                                <td>{{date('d/m/Y h:i:s A', strtotime($value->updated_at))}}</td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" data-url="{{url('/experiment/experiment_units/'.___encrypt($value->id).'?status='.$value->status)}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you Change Status ?" class="custom-control-input" id="customSwitch{{___encrypt($value->id)}}" @if($value->status=='active')
                                        checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{___encrypt($value->id)}}"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        @php
                                        $pval=___encrypt($value['id'])
                                        @endphp
                                        @if(in_array('create',$permission))
                                        <a href="javascript:void(0);" onclick='cloneExpUnit("{{$pval}}")' type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Clone Experiment Unit">
                                            <i class="fas fa-copy text-secondary"></i>
                                        </a>
                                        @endif
                                        <a href="{{url('/experiment/experiment_units/'.___encrypt($value->id))}}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="View Experiment Unit">
                                            <i class="fas fa-eye text-secondary"></i>
                                        </a>
                                        @if(in_array('edit',$permission))
                                        <a href="{{url('/experiment/experiment_units/'.___encrypt($value->id).'/edit')}}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Experiment Unit">
                                            <i class="fas fa-edit text-secondary"></i>
                                        </a>
                                        @endif
                                        @if(in_array('delete',$permission))
                                        <a href="javascript:void(0);" data-url="{{url('/experiment/experiment_units/'.___encrypt($value->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                            <i class="fas fa-trash text-secondary"></i>
                                        </a>
                                        @endif
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
<div class="modal fade bd-example-modal-md my_product" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="text-center">
                <div id="expprofileSpinner1" class="spinner-border text-secondary" style="width: 2rem; height: 2rem;display: none; margin-top:25px;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <div class="modal-header">
                <h5 class="modal-title text-uppercase font-weight-normal" id="modal_logoutLabel">Clone Experiment Unit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="process_experiment">Enter Name
                            <span class="text-danger">*</span>
                            <span><i class="icon-sm" ata-toggle="tooltip" data-placement="top" title="Enter Report Name"></i></span>
                        </label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Name">
                        <input type="hidden" id="pid" name="pid" class="form-control" placeholder="Name">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" onclick="saveData()" class="btn btn-secondary">Save</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="importModel" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userLabel">Import Experiment Unit1</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('/experiment/experiment_units/importfile')}}" method="post" enctype="multipart/form-data" role="expunit-import">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Import Experiment Unit
                                <span><i class="icon-sm" ata-toggle="tooltip" data-placement="top" title="Select csv file"></i></span>
                                <span id="sample_download_html"><a href="{{url('assets/sample/sample_unit_type.csv')}}" download=""> Sample Download</a></span>
                            </label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="import_file" name="import_file">
                                <label class="custom-file-label" for="import_file">Choose File</label>
                            </div>
                            <label class="control-label"><br>OR <br>Import Experiment Unit using json format
                                <span><i class="icon-sm" ata-toggle="tooltip" data-placement="top" title="Select json file"></i></span>
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
                        <button type="button" data-request="ajax-submit" data-target='[role="expunit-import"]' class="btn btn-sm btn-secondary submit">Upload</button>
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
<script src="{{ asset('/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>

@endpush

@push('custom-scripts')
<script>
    var cnt = '{{$cnt}}';
    $(function() {
        'use strict';
        if (cnt > 10) {
            $('#exportLink').show();
            $('#experiment_units').DataTable({
                "iDisplayLength": 100,
                "language": {
                    search: ""
                },
                buttons: [{
                        extend: 'csv',
                        title: 'Experiment Unit CSV',
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
                            var table = $('#experiment_units').tableToJSON({
                                onlyColumns: [1, 2, 3, 4]
                            });

                            $.fn.dataTable.fileSave(
                                new Blob([JSON.stringify(table, null, '\t')]),
                                'Experiment Unit.json'
                            )
                        }
                    })
                }
            });

            $('#experiment_units').each(function() {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Search');
                search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
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
        $('.checkSingle').click(function() {
            if ($('.checkSingle:checked').length == $('.checkSingle').length) {
                $('#example-select-all').prop('checked', true);
            } else {
                $('#example-select-all').prop('checked', false);
            }
        });
    });
    $('.checkSingle').click(function() {
        var len = $("[name='select_all[]']:checked").length;
        if (len > 1) {
            $(".deletebulk").show();
        } else {
            $(".deletebulk").hide();
        }
        if (len == $('.checkSingle').length) {
            $('#example-select-all').prop('checked', true);
        } else {
            $('#example-select-all').prop('checked', false);
        }
    });

    // $(function() {
    //     if (cnt > 0) {
    //         $('#exportLink').show();
    //         $('#experiment_units').DataTable({

    //             dom: 'Bfrtip',
    //             buttons: [{
    //                     extend: 'csv',
    //                     title: 'Experiment Unit CSV',
    //                     text: 'Export to CSV',
    //                     //Columns to export
    //                     exportOptions: {
    //                         columns: [1, 2, 3, 4]
    //                     }
    //                 },

    //                 {
    //                     text: 'JSON',
    //                     action: function(e, dt, button, config) {
    //                         var data = dt.buttons.exportData();
    //                         $.fn.dataTable.fileSave(
    //                             new Blob([JSON.stringify(data)]),
    //                             'Export.json'
    //                         );
    //                     }
    //                 }
    //             ],
    //             initComplete: function() {
    //                 var $buttons = $('.dt-buttons').hide();
    //                 $('#exportLink').on('change', function() {
    //                     var btnClass = $(this).find(":selected")[0].id ?
    //                         '.buttons-' + $(this).find(":selected")[0].id :
    //                         null;
    //                     if (btnClass) $buttons.find(btnClass).click();
    //                     if (btnClass == '.buttons-json') {
    //                         var table = $('#experiment_units').tableToJSON({
    //                             onlyColumns: [1, 2, 3, 4]
    //                         });

    //                         $.fn.dataTable.fileSave(
    //                             new Blob([JSON.stringify(table, null, '\t')]),
    //                             'Experiment Unit.json'
    //                         )
    //                     }
    //                 })
    //             }
    //         });
    //     }
    // });

    function cloneExpUnit(val) {
        var experiment_unit_id = val;
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false,
        })
        swalWithBootstrapButtons.fire({
            title: 'Do you want to give Experiment unit name?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'ml-2',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                document.getElementById('pid').value = experiment_unit_id;
                $(".my_product").modal("show");
            } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
            ) {
                if (experiment_unit_id != "") {
                    var objectexp = {
                        "tab": "clone",
                        "experiment_unit_id": experiment_unit_id
                    };
                    //document.getElementById('expprofileSpinner').style.display = '';
                    event.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: '{{ url("/experiment/experiment_units/clone") }}',
                        data: JSON.stringify(objectexp),
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(data) {
                            if (data.success === true) {
                                const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                                Toast.fire({
                                    icon: 'success',
                                    title: data.message,
                                })
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: data.errors,
                                })
                            }
                            //document.getElementById('expprofileSpinner').style.display = 'none';
                            let url = "{{ url('experiment/experiment_units') }}";
                            document.location.href = url;
                        },
                    });
                }
            }
        })
    }

    function saveData() {
        var experiment_unit_id = document.getElementById('pid').value;
        if (experiment_unit_id != "") {
            var objectexp = {
                "tab": "clone",
                "experiment_unit_id": document.getElementById('pid').value,
                "name": document.getElementById('name').value
            };
            //document.getElementById('expprofileSpinner1').style.display = '';
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '{{ url("/experiment/experiment_units/clone") }}',
                data: JSON.stringify(objectexp),
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.success === true) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        Toast.fire({
                            icon: 'success',
                            title: data.message,
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.errors,
                        })
                    }
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $(".my_product").modal("hide");
                    let url = '{{ url("experiment/experiment_units") }}';
                    document.location.href = url;
                },
            });
        }
    }
</script>
@endpush