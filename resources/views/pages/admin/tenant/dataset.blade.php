@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/tenant') }}">Tenants</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/tenant/manage/'.___encrypt($tenant_id)) }}">{{get_tenant_name(___encrypt($tenant_id))}} Manage</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/tenant/'.___encrypt($tenant_id).'/experiment') }}">Experiment Manage</a></li>
        <li class="breadcrumb-item active" aria-current="page">Dataset</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Dataset</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        
        <!-- <button type="button" style="display:none" data-url="{{ url('/admin/tenant/bulk-delete') }}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
            <i class="btn-icon-prepend" data-feather="trash"></i>
            Delete
        </button> -->
    </div>
</div>
<div class="row">
    <div class="col-lg-12 col-xl-12 stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tenant_list" class="table table-hover mb-0">
                        <thead>
                            <th><input type="checkbox" id="example-select-all"></th>
                            <th>Dataset name</th>
                            <th>Upload Date</th>
                            <th>Request Date</th>
                            <th>Description</th>
                            <th>Tags</th>
                            <th>File</th>
                            <th class="text-center">Dataset status</th>
                            <th class="text-center">Operation status</th>
                            <th class="text-center">Actions</th>
                        </thead>
                        <tbody>
                            @php
                            $cnt = count($datsets);
                            @endphp
                            @if (!empty($datsets))
                            @foreach ($datsets as $val)
                            <tr>
                                <td><input type="checkbox" value="{{ ___encrypt($val['id']) }}" class="checkSingle_model" name="select_all_model[]"></td>
                                <td>{{ $val['name'] }}</td>
                                <td>{{ dateTimeFormate($val['updated_at']) }}</td>
                                <td>{{ dateTimeFormate($val['created_at']) }}</td>
                                <td>{{ $val['description'] }}</td>
                                <td>
                                    @if (!empty($val['tags']))
                                    @foreach ($val['tags'] as $tag)

                                    <span class="badge badge-info font-weight-normal">
                                        {{ $tag }}
                                    </span>
                                    @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if (!empty($val['filename']))
                                    <a href="{{ url($val['filename']) }}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Click here for file download" download=""><i class="fas fa-download text-secondary"></i></a>
                                    @endif

                                </td>
                                <td>
                                    <select data-request="ajax-confirm-onchange" data-ask_image="warning" data-ask="Are you sure? You want to change status." data-method="DELETE" data-url="{{ url('admin/tenant/' . ___encrypt($tenant_id) . '/experiment/dataset/' . ___encrypt($val['id'])) }}" class="form-control" id="status" name="status">
                                        <option @if ($val['status']=='requested' ) selected @endif value="requested">Requested
                                        </option>
                                        <option @if ($val['status']=='under_process' ) selected @endif value="under_process">Under Process
                                        </option>
                                        <option @if ($val['status']=='processed' ) selected @endif value="processed">Processed
                                        </option>
                                    </select>
                                </td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" data-url="{{ url('/admin/tenant/' . ___encrypt($tenant_id) . '/experiment/dataset/' . ___encrypt($val['id']) . '?operation_status=' . $val['operation_status']) }}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure? You want to change status." id="customSwitch{{ ___encrypt($val['id']) }}" @if ($val['operation_status']=='active' ) checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{ ___encrypt($val['id']) }}"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    @php
                                    $mid = ___encrypt($val['id']);
                                    @endphp
                                    {{-- <a href="javascript:void(0);" class="btn btn-icon" data-toggle="tooltip"
                                                    data-placement="bottom" title="Edit Model"
                                                    onclick="editModel('{{ $mid }}')">
                                    <i class="fas fa-edit text-secondary"></i>
                                    </a> --}}
                                    <a href="javascript:void(0);" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete Dataset" data-url="{{ url('/admin/tenant/' . ___encrypt($tenant_id) . '/experiment/dataset/' . ___encrypt($val['id'])) }}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure? You want to change Delete.">
                                        <i class="fas fa-trash text-secondary"></i>
                                    </a>
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
            $('#tenant_list').DataTable();
        }
    });
    $("#example-select-all").click(function() {
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