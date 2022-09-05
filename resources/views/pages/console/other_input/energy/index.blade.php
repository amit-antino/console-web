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
        <li class="breadcrumb-item active" aria-current="page">Energy & Utilities</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Energy & Utilities</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a  class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block"
            @if(in_array('create',$permission))
                href="{{url('/other_inputs/energy/create')}}"
            @else
                data-request="ajax-permission-denied" href="javascript:void(0);"
            @endif
        >
            <i class="fas fa-plus"></i>&nbsp;
            Add Energy & Utilities
        </a>
        <div class="deletebulk">
            <button type="button"  data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0"
            @if(in_array('delete',$permission))
                data-url="{{url('/other_inputs/energy/bulk-delete')}}"
            @else
                data-request="ajax-permission-denied"
            @endif
            >
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
                    <table id="energy_utilities" class="table table-hover mb-0">
                        <thead>
                            <th><input type="checkbox" id="example-select-all"></th>
                            <th>Name</th>
                            <th>Base Unit Type</th>
                            <th>Vendors</th>
                            <th>Location</th>
                            <th class="text-center">Status</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            @php 
                                $cnt = count($energy_utilities)
                            @endphp
                            @if(!empty($energy_utilities))
                            @foreach($energy_utilities as $energy_utility)
                            <tr>
                                <td><input type="checkbox" value="{{___encrypt($energy_utility->id)}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{$energy_utility->energy_name}}</td>
                                <td>{{$energy_utility->unit_type->unit_name}}</td>
                                <td>{{!empty($energy_utility->vendor->name)?$energy_utility->vendor->name:''}}</td>
                                <td>{{!empty($energy_utility->country->name)?$energy_utility->country->name:''}}</td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" data-url="{{url('/other_inputs/energy/'.___encrypt($energy_utility->id).'?status='.$energy_utility['status'])}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you Change Status ?" class="custom-control-input" id="customSwitch{{___encrypt($energy_utility->id)}}" @if($energy_utility->status=='active' ) checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{___encrypt($energy_utility->id)}}"></label>
                                    </div>
                                </td>
                                <td>


                                    <div class="btn-group btn-group-sm" role="group">
                                        <a class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Manage of Energy Utility"
                                        @if(in_array('manage',$permission))
                                            href="{{url('/other_inputs/energy/'.___encrypt($energy_utility->id).'/addprop')}}"
                                        @else
                                            data-request="ajax-permission-denied"
                                        @endif
                                        >
                                            <i class="fas fa-cogs text-secondary"></i>
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="View Energy Utility"
                                        @if(in_array('read',$permission))
                                            data-url="{url('/other_inputs/energy/'.___encrypt($energy_utility->id))}}"
                                        @else
                                            data-request="ajax-permission-denied"
                                        @endif
                                        >
                                            <i class="fas fa-eye text-secondary"></i>
                                        </a>
                                        <a  class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Energy Utility"
                                        @if(in_array('edit',$permission))
                                            href="{{url('/other_inputs/energy/'.___encrypt($energy_utility->id).'/edit')}}"
                                        @else
                                            data-request="ajax-permission-denied"
                                        @endif
                                        >
                                            <i class="fas fa-edit text-secondary"></i>
                                        </a>
                                        <a href="javascript:void(0);" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle=" tooltip" data-placement="bottom" title="Delete Energy Utility"
                                        @if(in_array('delete',$permission))
                                            data-url="{{url('/other_inputs/energy/'.___encrypt($energy_utility->id))}}"
                                        @else
                                            data-request="ajax-permission-denied"
                                        @endif
                                        >
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
@endsection

@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    var cnt='{{$cnt}}'
    if(cnt>10){
        $(function() {
            $('#energy_utilities').DataTable();
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