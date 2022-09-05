@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant')}}">Tenants</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Tenant</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('/admin/tenant/'.___encrypt($tenant->id))}}" method="POST" role="tenant">
                <input type="hidden" name="_method" value="PUT">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Edit Tenant</h4>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <div class="card shadow">
                                @if(!empty($tenant->account_details['organization_logo']))
                                <img src="{{url($tenant->account_details['organization_logo'])}}" class="img-fluid card-img-top" alt="">
                                <button type="button" data-url="{{url('/admin/tenant/'.___encrypt($tenant->id).'?remove=logo')}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0">
                                    <i class="btn-icon-prepend" data-feather="trash"></i>
                                    Delete Image
                                </button>
                                @else
                                <img src="https://via.placeholder.com/250x250" class="img-fluid card-img-top" alt="">
                                @endif
                                <div class="card-body">
                                    <h6 class="mt-2">Change Organization Logo</h6>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="organization_logo" id="customFile">
                                        <label class="custom-file-label" for="customFile">Change Organization Logo</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-9">
                            <div class="card shadow">
                                <div class="card-body">
                                    <h5 class="mb-3 mb-md-0">General Information</h5>
                                    <hr>
                                    <div class="form-row">
                                        <div class="form-group col-md-6 col-sm-6 col-lg-4">
                                            <label for="organization_name">Organization Name
                                                <span class="text-danger">*</span>
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Organization Name"></i></span>
                                            </label>
                                            <input type="text" name="organization_name" class="form-control" value="{{$tenant->name}}" placeholder="Enter Organization Name" required>
                                        </div>

                                        <div class="form-group col-md-6 col-sm-6 col-lg-4">
                                            <label for="organization_type">Select Organization Type
                                                <span class="text-danger">*</span>
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Organization Type"></i></span>
                                            </label>
                                            <select id="organization_type" name="organization_type" class="form-control" required>
                                                <option value="">Select Organization Type</option>
                                                @if(!empty($types))
                                                @foreach($types as $key => $type)
                                                @if(!empty($type))
                                                <option @if(___encrypt($tenant->type)==___encrypt($type->id)) selected @endif value="{{___encrypt($type->id)}}">{{$type->name}}</option>
                                                @else
                                                <option @if(___encrypt($tenant->type)==___encrypt($type->id)) selected @endif value="{{___encrypt($type->id)}}">{{$type->name}}</option>
                                                @endif
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-lg-4">
                                            <label for="plan_id">Select Plan
                                                <span class="text-danger">*</span>
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Plan"></i></span>
                                            </label>
                                            <select name="plan_id" id="plan_id" class="form-control" required>
                                                <option value="">Select Plan</option>
                                                @if(!empty($plans))
                                                @foreach($plans as $key => $plan)
                                                @if(!empty($plan))
                                                <option @if(___encrypt($tenant->plan_type)==___encrypt($plan->id)) selected @endif value="{{___encrypt($plan->id)}}">{{$plan['name']}}</option>
                                                @else
                                                <option @if(___encrypt($tenant->plan_type)==___encrypt($plan->id)) selected @endif value="{{___encrypt($plan->id)}}">{{$plan['name']}}</option>
                                                @endif
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>

                                    </div>
                                    <h5 class="mb-3 mb-md-0">Billing Details</h5>
                                    <hr>
                                    <div class="form-row">
                                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                                            <label for="billing_start_from"> Billing Start From
                                                <span class="text-danger">*</span>
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Billing Start From"></i></span>
                                            </label>
                                            <div class="input-group date datepicker" id="datePickerExample">
                                                <input type="text" value="{{$tenant->account_details['billing_start_from']}}" name="billing_start_from" class="form-control"><span class="input-group-addon"><i data-feather="calendar"></i></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                                            <label for="account_name"> Account Name
                                                <span class="text-danger">*</span>
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Account Name"></i></span>
                                            </label>
                                            <input type="text" value="{{$tenant->account_details['account_name']}}" name="account_name" class="form-control" placeholder="Enter Account Name" required>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                                            <label for="billing_email">Billing Email Address
                                                <span class="text-danger">*</span>
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Billing Email Address"></i></span>
                                            </label>
                                            <input type="email" oninput="this.value = this.value.toLowerCase()" disabled value="{{$tenant->account_details['billing_email']}}" name="billing_email" id="billing_email" class="form-control" placeholder="Enter Billing Email Address">
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                                            <label for="billing_phone_no">Billing Phone Number
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Billing Phone Number"></i></span>
                                            </label>
                                            <input type="text" name="billing_phone_no" id="billing_phone_no" value="{{$tenant->account_details['billing_phone_no']}}" class="form-control" data-inputmask-alias="(+99) 9999-9999" placeholder="Enter Billing Phone Number">
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                                            <label for="tax_id">Tax ID

                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Tax ID"></i></span>
                                            </label>
                                            <input type="text" name="tax_id" id="tax_id" class="form-control" value="{{$tenant->billing_information['tax_id']}}" placeholder="Enter Tax ID">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="billing_address">Billing Address

                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Billing Address"></i></span>
                                            </label>
                                            <textarea name="billing_address" id="billing_address" rows="3" class="form-control">{{$tenant->billing_information['address']}}</textarea>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                                            @include('pages.location.country')
                                            <!-- <label for="billing_country_id">Select Country

                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Country"></i></span>
                                            </label>
                                            <select name="country_id" id="billing_country_id" class="js-example-basic-single">
                                                <option value="">Select Country</option>
                                                @if(!empty($country))
                                                @foreach($country as $count)
                                                <option @if(___encrypt($tenant->billing_information['country_id'])==___encrypt($count->id)) selected @endif value="{{___encrypt($count->id)}}">{{$count->name}}</option>
                                                @endforeach
                                                @endif
                                            </select> -->
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                                            <label for="billing_state_id">Enter State Name

                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter State Name"></i></span>
                                            </label>
                                            <input type="text" name="state" placeholder="Enter State Name" value="{{$tenant->billing_information['state']}}" class="form-control">
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                                            <label for="billing_city_id">Enter District / City

                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter District / City"></i></span>
                                            </label>
                                            <input type="text" placeholder="Enter District / City" name="city" value="{{$tenant->billing_information['city']}}" class="form-control">
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                                            <label for="pincode">Pincode / Zip Code
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Pincode / Zip Code"></i></span>
                                            </label>
                                            <input type="text" pattern="^[0-9]*$" min="0.0000000001" data-request="isnumeric" value="{{$tenant->billing_information['pincode']}}" name="pincode" id="pincode" class="form-control" placeholder="Enter Pincode / Zip Code" onkeypress="return isNumber(event)">
                                        </div>
                                    </div>
                                    <!-- <h5 class="mb-3 mb-md-0">Number of Users per Tenant</h5> -->
                                    <hr>
                                    <div class="form-row">
                                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                                            <label for="no_users">
                                                Number of Users
                                                <span class="text-danger">*</span>
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Number of Users"></i></span>
                                            </label>
                                            <input type="number" min="0.0000000001" data-request="isnumeric" value="{{$tenant->tenant_config->number_of_users}}" name="no_users" id="no_users" min="1" max="100" class="form-control">
                                            <input type="hidden" value="{{___encrypt($tenant->tenant_config->id)}}" name="tenant_variation_id">
                                        </div>
                                        <!-- <div class="form-group col-md-6 col-sm-6 col-lg-6">
                                            <label for="calc_url">
                                                Enter calc Server Url
                                                <span class="text-danger">*</span>
                                                <span><i clEdit Tenantass="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Calc Server URL"></i></span>
                                            </label>
                                            <input type="text" name="calc_url" value="{{!empty($tenant->account_details['calc_url'])?$tenant->account_details['calc_url']:''}}" id="calc_url" class="form-control">
                                        </div> -->
                                    </div>

                                    <h5 class="mb-3 mb-md-0">Tenant Description</h5>
                                    <hr>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="description">Tenant Description
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Tenant Description"></i></span>
                                            </label>
                                            <textarea name="description" id="description" rows="5" class="form-control">{{$tenant->description}}</textarea>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="note">Note
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Note"></i></span>
                                            </label>
                                            <textarea name="note" id="note" rows="5" class="form-control">{{$tenant->note}}</textarea>
                                        </div>
                                    </div>
                                    <div class="card-footer text-right">
                                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="tenant"]' class="btn btn-sm btn-secondary submit">Submit</button>
                                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            {{Config::get('constants.message.loader_button_msg')}}
                                        </button>
                                        <a href="{{url('/admin/tenant')}}" class="btn btn-sm btn-danger">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
@endpush

@push('custom-scripts')

<script>
    $(function() {
        $(function() {
            'use strict';

            if ($('#datePickerExample').length) {
                var date = new Date();
                var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
                $('#datePickerExample').datepicker({
                    format: "dd/mm/yyyy",
                    todayHighlight: true,
                    autoclose: true
                });
                //$('#datePickerExample').datepicker('setDate', today);
            }
        });
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }

        $(":input").inputmask();

        $("#select-all").click(function() {
            $('.checkSingle').not(this).prop('checked', this.checked);
        });

        $('.checkSingle').click(function() {
            if ($('.checkSingle:checked').length == $('.checkSingle').length) {
                $('#select-all').prop('checked', true);
            } else {
                $('#select-all').prop('checked', false);
            }
        });
        $('input[type=checkbox]').click(function() {
            $(this).parent().find('li input[type=checkbox]').prop('checked', $(this).is(':checked'));
            var sibs = false;
            $(this).closest('ul').children('li').each(function() {
                if ($('input[type=checkbox]', this).is(':checked')) sibs = true;
            })
            $(this).parents('ul').prev().prop('checked', sibs);
        });
    });
</script>
@endpush
