@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush
@php
$per = request()->get('sub_menu_permission');
$permission=!empty($per['profile']['method'])?$per['profile']['method']:[];
@endphp
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Experiments</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h5 class="mb-3 mb-md-0 text-uppercase font-weight-normal">Experiments</h5>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        @if(in_array('create',$permission))
        <a href="{{ url('/experiment/experiment/create') }}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
            <i class="fas fa-plus"></i>&nbsp;&nbsp;Add Experiment
        </a>
        @endif
        @if(!empty(get_quide_doc('experiment')))
        <a href="{{ url(get_quide_doc('experiment')) }}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
            <i class="fas fa-download"></i>&nbsp;&nbsp;User Guide
        </a>
        @endif
        @if(in_array('delete',$permission))
        <div class="deletebulk">
            <button type="button" data-url="{{ url('/experiment/experiment/bulk-delete') }}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
                <i class="fas fa-trash"></i>&nbsp;&nbsp;Delete
            </button>
        </div>
        @endif
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="text-center">
                    <div id="expprofileSpinner" class="spinner-border text-secondary" style="width: 2rem; height: 2rem;display: none; margin-top:25px;" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="process_experiments" class="table">
                        <thead>
                            <th><input type="checkbox" id="example-select-all"></th>
                            <th>Name</th>
                            <th>Project</th>
                            <th class="text-center">Variation</th>
                            <th class="text-center">Simulate Input</th>
                            <th>Category</th>
                            <th>Classification</th>
                            <th>Data Source</th>
                            <th>Created By</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </thead>
                        <tbody>
                            @php
                            $cnt=count($process_exp_list);
                            @endphp
                            @if(!empty($process_exp_list))
                            @foreach($process_exp_list as $process_experiment)
                            <tr>
                                <td><input type="checkbox" value="{{___encrypt($process_experiment['id'])}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{$process_experiment['name']}}</td>
                                <td>{{$process_experiment['project']}}</td>
                                <td class="text-center">{{$process_experiment['variation_count']}}</td>
                                <td class="text-center">{{$process_experiment['simInputcount']}}</td>
                                <td>{{$process_experiment['category']}}</td>
                                <td>
                                    @if(!empty($process_experiment['classification']))
                                    @foreach($process_experiment['classification'] as $classification)
                                    <span class="">{{$classification['name']}}</span>
                                    @endforeach
                                    @endif
                                </td>
                                <td>{{$process_experiment['data_source']}}</td>
                                <td>{{$process_experiment['created_by']}}</td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" data-url="{{ url('/experiment/experiment/'.___encrypt($process_experiment['id']).'?status='.$process_experiment['status']) }}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you Change Status ?" class="custom-control-input" id="customSwitch{{___encrypt($process_experiment['id'])}}" @if($process_experiment['status']=='active' ) checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{___encrypt($process_experiment['id'])}}"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        @if(in_array('manage',$permission))
                                        <a href="{{ url('/experiment/experiment/'.___encrypt($process_experiment['id']).'/manage') }}" type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Manage Experiment">
                                            <i class="fas fa-cogs text-secondary"></i>
                                        </a>
                                        @endif
                                        @php
                                        $pval=___encrypt($process_experiment['id'])
                                        @endphp
                                        <!-- <a href="javascript:void(0);" type="button" data-url="{{url('/experiment/experiment/'.___encrypt($process_experiment['id']).'/copy_to_knowledge')}}" type="button" class="btn btn-icon" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to move this to Knowledge Bank?" data-id="copy_to_knowledge" class="dropdown-item" data-toggle=" tooltip" data-placement="bottom" title="Copy to Knowledge Bank">
                                            <i class="fas fa-database  text-secondary"></i>
                                        </a> -->
                                        @if(in_array('create',$permission))
                                        <a href="javascript:void(0);" onclick='cloneExp("{{$pval}}")' type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Clone Experiment">
                                            <i class="fas fa-copy text-secondary"></i>
                                        </a>
                                        @endif
                                        <!-- <a href="{{ url('/experiment/experiment/'.___encrypt($process_experiment['id'])) }}" type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="View Experiment">
                                            <i class="fas fa-eye text-secondary"></i>
                                        </a> -->
                                        @if(in_array('index',$permission))
                                        <a href="{{ url('/experiment/experiment/'.___encrypt($process_experiment['id']).'/view') }}" type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="View Experiment">
                                            <i class="fas fa-eye text-secondary"></i>
                                        </a>
                                        @endif
                                        @if(in_array('edit',$permission))
                                        <!-- <a href="{{ url('/experiment/experiment/'.___encrypt($process_experiment['id']).'/edit') }}" type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Experiment">
                                            <i class="fas fa-edit text-secondary"></i>
                                        </a> -->
                                        @endif
                                        @if(in_array('delete',$permission))
                                        <a href="javascript:void(0);" data-url="{{ url('/experiment/experiment/'.___encrypt($process_experiment['id'])) }}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete Experiment">
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
                <h5 class="modal-title text-uppercase font-weight-normal" id="modal_logoutLabel">Clone Experiment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="process_experiment">Enter Name
                            <span class="text-danger">*</span>
                            <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Name"></i></span>
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
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    var cnt = '{{$cnt}}';
    $(function() {
        'use strict';
        if (cnt > 10) {
            $('#process_experiments').DataTable({
                "iDisplayLength": 100,
                // dom: 'Blfrtip',
                // buttons: [
                //     'copy', 'csv', 'excel', 'pdf', 'print'
                // ],
                "language": {
                    search: ""
                }
            });
            $('#process_experiments').each(function() {
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
    });

    function cloneExp(val) {
        var process_experiment_id = val;
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false,
        })
        swalWithBootstrapButtons.fire({
            title: 'Do you want to give Experiment name?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'ml-2',
            confirmButtonText: 'Yes!',
            cancelButtonText: 'No',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                document.getElementById('pid').value = process_experiment_id;
                $(".my_product").modal("show");
            } else if (
                // Read more about handling dismissals
                result.dismiss === Swal.DismissReason.cancel
            ) {
                if (process_experiment_id != "") {
                    var objectexp = {
                        "tab": "clone",
                        "process_experiment_id": process_experiment_id
                    };
                    document.getElementById('expprofileSpinner').style.display = '';
                    event.preventDefault();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'POST',
                        url: '{{ url("/experiment/experiment/clone") }}',
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
                            document.getElementById('expprofileSpinner').style.display = 'none';
                            let url = "{{ url('experiment/experiment') }}";
                            document.location.href = url;
                        },
                    });
                }
            }
        })
    }

    function saveData() {
        var process_experiment_id = document.getElementById('pid').value;
        if (process_experiment_id != "") {
            var objectexp = {
                "tab": "clone",
                "process_experiment_id": document.getElementById('pid').value,
                "name": document.getElementById('name').value
            };
            document.getElementById('expprofileSpinner1').style.display = '';
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '{{ url("/experiment/experiment/clone") }}',
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
                    let url = '{{ url("experiment/experiment") }}';
                    document.location.href = url;
                },
            });
        }
    }
    
</script>
@endpush