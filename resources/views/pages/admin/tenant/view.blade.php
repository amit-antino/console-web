@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/admin/tenant') }}">Tenants</a></li>
        <li class="breadcrumb-item active" aria-current="page"> Tenant</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form>
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Tenant</h4>
                </div>
                <div class="card-body">
                    <h5 class="text-center mb-3 mb-md-0">General Information</h5>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                            <strong>Organization Name :</strong>
                            <p>{{$tenant->name}}</p>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                            <strong>Select Organization Type : </strong>
                            <p>{{$tenant->organization_type_details->name}}</p>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                            <strong>Select Plan : </strong>
                            <p>{{$tenant->plan_details->name}}</p>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                            <strong>Upload Organization Logo : </strong>
                            <img src="{{url($tenant->account_details['organization_logo'])}}" height="100" width="100">
                        </div>
                    </div>
                    <h5 class="text-center mb-3 mb-md-0">Billing Details</h5>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                            <strong> Account Name : </strong>
                            <p>{{$tenant->account_details['account_name']}}</p>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                            <strong>Billing Email Address : </strong>
                            <p>{{$tenant->account_details['billing_email']}}</p>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                            <strong>Billing Phone Number : </strong>
                            <p>{{$tenant->account_details['billing_phone_no']}}</p>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                            <strong>Tax ID: </strong>
                            <p>{{$tenant->billing_information['tax_id']}}</p>
                        </div>
                        <div class="form-group col-md-12">
                            <strong>Billing Address : </strong>
                            <p>{{$tenant->billing_information['address']}}</p>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                            <strong>Country : </strong>
                          
                            <p>{{$tenant->billing_information['country_id']}}</p>
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                            <strong>State : </strong>
                            @if(!empty($tenant->billing_information['state']))
                            <p>{{$tenant->billing_information['state']}}</p>
                            @endif
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                            <strong>City : </strong>
                            @if(!empty($tenant->billing_information['city']))
                           <p>{{$tenant->billing_information['city']}}</p>
                           @endif
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                            <strong>Pincode / Zip Code : </strong>
                            <p>{{$tenant->billing_information['pincode']}}</p>
                        </div>
                    </div>
                    <h5 class="text-center mb-3 mb-md-0">Number of Users per Tenant</h5>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                            <strong>Number of Users :</strong>
                            <p>{{!empty($tenant->tenant_config->number_of_users)?$tenant->tenant_config->number_of_users:0}}</p>
                        </div>
                    </div>
                    <h5 class="text-center mb-3 mb-md-0">Database Configuration</h5>
                    <hr>
                   
                    <h5 class="text-center mb-3 mb-md-0">Tenant Description</h5>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <strong>Tenant Description : </strong>
                            <p>{{$tenant->description}}</p>
                        </div>
                        <div class="form-group col-md-6">
                            <strong>Note : </strong>
                            <p>{{$tenant->note}}</p>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{url('/admin/tenant')}}" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection