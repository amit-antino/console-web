@extends('layout.admin.master')

@push('plugin-styles')
    <link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <nav class="page-breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/admin/tenant') }}">Tenants</a></li>
            <li class="breadcrumb-item"><a
                    href="{{ url('/admin/tenant/manage/' . ___encrypt($tenant->id)) }}">{{ $tenant->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Management</li>
        </ol>
    </nav>
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">{{ $tenant->name }} - User Management</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-sm btn-outline-info btn-icon-text mr-2 d-none d-md-block">
                <i class="btn-icon-prepend" data-feather="download"></i>
                Import
            </button>
            <a href="{{ url('/admin/tenant/' . ___encrypt($tenant->id) . '/user/create') }}"
                class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
                <i class="btn-icon-prepend" data-feather="plus"></i>
                Add User
            </a>
            <button type="button" data-url="{{ url('/admin/tenant/' . ___encrypt($tenant->id) . '/user/bulk-delete') }}"
                data-method="POST" data-request="ajax-confirm" data-ask_image="warning"
                data-ask="Are you sure you want to delete?" data-id="bulk-delete"
                class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0 deletebulk">
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
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Email Verified</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </thead>
                            <tbody>
                                @php
                                    $cnt = count($users);
                                @endphp
                                @if (!empty($users))
                                    @foreach ($users as $user)
                                        <tr>
                                            <td><input type="checkbox" value="{{ ___encrypt($user->id) }}"
                                                    class="checkSingle" name="select_all[]"></td>
                                            <td>{{ $user->first_name }} {{ $user->last_name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>@if (!empty($user->email_verified)) <i class="fa fa-check-circle fa-2x text-success"></i> @else <i class="fas fa-sync-alt fa-2x text-danger"></i> @endif</td>
                                            <td class="text-center">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input"
                                                     @if($user->status=='active' ) checked @endif
                                                        data-url="{{ url('admin/admin_users/' . ___encrypt($user->id) . '?status=' . $user->status) }}"
                                                        data-method="DELETE" data-request="ajax-confirm"
                                                        data-ask_image="warning"
                                                        data-ask="Are you sure you want change Status?"
                                                        id="customSwitch{{ ___encrypt($user->id) }}"
                                                        >
                                                    <label class="custom-control-label"
                                                        for="customSwitch{{ ___encrypt($user->id) }}"></label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm" role="group">

                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        data-url="{{ url('/admin/tenant/' . ___encrypt($tenant->id) . '/user/' . ___encrypt($user->id)) }}"
                                                        data-method="GET" data-request="ajax-confirm"
                                                        data-ask_image="warning"
                                                        data-ask="Are you sure you want to Send Mail?"
                                                        class="btn btn-icon" data-toggle="tooltip" data-placement="bottom"
                                                        title="Send EMail Verification Link">
                                                        <i class="fas fa-redo text-secondary"></i>
                                                    </a>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        data-url="{{ url('/admin/tenant/' . ___encrypt($tenant->id) . '/user/' . ___encrypt($user->id) . '?reset_password=yes') }}"
                                                        data-method="GET" data-request="ajax-confirm"
                                                        data-ask_image="warning"
                                                        data-ask="Are you sure you want to Send Mail?"
                                                        class="btn btn-icon" data-toggle="tooltip" data-placement="bottom"
                                                        title="Send Reset Password Link">
                                                        <i class="fas fa-user-lock text-secondary"></i>
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ url('/admin/tenant/' . ___encrypt($tenant->id) . '/user/' . ___encrypt($user->id) . '/edit') }}"
                                                        class="btn btn-icon" data-toggle="tooltip" data-placement="bottom"
                                                        title="Edit Profile">
                                                        <i class="fas fa-edit text-secondary"></i>
                                                    </a>
                                                    <a class="dropdown-item"
                                                        href="{{ url('/admin/tenant/' . ___encrypt($tenant->id) . '/user/' . ___encrypt($user->id) . '/set-password') }}"
                                                        class="btn btn-icon" data-toggle="tooltip" data-placement="bottom"
                                                        title="Set New Password">
                                                        <i class="fas fa-unlock text-secondary"></i>
                                                    </a>
                                                    <a class="dropdown-item" href="javascript:void(0);"
                                                        data-url="{{ url('/admin/tenant/' . ___encrypt($tenant->id) . '/user/' . ___encrypt($user->id)) }}"
                                                        data-method="DELETE" data-request="ajax-confirm"
                                                        data-ask_image="warning" data-ask="Are you sure you want to delete?"
                                                        class="btn btn-icon" data-toggle="tooltip" data-placement="bottom"
                                                        title="Delete User">
                                                        <i class="fas fa-trash text-secondary"></i>
                                                    </a>

                                                </div>
                                            </td>
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
    <!--comment test-->
@endpush
