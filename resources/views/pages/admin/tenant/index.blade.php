@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tenants</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Tenants</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <a href="{{ url('/admin/tenant/create') }}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block">
            <i class="btn-icon-prepend" data-feather="plus"></i>
            Add Tenant
        </a>
        <button type="button" data-url="{{url('/admin/tenant/bulk-delete')}}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="deletebulk btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
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
                    <table id="tenant_list" class="table table-hover mb-0">
                        <thead>
                            <th><input type="checkbox" id="example-select-all"></th>
                            <th>Organization Name</th>
                            <th>Organization Type</th>
                            <th>Location</th>
                            <th>Plan</th>
                            <th>Plan Expiry</th>
                            <th class="text-center">LDAP</th>
                            <th class="text-center">2FA</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </thead>
                        <tbody>
                            @php
                            $cnt = count($tenants)
                            @endphp
                            @if(!empty($tenants))
                            @foreach($tenants as $tenent)
                            <tr>
                                <td><input type="checkbox" value="{{___encrypt($tenent->id)}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{$tenent->name}}</td>
                                <td>{{!empty($tenent->organization_type_details->name)?$tenent->organization_type_details->name:''}}</td>
                                <td>{{!empty($tenent->location->name)?$tenent->location->name:''}}</td>
                                <td>{{!empty($tenent->plan_details->name)?$tenent->plan_details->name:''}}</td>
                                <td>{{$tenent->organization_plan_expiry}}</td>
                                <td class="text-center">
                                    <form action="/admin/tenant/status" method="post">
                                        <input type="hidden" name="tenant_id" value="">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" data-ask="Are You Sure? You Want enable LDAP Auth." data-url="{{url('/admin/tenant/'.___encrypt($tenent->id).'?ldap_auth='.$tenent->ldap_auth)}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" id="customSwitchLDap{{___encrypt($tenent->id)}}" @if($tenent->ldap_auth=='on') checked @endif>
                                            <label class="custom-control-label" for="customSwitchLDap{{___encrypt($tenent->id)}}"></label>
                                        </div>
                                    </form>
                                </td>
                                <td class="text-center">
                                    @if(!empty($tenent->tenant_config['id']))
                                    <form action="/admin/tenant/status" method="post">
                                        <input type="hidden" name="tenant_id" value="">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" data-ask="Are You Sure? You Want Change Two Factor Auth Status." data-url="{{url('/admin/tenant/'.___encrypt($tenent->tenant_config['id']).'?two_factor='.$tenent->tenant_config['two_factor_auth'])}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" id="customSwitchTwo{{___encrypt($tenent->id)}}" @if($tenent->tenant_config['two_factor_auth']=='true') checked @endif>
                                            <label class="custom-control-label" for="customSwitchTwo{{___encrypt($tenent->id)}}"></label>
                                        </div>
                                    </form>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <form action="/admin/tenant/status" method="post">
                                        <input type="hidden" name="tenant_id" value="">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input" data-url="{{url('/admin/tenant/'.___encrypt($tenent->id).'?status='.$tenent->status)}}" data-method="DELETE" data-request="ajax-confirm" data-ask="Are you sure you want to change Status?" data-ask_image="warning" id="customSwitch{{___encrypt($tenent->id)}}" @if($tenent->status=='pending') disabled @endif
                                            @if($tenent->status=='active') checked @endif>
                                            <label class="custom-control-label" for="customSwitch{{___encrypt($tenent->id)}}"></label>
                                        </div>
                                    </form>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a class="btn btn-icon" href="{{ url('/dashboard?tenant_id='.___encrypt($tenent->id))}}" data-toggle="tooltip" target="_blank" data-placement="bottom" title="Login Tenant">
                                            <i class="fas fa-user text-secondary"></i>
                                        </a>
                                        <a class="btn btn-icon" href="{{ url('/admin/tenant/manage/'.___encrypt($tenent->id))}}" data-toggle="tooltip" data-placement="bottom" title="Manage Tenant">
                                            <i class="fas fa-cog text-secondary"></i>
                                        </a>
                                        <a class="btn btn-icon" href="{{url('/admin/tenant/'.___encrypt($tenent->id))}}" data-toggle="tooltip" data-placement="bottom" title="View Tenant">
                                            <i class="fas fa-eye text-secondary"></i>
                                        </a>
                                        <a class="btn btn-icon" href="{{url('admin/tenant/'.___encrypt($tenent->id).'/edit')}}" data-toggle="tooltip" data-placement="bottom" title="Edit Tenant">
                                            <i class="fas fa-edit text-secondary"></i>
                                        </a>
                                        <a class="btn btn-icon" href="javascript:void(0);" data-url="{{url('admin/tenant/'.___encrypt($tenent->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger text-white btn-icon-text" data-toggle="tooltip" data-placement="bottom" title="Delete Tenant">
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
      $(".deletebulk").hide();
    var cnt = '{{$cnt}}'
    $(function() {
        if (cnt > 10) {
            $('#tenant_list').DataTable();
        }
    });
    $("#example-select-all").click(function() {
        $('.checkSingle').not(this).prop('checked', this.checked);
        var len = $("[name='select_all[]']:checked").length;
        if (len > 1) {
            $(".deletebulk").show();
        } else {
            $(".deletebulk").hide();
        }
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