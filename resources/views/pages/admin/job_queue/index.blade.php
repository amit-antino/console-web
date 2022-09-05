@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>

        <li class="breadcrumb-item active" aria-current="page">Job & Queue</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0"> Job & Queue</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <button type="button" data-url="{{ url('/admin/job-queue/bulk-delete') }}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger deletebulk btn-icon-text mb-2 mb-md-0">
            <i class="btn-icon-prepend" data-feather="trash"></i>
            Delete
        </button>
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
                            <th>Job</th>
                            <th>Total</th>
                            <th>Success</th>
                            <th>Failed</th>
                            <th>Pending</th>
                            <th>Created By</th>
                            <th>Created Date</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </thead>
                        <tbody>
                            @php
                            $cnt = count($jobslist);
                            @endphp
                            @if (!empty($jobslist))
                            @foreach ($jobslist as $list)
                            <tr>
                                <td><input type="checkbox" value="{{ isset($list->jobs)?___encrypt($list->id).'@job':___encrypt($list->id).'@sim' }}" class="checkSingle" name="select_all[]"></td>
                                <td>{{isset($list->jobs)?$list->jobs:'simpuation Input Excel'}}</td>
                                <td>
                                <?php
                                    $type='jobqueue';
                                    if(isset($list->jobs))
                                    {
                                        $total=sizeof(json_decode(json_decode($list->queue_data)->data));
                                        echo sizeof(json_decode(json_decode($list->queue_data)->data));
                                    }
                                    else
                                    {
                                        $type='simulateinputjob';
                                        if($list->tenant_id>0)
                                            $inputFileName=public_path('assets/uploads/simulation_input_excel/'.$list->tenant_id.'/'.$list->excel_file);
                                        else
                                            $inputFileName=public_path('assets/uploads/simulation_input_excel/'.$list->excel_file);
                                        if(file_exists($inputFileName))
                                        {
                                            $row =  Excel::toArray([],$inputFileName);
                                            $total=sizeof($row[0])-3;
                                        }
                                        else
                                           $total=0; 
                                        echo $total;
                                    }
                                ?>
                                </td>
                                <th>{{$list->total}}</th>
                                <th>{{isset($list->failed)?$list->failed:0}}</th>
                                <th>{{$total-($list->total+(isset($list->failed)?$list->failed:0))}}</th>
                                <td>{{ isset($list->jobs)?get_user_name($list->created_by):get_user_name($list->entry_by) }}</td>
                                <td>{{ $list->created_at }}</td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input disabled type="checkbox" data-url="{{ url('/experiment/experiment/'.___encrypt($list->id).'?status='.$list->status) }}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you Change Status ?" class="custom-control-input" id="customSwitch{{___encrypt($list->id)}}" @if($list->status==1) checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{___encrypt($list->id)}}"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                    
                                        <!-- <a class="btn btn-icon" href="{{ url('admin/admin_users/' . ___encrypt($list->id) . '/edit') }}" class="btn btn-info" data-toggle="tooltip" data-placement="bottom" title="Edit Profile">
                                            <i class="fas fa-eye text-secondary"></i>
                                        </a> -->
                                      
                                        <a class="btn btn-icon" href="javascript:void(0);" data-url="{{ url('admin/delete-jobsqueue/'.$type.'/'.___encrypt($list->id)) }}" data-method="GET" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="bottom" title="Delete jobs & queue">
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
    var cnt = '{{ $cnt }}'
    $(function() {
        if (cnt > 10) {
            $('#user_list').DataTable();
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