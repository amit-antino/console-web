@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
        <!-- <li class="breadcrumb-item"><a href="">Data Management</a></li> -->
        <li class="breadcrumb-item active" aria-current="page">Data Sets</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Data Sets</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <button type="button" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" data-toggle="modal" data-target="#ProjectModal">
            <i class="btn-icon-prepend " data-feather="plus"></i>
            Create Data Sets
        </button>
        <button type="button" data-url="{{url('data_management/data_sets/bulk-delete')}}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger deletebulk btn-icon-text mb-2 mb-md-0">
            <i class="btn-icon-prepend" data-feather="trash"></i>
            Delete
        </button>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="plan_list" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="example-select-all"></th>
                                <th>Dataset Name</th>
                                <th>File Name</th>
                                <th>Created Date</th>
                                <th>No. of Experiments</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $cnt=count($data_sets)
                            @endphp
                            @if(!empty($data_sets))
                            @foreach($data_sets as $pro)
                            @php $count = count(!empty($pro->experiment_data)?$pro->experiment_data:[]); @endphp
                            <tr>
                                <td><input type="checkbox" value="{{___encrypt($pro->id)}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{$pro->name}}</td>
                                <td><a href="{{url($pro->experiment_file)}}" download="">Download File</a></td>
                                <td>{{dateFormate($pro->created_at)}}</td>
                                <td>{{$count}}</td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" data-url="{{url('data_management/data_sets/'.___encrypt($pro->id).'?status='.$pro->status)}}" data-ask="Are you sure ? You want change Status." data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" id="customSwitch{{___encrypt($pro->id)}}" @if($pro->status=='active') checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{___encrypt($pro->id)}}"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="javascript:void(0);" data-request="ajax-popup" data-url="{{url('data_management/data_sets/'.___encrypt($pro->id))}}" data-tab="#editProjectModal{{___encrypt($pro->id)}}" data-target="#edit-div" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="view Dataset">
                                            <i class="fas fa-eye  text-secondary"></i>
                                        </a>
                                        <a href="javascript:void(0);" data-url="{{url('data_management/data_sets/'.___encrypt($pro->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete Dataset">
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
@include('pages.console.data_management.data_sets.create')
<div id="edit-div">
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
<script src="{{asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
<script src="{{asset('assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    var cnt = "{{$cnt}}"
    $(function() {
        if (cnt > 10) {
            $('#plan_list').DataTable();
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
    $('#tags').tagsInput({
        'interactive': true,
        'defaultText': 'Add More',
        'removeWithBackspace': true,
        'width': '100%',
        'height': '84px',
        'placeholderColor': '#666666'
    });

    if ($(".js-example-basic-multiple").length) {
        $(".js-example-basic-multiple").select2();
    }
</script>
@endpush