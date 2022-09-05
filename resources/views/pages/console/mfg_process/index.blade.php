@extends('layout.console.master')
@push('plugin-styles')
<link href="{{asset('assets/plugins/datatables-net/dataTables.bootstrap4.css')}}" rel="stylesheet" />
@endpush
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">MFG Process Simulation</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">MFG Process Simulation</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a href="{{url('mfg_process/simulation/create')}}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
            <i class="fas fa-plus"></i>&nbsp;
            Add Process Simulation
        </a>
        <div class="deletebulk">
            <button type="button" data-url="{{url('/mfg_process/simulation/bulk-delete')}}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
                <i class="fas fa-trash"></i>&nbsp;
                Delete
            </button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="process_simulation" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="example-select-all"></th>
                                <th>Process Simulation Name</th>
                                <th>Process Category</th>
                                <th>Main Feed</th>
                                <th>Main Product</th>
                                <th>Dataset Count</th>
                                <th>Process Status</th>
                                <th>Created at</th>
                                <th>Updated at</th>
                                <th class="text-center">Status</th>
                                <th style="width:150px">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $cnt=count($data);
                            @endphp
                            @foreach($data as $key => $value)
                            <tr>
                                <td><input type="checkbox" value="{{___encrypt($value['id'])}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{$value['process_name']}}</td>
                                <td><span data-toggle="tooltip" data-placement="top" title="@if($value['processCategorydescription']!=""){{$value['processCategory']}}@endif">{{$value['processCategory']}} </span></td>
                                <td><span data-toggle="tooltip" data-placement="top" title="@if($value['main_feedstock']!=""){{$value['main_feedstock']}}@endif">{{$value['main_feedstock']}} </span></td>
                                <td><span data-toggle="tooltip" data-placement="top" title="@if($value['main_product']!=""){{$value['main_product']}}@endif">{{$value['main_product']}} </span></td>
                                <td><span data-toggle="tooltip" data-placement="top">{{$value['dataset']}}</span></td>
                                <td><span data-toggle="tooltip" data-placement="top" title="@if($value['processStatusdescription']!=""){{$value['processStatusdescription']}}@endif">{{$value['processStatus']}}</span></td>
                                <td>{{dateTimeFormate($value['created_at'])}}</td>
                                <td>{{dateTimeFormate($value['updated_at'])}}</td>
                                <td class=" text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" data-url="{{url('/mfg_process/simulation/'.___encrypt($value['id']).'?status='.$value['status'])}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you Change Status ?" class="custom-control-input" id="customSwitch{{___encrypt($value['id'])}}" @if($value['status']=='active' ) checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{___encrypt($value['id'])}}"></label>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <!-- <a href="javascript:void(0);" type="button" data-url="{{url('/mfg_process/simulation/'.___encrypt($value['id']).'/copy_to_knowledge')}}" type="button" class="btn btn-icon" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to move this to Knowledge Bank?" data-id="copy_to_knowledge" class="dropdown-item" data-toggle=" tooltip" data-placement="bottom" title="Copy to Knowledge Bank">
                                            <i class="fas fa-database  text-secondary"></i>
                                        </a>  -->
                                        <a href="javascript:void(0);" data-url="{{ url('mfg_process/simulation/'.___encrypt($value['id']).'/replicate')}}" data-request="ajax-popup" data-target="#edit-div" data-tab="#SimulationModal{{___encrypt($value['id'])}}" type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Clone Process Simulation">
                                            <i class="fas fa-copy text-secondary"></i>
                                        </a>
                                        <a href="{{ url('mfg_process/simulation/'.___encrypt($value['id']).'/manage')}}" type="button" class="btn btn-icon" data-toggle=" tooltip" data-placement="bottom" title="Manage Process Simulation Profile">
                                            <i class="fas fa-cog  text-secondary"></i>
                                        </a>
                                        <a href="{{url('/mfg_process/simulation/'.___encrypt($value['id']).'/view')}}" type="button" class="btn btn-icon" data-toggle=" tooltip" data-placement="bottom" title="Manage Process Simulation Profile">
                                            <i class="fas fa-eye  text-secondary"></i>
                                        </a>
                                        <a href="{{url('/mfg_process/simulation/'.___encrypt($value['id']).'/edit')}}" type="button" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Process Simulation">
                                            <i class="fas fa-edit  text-secondary"></i>
                                        </a>
                                        <a href="javascript:void(0);" data-url="{{url('/mfg_process/simulation/'.___encrypt($value['id']))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" type="button" class="btn btn-icon" data-toggle=" tooltip" data-placement="bottom" title="Delete Process Simulation">
                                            <i class="fas fa-trash  text-secondary"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="edit-div"></div>

@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    var cnt = '{{$cnt}}'
    $(function() {
        if (cnt > 10) {
            $('#process_simulation').DataTable({
                "iDisplayLength": 100,
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
    //select_all
    $('.checkSingle').click(function() {

        var len = $("[name='select_all[]']:checked").length;
        if (len > 1) {
            $(".deletebulk").show();
        } else {
            $(".deletebulk").hide();
        }
    });
</script>
@endpush