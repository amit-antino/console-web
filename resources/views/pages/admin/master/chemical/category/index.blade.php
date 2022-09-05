@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Category</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Category</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <button type="button" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" data-toggle="modal" data-target="#categoryModal">
            <i class="btn-icon-prepend " data-feather="plus"></i>
            Create Category
        </button>
        <button type="button" data-url="{{url('/admin/master/chemical/category/bulk-delete')}}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger deletebulk btn-icon-text mb-2 mb-md-0">
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
                                <th>Category Name</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $cnt=count($category)
                            @endphp
                            @if(!empty($category))
                            @foreach($category as $cat)
                            <tr>
                                <td><input type="checkbox" value="{{___encrypt($cat->id)}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{$cat->name}}</td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" data-url="{{url('/admin/master/chemical/category/'.___encrypt($cat->id).'?status='.$cat->status)}}" data-ask="Are you sure ? You want change Status." data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" id="customSwitch{{___encrypt($cat->id)}}" @if($cat->status=='pending') disabled @endif
                                        @if($cat->status=='active') checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{___encrypt($cat->id)}}"></label>
                                    </div>
                                </td>
                                <td class="text-center">

                                    <div class="btn-group btn-group-sm" role="group">
                                            <a href="javascript:void(0);" data-url="{{url('/admin/master/chemical/category/'.___encrypt($cat->id).'/edit')}}" data-request="ajax-popup" data-target="#edit-div" data-tab="#editcategoryModal{{___encrypt($cat->id)}}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Category">
                                                <i class="fas fa-edit  text-secondary"></i>
                                            </a>
                                            <a href="javascript:void(0);" data-url="{{url('admin/master/chemical/category/'.___encrypt($cat->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete Category">
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
@include('pages.admin.master.chemical.category.create')

@endsection
<div id="edit-div">
</div>
@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    var cnt = "{{$cnt}}"
    $(function() {
        if(cnt>10){
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
</script>
@endpush