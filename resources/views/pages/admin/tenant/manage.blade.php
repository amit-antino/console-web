@extends('layout.admin.master')

@push('plugin-styles')
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/tenant') }}">Tenants</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{get_tenant_name(___encrypt($data['tenant']['id']))}} Manage</li>
    </ol>
</nav>
<div class="row">
    <div class="col-12 col-xl-12 stretch-card">
        <div class="card-columns">
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Locations - {{ $data['locations_count'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-map-marked fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a type="button" href="{{ url('/admin/tenant/'.___encrypt($data['tenant']['id']).'/locations') }}" data-toggle="tooltip" data-placement="bottom" title="Manage Location" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                User Management - {{ $data['users_count'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users-cog fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a type="button" class="btn btn-icon" href="{{ url('/admin/tenant/'.___encrypt($data['tenant']['id']).'/user') }}" data-toggle="tooltip" data-placement="bottom" title="Create User">
                        <i class="fas fa-list-ul text-secondary"></i>
                    </a>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                User Group - {{ $data['user_group_count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-cog fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <!-- <a type="button" href="{{ url('/admin/tenant/'.___encrypt($data['tenant']['id']).'/user_group/create') }}" data-toggle="tooltip" data-placement="bottom" title="Create User Group" class="btn btn-icon"><i class="fas fa-user-circle text-secondary"></i></a> -->
                    <a type="button" href="{{ url('/admin/tenant/'.___encrypt($data['tenant']['id']).'/user_group') }}" data-toggle="tooltip" data-placement="bottom" title="Manage User Group" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Designation - {{ $data['designation_count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a type="button" href="{{ url('/admin/tenant/'.___encrypt($data['tenant']['id']).'/designation') }}" data-toggle="tooltip" data-placement="bottom" title="Manage" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Calculations Services - {{ $data['designation_count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a type="button" href="{{ url('/admin/tenant/'.___encrypt($data['tenant']['id']).'/calc_url') }}" data-toggle="tooltip" data-placement="bottom" title="Manage" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Data Request</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a type="button" href="{{ url('/admin/tenant/'.___encrypt($data['tenant']['id']).'/data_request') }}" data-toggle="tooltip" data-placement="bottom" title="Manage" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Menu Group Management - {{ $data['menu_count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-bars fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a type="button" href="{{ url('/admin/tenant/'.___encrypt($data['tenant']['id']).'/role') }}" data-toggle="tooltip" data-placement="bottom" title="Manage" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>

            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                User Permission - {{ $data['user_permission_count'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a type="button" href="{{ url('/admin/tenant/'.___encrypt($data['tenant']['id']).'/user_permission') }}" data-toggle="tooltip" data-placement="bottom" title="Manage" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
            {{-- Variation modules --}}

            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Project - {{ $data['project_cnt'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a type="button" href="{{ url('/admin/tenant/'.___encrypt($data['tenant']['id']).'/project') }}" data-toggle="tooltip" data-placement="bottom" title="Manage" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Experiments - 0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a type="button" href="{{ url('/admin/tenant/'.___encrypt($data['tenant']['id']).'/experiment') }}" data-toggle="tooltip" data-placement="bottom" title="Manage" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Reaction - 2</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a type="button" href="{{ url('/admin/tenant/'.___encrypt($data['tenant']['id']).'/reaction') }}" data-toggle="tooltip" data-placement="bottom" title="Manage" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Regulatory Lists - 2</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a type="button" href="{{ url('/admin/tenant/'.___encrypt($data['tenant']['id']).'/list') }}" data-toggle="tooltip" data-placement="bottom" title="Manage" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Banner and Logo Image</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a type="button" href="{{ url('/admin/tenant/'.___encrypt($data['tenant']['id']).'/logo_image/edit') }}" data-toggle="tooltip" data-placement="bottom" title="Manage" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
            <div class="card border-left-secondary shadow">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                Documentations </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-lg text-secondary text-gray-300"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a type="button" href="{{ url('/admin/tenant/'.___encrypt($data['tenant']['id']).'/document_update/edit') }}" data-toggle="tooltip" data-placement="bottom" title="Manage" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('plugin-scripts')
@endpush

@push('custom-scripts')
<script>

</script>
@endpush