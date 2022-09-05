@extends('layout.console.master')

@push('plugin-styles')

@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">Organization</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Manage Tenant - @if(!empty($organization['name'])){{$organization['name']}}@endif</h4>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="card shadow">
            <img src="{{ asset($organization['organization_logo'])}}" height="" class="img-fluid card-img-top" alt="">
            @if(Auth::user()->role != 'console')
            <div class="card-body">
                <h6 class="mt-2">Upload a different photo</h6>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFile">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="col-md-9 stretch-card">
        <div class="card shadow">
            <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-line" id="lineTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="general-line-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">General</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " id="management-line-tab" data-toggle="tab" href="#management" role="tab" aria-controls="management" aria-selected="true">Organization</a>
                    </li>
                </ul>
                <div class="tab-content mt-3" id="lineTabContent">
                    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-line-tab">
                        <div class="row">
                            <div class="col-md-12 grid-margin stretch-card">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <p>Organization Name - <b>{{$organization['name']}}</b></p>
                                        <p>Account Name - <b>{{$organization['account_name']}}</b></p>
                                        <p>Billing Email - <b>{{$organization['billing_email']}}</b></p>
                                        <p>Billing Phone No - <b>{{$organization['billing_phone_no']}}</b></p>
                                        <p>Total No of User Assign - <b>{{$organization['no_users']}}</b></p>
                                        <p>Description - <b>{{$organization['description']}}</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show " id="management" role="tabpanel" aria-labelledby="management-line-tab">
                        <div class="row">
                            <div class="col-12 col-xl-12 stretch-card">
                                <div class="card-columns">
                                    <div class="card border-left-secondary shadow">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h5 font-weight-bold text-secondary text-uppercase">
                                                        Users - {{$users_count}}
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-map-marked fa-lg text-secondary text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <a type="button" href="{{ url('organization/'.$tenant_id.'/user_management') }}" data-toggle="tooltip" data-placement="bottom" title="User Management" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                                        </div>
                                    </div>
                                    <div class="card border-left-secondary shadow">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h5 font-weight-bold text-secondary text-uppercase">
                                                        User Group - {{$user_group_count}}
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-map-marked fa-lg text-secondary text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <a type="button" href="{{ url('organization/'.$tenant_id.'/user_group') }}" data-toggle="tooltip" data-placement="bottom" title="User Group" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                                        </div>
                                    </div>
                                    <div class="card border-left-secondary shadow">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h5 font-weight-bold text-secondary text-uppercase">
                                                        Designation - {{$designation_count}}
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-map-marked fa-lg text-secondary text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <a type="button" href="{{ url('organization/'.$tenant_id.'/designation') }}" data-toggle="tooltip" data-placement="bottom" title="Manage Designation" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-xl-12 stretch-card">
                                <div class="card-columns">
                                    <div class="card border-left-secondary shadow">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h5 font-weight-bold text-secondary text-uppercase">
                                                        Users Permission - {{$user_permission_count}}
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-map-marked fa-lg text-secondary text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <a type="button" href="{{ url('organization/'.$tenant_id.'/user_permission') }}" data-toggle="tooltip" data-placement="bottom" title="User Permission" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                                        </div>
                                    </div>
                                    <!-- <div class="card border-left-secondary shadow">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h5 font-weight-bold text-secondary text-uppercase">
                                                        User Group - 0
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-map-marked fa-lg text-secondary text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <a type="button" href="{{ url('organization/'.$tenant_id.'/user_group') }}" data-toggle="tooltip" data-placement="bottom" title="User Group" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                                        </div>
                                    </div>
                                    <div class="card border-left-secondary shadow">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2">
                                                    <div class="h5 font-weight-bold text-secondary text-uppercase">
                                                        Designation - 0
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <i class="fas fa-map-marked fa-lg text-secondary text-gray-300"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <a type="button" href="{{ url('organization/'.$tenant_id.'/designation') }}" data-toggle="tooltip" data-placement="bottom" title="Manage Location" class="btn btn-icon"><i class="fas fa-list-ul text-secondary"></i></a>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')

@endpush

@push('custom-scripts')

@endpush