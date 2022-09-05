@extends('layout.console.master')
@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css')}}" rel="stylesheet" />
@endpush

@php 
$per = request()->get('sub_menu_permission');
$permission=!empty($per['profile']['method'])?$per['profile']['method']:[];
@endphp

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Reactions</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Reactions</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block"
        @if(in_array('create',$permission))
            href="{{url('/other_inputs/reaction/create')}}"
        @else
            data-request="ajax-permission-denied"
        @endif
        >
            <i class="fas fa-plus"></i>&nbsp;
            Add Reaction
        </a>
        <div class="deletebulk">
            <button type="button"  data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0"
            @if(in_array('delete',$permission))
                data-url="{{url('/other_inputs/reaction/bulk-delete')}}"
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
                    <table id="reaction_list" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="example-select-all"></th>
                                <th>Reaction Name</th>
                                <th>Reaction Source</th>
                                <th>Reactant</th>
                                <th>Products</th>
                                <th>Reaction</th>
                                <th>Stoichiometric State</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $cnt = count($reactions)
                            @endphp
                            @if(!empty($reactions))
                            @foreach($reactions as $reaction)
                            <tr>
                                <td><input type="checkbox" value="{{___encrypt($reaction['id'])}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{$reaction['reaction_name']}}</td>
                                <td>{{$reaction['reaction_source']}}</td>
                                <td>{{(isset($reaction['reaction_chem_name'])) ? $reaction['reaction_chem_name'] :""}}</td>
                                <td>{{(isset($reaction['product_chem_name'])) ? $reaction['product_chem_name'] :""}}</td>
                                <td>
                                    @if(!empty($reaction['chemical_reaction_left']))
                                    {{$reaction['chemical_reaction_left']}} ||
                                    @endif
                                    {{$reaction['chemical_reaction_right']}}
                                </td>
                                <td>{{!empty($reaction['balance'])?$reaction['balance']:'Not Balanced'}}</td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" data-url="{{url('/other_inputs/reaction/'.___encrypt($reaction['id']).'?status='.$reaction['status'])}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" class="custom-control-input" id="customSwitch{{___encrypt($reaction['id'])}}" @if($reaction['status']=='active' ) checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{___encrypt($reaction['id'])}}"></label>
                                    </div>
                                </td>
                                <td class="text-center">


                                    <div class="btn-group btn-group-sm" role="group">

                                            <a  class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Manage Properties for a Reaction"
                                            @if(in_array('manage',$permission))
                                                href="{{url('/other_inputs/reaction/'.___encrypt($reaction['id']).'/addprop')}}"
                                            @else
                                                data-request="ajax-permission-denied"
                                            @endif
                                            >
                                                <i class="fas fa-cogs text-secondary"></i> 
                                            </a>
                                            <a class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="View Reaction"
                                            @if(in_array('read',$permission))
                                                href="{{url('/other_inputs/reaction/'.___encrypt($reaction['id']))}}"
                                            @else
                                                data-request="ajax-permission-denied"
                                            @endif
                                            >
                                                <i class="fas fa-eye text-secondary"></i> 
                                            </a>
                                            <a class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Reaction"
                                            @if(in_array('edit',$permission))
                                                href="{{url('/other_inputs/reaction/'.___encrypt($reaction['id']).'/edit')}}"
                                            @else
                                                data-request="ajax-permission-denied"
                                            @endif
                                            >
                                                <i class="fas fa-edit text-secondary"></i> 
                                            </a>
                                            <a href="javascript:void(0);"  data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete Reaction"
                                            @if(in_array('delete',$permission))
                                                data-url="{{url('/other_inputs/reaction/'.___encrypt($reaction['id']))}}"
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
<script src="{{ asset('/assets/plugins/datatables-net/jquery.dataTables.js')}}"></script>
<script src="{{ asset('/assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js')}}"></script>
@endpush

@push('custom-scripts')
<script>
    var cnt='{{$cnt}}'
    if(cnt>10){
        $(function() {
            $('#reaction_list').DataTable();
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