@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('organization/settings')}}">Organization</a></li>
        <li class="breadcrumb-item active">Designation</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Designation</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a href="{{ url('organization/'.$tenant_id.'/designation/create') }}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
            <i class="btn-icon-prepend" data-feather="user-plus"></i>
            Add Designation
        </a>
        <div class="deletebulk">
            <button type="button" data-url="{{url('organization/'.$tenant_id.'/designation/bulk-delete')}}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="trash"></i>
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
                    <table id="designation_list" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="example-select-all"></th>
                                <th>Department Name</th>
                                <th>Description</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                                $cnt = count($data->designation)
                            @endphp
                            @if(!empty($data->designation))
                            @foreach($data->designation as $key =>$val)
                            <tr>
                                <td><input type="checkbox" value="{{___encrypt($val['id'])}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{ $val['name']}} </td>
                                <td>{{ $val['description']}} </td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" data-url="{{url('organization/'.$tenant_id.'/designation/'.___encrypt($val['id']).'?status='.$val['status'])}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" class="custom-control-input" id="customSwitch{{___encrypt($val['id'])}}" @if($val['status']=='active') checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{___encrypt($val['id'])}}"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">

                                        <a href="{{ url('organization/'.$tenant_id.'/designation/'.___encrypt($val['id']).'/edit') }}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Designation">
                                            <i class="fa fa-edit text-secondary"></i> 
                                        </a>
                                        <a href="javascript:void(0);" data-url="{{ url('organization/'.$tenant_id.'/designation/'.___encrypt($val['id'])) }}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete Designation">
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
<script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/promise-polyfill/polyfill.min.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
<script src="{{ asset('assets/js/sweet-alert.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    var cnt = '{{$cnt}}'
    if(cnt>10){
        $('#department_list').DataTable();
    }
    $(".deletebulk").hide();
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
</script>
@endpush