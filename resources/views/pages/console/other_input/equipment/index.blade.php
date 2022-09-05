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
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Equipments</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Equipments</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" @if(in_array('create',$permission)) href="{{url('/other_inputs/equipment/create')}}" @else data-request="ajax-permission-denied" @endif>
            <i class="fas fa-plus"></i>&nbsp;
            Add an Equipment
        </a>
        <div class="deletebulk">
            <button type="button" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0" @if(in_array('delete',$permission)) data-url="{{url('/other_inputs/equipment/bulk-delete')}}" @else data-request="ajax-permission-denied" @endif>
                <i class="fas fa-trash"></i>&nbsp;
                Delete
            </button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="equipment_list" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="example-select-all"></th>
                                <th>Name</th>
                                <th>Supplier</th>
                                <th class="text-center">Installation Date</th>
                                <th class="text-center">Purchased Date</th>
                                <th class="text-center">Availability</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $cnt = count($equipments)
                            @endphp
                            @if(!empty($equipments ))
                            @foreach($equipments as $equipment)
                            <tr>
                                <td><input type="checkbox" value="{{___encrypt($equipment->id)}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{$equipment->equipment_name}}</td>
                                <td>{{!empty($equipment->vendor->name)?$equipment->vendor->name:''}}</td>
                                <td class="text-center">{{dateFormate($equipment->installation_date)}}</td>
                                <td class="text-center">{{dateFormate($equipment->purchased_date)}}</td>
                                @if($equipment->availability=='true')
                                <td class="text-center"><i class="fas fa-check-circle fa-2x text-success"></i></td>
                                @else
                                <td class="text-center"><i class="fas fa-times-circle fa-2x text-danger"></i></td>
                                @endif
                                <td class="text-center">
                                    <input type="hidden" name="equipment_id" value="">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" data-url="{{url('/other_inputs/equipment/'.___encrypt($equipment->id).'?status='.$equipment->status)}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" class="custom-control-input" id="customSwitch{{___encrypt($equipment->id)}}" @if($equipment->status=='active') checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{___encrypt($equipment->id)}}"></label>
                                    </div>
                                </td>
                                <td class="text-center">


                                    <div class="btn-group btn-group-sm" role="group">
                                        <a class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="View Equipment" @if(in_array('read',$permission)) href="{{url('/other_inputs/equipment/'.___encrypt($equipment->id))}}" @else data-request="ajax-permission-denied" @endif>
                                            <i class="fas fa-eye text-secondary"></i>
                                        </a>
                                        <a class="btn btn-icon" data-toggle="tooltip" data-placement="top" title="Edit Equipment" @if(in_array('edit',$permission)) href="{{url('/other_inputs/equipment/'.___encrypt($equipment->id).'/edit')}}" @else data-request="ajax-permission-denied" @endif>
                                            <i class="fas fa-edit text-secondary"></i>
                                        </a>
                                        <a href="javascript:void(0);" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete Equipment" @if(in_array('delete',$permission)) data-url="{{url('/other_inputs/equipment/'.___encrypt($equipment->id))}}" @else data-request="ajax-permission-denied" @endif>
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
<div class="modal fade" id="equipmentModel" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userLabel">Create Equipment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('/other_inputs/equipment/importFile')}}" method="post" enctype="multipart/form-data" role="chemicals-import">
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
                        <a href="{{url('sample_import/equipment_sample_format.xlsx')}}" download="" class="btn btn-info">Download Sample</a>
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
<script src="{{ asset('/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    var cnt = '{{$cnt}}'
    if (cnt > 10) {
        $(function() {
            $('#equipment_list').DataTable();
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