@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
@php
$per = request()->get('sub_menu_permission');
$permission=!empty($per['profile']['method'])?$per['profile']['method']:[];
@endphp
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Models</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Models</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a @if(in_array('create',$permission)) href="{{url('models/create')}}" @else data-request="ajax-permission-denied" @endif class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
            <i class="fas fa-plus"></i>&nbsp;
            Add Models
        </a>
        <div class="deletebulk">
            <button type="button" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0" @if(in_array('delete',$permission)) data-url="{{url('models/bulk-delete')}}" @else data-request="ajax-permission-denied" @endif>
                <i class="fas fa-trash"></i>
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
                    <table id="models_list" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="example-select-all"></th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Last Update</th>
                                <th>Version</th>
                                <th>Association</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $cnt=count($models)
                            @endphp
                            @if(!empty($models))
                            @foreach($models as $model)
                            <tr>
                                <td><input type="checkbox" value="{{___encrypt($model->id)}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{$model->name}}</td>
                                <td>{{$model->description}}</td>
                                <td>{{$model->updated_at}}</td>
                                <td>{{!empty($model->version)?$model->version:''}}</td>
                                <td>{{$model->association}}</td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" data-url="{{url('/models/'.___encrypt($model->id).'?status='.$model->status)}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" class="custom-control-input" id="customSwitch{{$model->id}}" @if($model->status=='active' ) checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{$model->id}}"></label>
                                    </div>
                                </td>
                                <td class="text-center">

                                    <div class="btn-group btn-group-sm" role="group">
                                        <a class="btn btn-icon" data-toggle=" tooltip" data-placement="bottom" title="edit" @if(in_array('edit',$permission)) href="{{url('/models/'.___encrypt($model->id).'/edit')}}" @else data-request="ajax-permission-denied" @endif>
                                            <i class="fas fa-edit text-secondary"></i>
                                        </a>
                                        <a href="javascript:void(0);" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="top" title="Delete Models" @if(in_array('delete',$permission)) data-url="{{url('models/'.___encrypt($model->id))}}" @else data-request="ajax-permission-denied" @endif>
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
    var cnt = '{{$cnt}}'
    if (cnt > 10) {
        $('#models_list').DataTable();
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