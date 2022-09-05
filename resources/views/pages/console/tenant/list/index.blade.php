@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Lists</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Lists</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a href="{{url('/organization/list/create')}}"
            class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
            <i class="fas fa-plus" ></i>&nbsp;
            Add List
        </a>
        <div class="deletebulk">
            <button type="button" data-url="{{url('/organization/list/bulk-delete')}}" data-method="POST"
                data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?"
                data-id="bulk-delete" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
                <i class="fas fa-trash" ></i>
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
                    <table id="lists" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="example-select-all"></th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Classification</th>
                                <th>Compilation</th>
                                <th class="text-center">Updated Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $cnt = count($regulatory_list_info)
                            @endphp
                            @if(!empty($regulatory_list_info))
                            @foreach($regulatory_list_info as $key =>$value)
                            <tr>
                                <td><input type="checkbox" value="{{___encrypt($value['id'])}}" class="checkSingle"
                                        name="select_all[]"></td>
                                <td>
                                    {{$value['list_name']}}
                                    <span><i class="icon-sm" style="color:{{$value['color_code']}}"
                                            data-feather="alert-triangle" data-toggle="tooltip" data-placement="top"
                                            title="Color Code - {{$value['color_code']}}"></i></span>
                                </td>
                                <td>{{$value['category']}}</td>
                                <td>{{$value['classification']}}</td>
                                <td>@if($value['compilation']=='int')Internal @else External @endif</td>
                                <td class="text-center">{{$value['updated_at']}}</td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox"
                                            data-url="{{url('/organization/list/'.___encrypt($value['id']).'?status='.$value['status'])}}"
                                            data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning"
                                            class="custom-control-input" id="customSwitch{{___encrypt($value['id'])}}"
                                            @if($value['status']=='active') checked @endif>
                                        <label class="custom-control-label"
                                            for="customSwitch{{___encrypt($value['id'])}}"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                            <a href="{{url('/organization/list/'.___encrypt($value['id']))}}"
                                                class="btn btn-icon" data-toggle="tooltip" data-placement="bottom"
                                                title="View Lists">
                                                <i class="fas fa-eye text-secondary"></i> 
                                            </a>
                                            <a href="{{url('/organization/list/'.___encrypt($value['id']).'/edit')}}"
                                                class="btn btn-icon" data-toggle="tooltip" data-placement="bottom"
                                                title="Edit Lists">
                                                <i class="fas fa-edit text-secondary"></i> 
                                            </a>
                                            <a href="javascript:void(0);"
                                                data-url="{{url('/organization/list/'.___encrypt($value['id']))}}"
                                                data-method="DELETE" data-request="ajax-confirm"
                                                data-ask_image="warning" data-ask="Are you sure you want to delete?"
                                                class="btn btn-icon" data-toggle="tooltip" data-placement="bottom"
                                                title="Delete List">
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
    var cnt= '{{$cnt}}'
    $(function () {
        if(cnt>10){
            $('#lists').DataTable();
        }
        $('.deletebulk').hide();

        $("#example-select-all").click(function () {
            if ($(this).is(":checked")) {
                $(".deletebulk").show();
            } else {
                $(".deletebulk").hide();
            }
            $('.checkSingle').not(this).prop('checked', this.checked);
            $('.checkSingle').click(function () {
                if ($('.checkSingle:checked').length == $('.checkSingle').length) {
                    $('#example-select-all').prop('checked', true);
                } else {
                    $('#example-select-all').prop('checked', false);
                }
            });
        });
        $('.checkSingle').click(function () {
            var len = $("[name='select_all[]']:checked").length;
            if (len > 1) {
                $(".deletebulk").show();
            } else {
                $(".deletebulk").hide();
            }

        });
    });

</script>
@endpush
