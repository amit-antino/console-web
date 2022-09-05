@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Product System Comparison </li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Product System Comparison</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <?php
        if ($product_sys_count >= 2) {
        ?>
            <a href="/product_system/comparison/create" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
                <i class="fas fa-plus"></i>
                Create New Product System Comparison
            </a>
        <?php
        } else {
        ?>
            <a href="javascript:void(0)" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" onclick="alertconfirmation('You are not allowed to create product system comparison, please create more than 1 product system first.','warning','/product_system/product/create')">
                <i class="fas fa-plus"></i>
                Create New Product System Comparison
            </a>
        <?php
        }
        ?>
        <div class="deletebulk">
            <button type="button" data-url="{{url('/product_system/comparison/bulk-delete')}}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
                <i class="fas fa-delete"></i>
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
                    <table id="cmp_tbl" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="example-select-all"></th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Status </th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $cnt = count($data)
                            @endphp
                            @if(!empty($data))
                            @foreach($data as $value)
                            <tr>
                                <td><input type="checkbox" value="{{___encrypt($value['id'])}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{$value['comparison_name']}}</td>
                                <td>{{$value['description']}}</td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" data-url="{{url('/product_system/comparison/'.___encrypt($value['id']).'?status='.$value['status'])}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you Change Status ?" class="custom-control-input" id="customSwitch{{___encrypt($value['id'])}}" @if($value['status']=='active' ) checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{___encrypt($value['id'])}}"></label>
                                    </div>
                                </td>
                                <td class="text-center">

                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ url('/product_system/comparison/'.___encrypt($value['id']))}}" type="button" class="btn btn-icon" data-toggle=" tooltip" data-placement="bottom" title="View Product System">
                                            <i class="fas fa-eye text-secondary"></i>
                                        </a>
                                        <a href="{{url('/product_system/comparison/'.___encrypt($value['id']).'/edit')}}" class="btn btn-icon" data-toggle=" tooltip" data-placement="bottom" title="Edit Lists">
                                            <i class="fas fa-edit text-secondary "></i>
                                        </a>
                                        <a href="javascript:void(0);" data-url="{{url('/product_system/comparison/'.___encrypt($value['id']))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete List">
                                            <i class="fas fa-trash text-secondary "></i>
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
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/promise-polyfill/polyfill.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    var cnt = '{{$cnt}}'
    if (cnt > 10) {
        $('#cmp_tbl').dataTable({
            "iDisplayLength": 100,
            "autoWidth": true
        });
    }
    //{{ URL::to('/product_system/comparison/1/edit') }}

    $('.deletebulk').hide();


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
</script>
@endpush