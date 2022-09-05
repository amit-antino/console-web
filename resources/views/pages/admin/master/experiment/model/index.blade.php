@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/tenant') }}">Tenants</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/tenant/manage/'.$tenant_id) }}">{{get_tenant_name($tenant_id)}} Manage</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/tenant/'.$tenant_id.'/experiment') }}">Experiment Manage</a></li>
        <li class="breadcrumb-item active" aria-current="page">Experiment Models</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Models</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a href="{{url('admin/tenant/'.$tenant_id.'/experiment/models/create')}}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
            <i class="fas fa-plus"></i>
            Add Models
        </a>
        <div class="deletebulk">
            <button type="button" data-url="{{url('admin/tenant/'.$tenant_id.'/experiment/models/bulk-delete')}}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
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
                                $cnt = count($models)
                            @endphp
                            @if(!empty($models))
                            @foreach($models as $model)
                            <tr>
                                <td><input type="checkbox" value="{{$model->id}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{$model->name}}</td>
                                <td>{{$model->description}}</td>
                                <td>{{$model->name}}</td>
                                <td>{{$model->version}}</td>
                                <td>{{$model->association}}</td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" data-url="{{url('admin/tenant/'.$tenant_id.'/experiment/models/'.___encrypt($model->id).'?status='.$model->operation_status)}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" class="custom-control-input" data-ask="Are you sure you want to change status?" id="customSwitch{{$model->id}}" @if($model->operation_status=='active' ) checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{$model->id}}"></label>
                                    </div>
                                </td>
                                <td class="text-center">


                                    <div class="btn-group btn-group-sm" role="group">
                            
                                            <a href="{{url('admin/tenant/'.$tenant_id.'/experiment/models/'.___encrypt($model->id).'/edit')}}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="edit">
                                                <i class="fas fa-edit text-secondary"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-url="{{url('admin/tenant/'.$tenant_id.'/experiment/models/'.___encrypt($model->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="top" title="Delete Models">
                                                <i class="fas fa-trash text-secondary"></i>
                                            </a>


                                        </div>
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
    var cnt ='{{$cnt}}'
    if(cnt>10){
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