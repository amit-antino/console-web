@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>

        <li class="breadcrumb-item active" aria-current="page">Tickets</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Reported Issues</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">


    </div>
</div>
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="user_list" class="table table-hover mb-0">
                        <thead>
                            <th><input type="checkbox" id="example-select-all"></th>
                            <th>Title</th>
                            <th>Issue Type</th>
                            <th>Created By</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </thead>
                        <tbody>
                            @if(!empty($data))
                            @foreach($data as $val)
                            <tr>
                                <td><input type="checkbox" value="{{___encrypt($val['id'])}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{$val->title}}</td>
                                @php
                                if($val->type==0)
                                $type="Feedback";
                                elseif($val->type==1)
                                $type="Bug ";
                                elseif($val->type==3)
                                $type="Questions ";
                                else
                                $type="Feature Request";
                                @endphp
                                <td>{{$type}}</td>

                                <td>
                                    @php
                                    $uname=getUser($val['created_by'])
                                    @endphp
                                    {{$uname['username']}}
                                </td>

                                <td class="text-center">
                                    @php
                                    if($val['status']=='active')
                                    $status="Closed";
                                    elseif($val['status']=='pending')
                                    $status="Open ";
                                    else
                                    $status="In Review";
                                    @endphp
                                    {{$status}}
                                </td>
                                <!-- <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button id="btnGroupDrop1"  class="btn btn-sm btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-cogs fa-sm"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">


                                            <a class="dropdown-item" href="{{url('admin/ticket/'.___encrypt($val->id))}}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="View Ticket">
                                                <i class="fas fa-edit"></i> view
                                            </a>


                                        </div>
                                    </div>
                                </td> -->
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a class="btn btn-icon" href="{{url('admin/ticket/'.___encrypt($val->id))}}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="View Issue">
                                            <i class="fas fa-eye text-secondary"></i>
                                        </a>
                                        <a class="btn btn-icon" href="javascript:void(0);" data-url="{{url('admin/ticket/'.___encrypt($val->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete Issue">
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
    $(function() {
        $('#user_list').DataTable();
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