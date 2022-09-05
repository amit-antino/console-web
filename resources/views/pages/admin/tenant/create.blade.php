@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/admin/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="/admin/tenant">Tenants</a></li>
        <li class="breadcrumb-item active" aria-current="page">Create Tenant</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('/admin/tenant/')}}" method="POST" role="tenant">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Add Tenant</h4>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <div class="card shadow">
                                <img src="https://via.placeholder.com/250x250" class="img-fluid card-img-top" alt="">
                                <div class="card-body">
                                    <h6 class="mt-2">Upload Organization Logo</h6>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="organization_logo" id="customFile">
                                        <label class="custom-file-label" for="customFile">Upload Organization Logo</label>
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
                                            <input type="text" name="organization_name" class="form-control" placeholder="Enter Organization Name" required>
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
                                                <option value="{{$type['id']}}">{{$type['name']}}</option>
                                                @else
                                                <option value="{{$type['id']}}">{{$type['name']}}</option>
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
                                                <option value="{{$plan['id']}}">{{$plan['name']}}</option>
                                                @else
                                                <option value="{{$plan['id']}}">{{$plan['name']}}</option>
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
                                                <input type="text" name="billing_start_from" class="form-control"><span class="input-group-addon"><i data-feather="calendar"></i></span>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                                            <label for="account_name"> Account Name
                                                <span class="text-danger">*</span>
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Account Name"></i></span>
                                            </label>
                                            <input type="text" name="account_name" class="form-control" placeholder="Enter Account Name" required>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                                            <label for="billing_email">Billing Email Address
                                                <span class="text-danger">*</span>
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Billing Email Address"></i></span>
                                            </label>
                                            <input type="email" oninput="this.value = this.value.toLowerCase()" name="billing_email" id="billing_email" class="form-control" placeholder="Enter Billing Email Address">
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                                            <label for="billing_phone_no">Billing Phone Number
                                                <!-- <span class="text-danger">*</span> -->
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Billing Phone Number"></i></span>
                                            </label>
                                            <input type="text" name="billing_phone_no" id="billing_phone_no" class="form-control" data-inputmask-alias="(+99) 9999-9999-99" placeholder="Enter Billing Phone Number">
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                                            <label for="tax_id">Tax ID
                                                <!-- <span class="text-danger">*</span> -->
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Tax ID"></i></span>
                                            </label>
                                            <input type="text" name="tax_id" id="tax_id" class="form-control" placeholder="Enter Tax ID">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="billing_address">Billing Address
                                                <!-- <span class="text-danger">*</span> -->
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Billing Address"></i></span>
                                            </label>
                                            <textarea name="billing_address" id="billing_address" rows="5" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                                            @include('pages.location.country')
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                                            @include('pages.location.state')
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                                            @include('pages.location.city')
                                        </div>
                                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                                            <label for="pincode">Pincode / Zip Code
                                                <!-- <span class="text-danger">*</span> -->
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Pincode / Zip Code"></i></span>
                                            </label>
                                            <input type="text" min="0.0000000001" name="pincode" id="pincode" class="form-control" placeholder="Enter Pincode / Zip Code" onkeypress="return isNumber(event)">
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
                                            <input type="number" value="30" data-request="isnumeric" name="no_users" id="no_users" min="1" max="100" class="form-control">
                                        </div>
                                   
                                        <!-- <div class="form-group col-md-6 col-sm-6 col-lg-6">
                                            <label for="no_users">
                                               Enter calc Server Url
                                                <span class="text-danger">*</span>
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Calc Server URL"></i></span>
                                            </label>
                                            <input type="text" name="calc_url" id="calc_url" class="form-control">
                                        </div> -->
                                    </div>
                                    <!-- <h5 class="text-center mb-3 mb-md-0">Database Configuration</h5>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                            <label for="host_name">
                                Host Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Host Name"></i></span>
                            </label>
                            <input type="text" name="host_name" id="host_name"  class="form-control">
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                            <label for="website_url">
                                Website URL
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Website URL"></i></span>
                            </label>
                            <input type="text" name="website_url" id="website_url"  class="form-control">
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                            <label for="database_name">
                                Database Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Database Name"></i></span>
                            </label>
                            <input type="text" name="database_name" id="database_name"  class="form-control">
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                            <label for="database_user_name">
                                Database User Name
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Database User Name"></i></span>
                            </label>
                            <input type="text" name="database_user_name" id="database_user_name"  class="form-control">
                        </div>
                        <div class="form-group col-md-6 col-sm-6 col-lg-3">
                            <label for="database_password">
                                Database Password
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Database Password"></i></span>
                            </label>
                            <input type="text" name="database_password" id="database_password"  class="form-control">
                        </div>

                    </div> -->
                                    <!-- <h5 class="text-center mb-3 mb-md-0">Select Modules for the Tenant</h5>
                    <hr>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" id="select-all" class="form-check-input">
                                    Select All
                                </label>
                            </div>
                        </div>
                    </div>
                    @include('pages.admin.tenant.module') -->

                                    <h5 class="mb-3 mb-md-0">Tenant Description</h5>
                                    <hr>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="description">Tenant Description
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Tenant Description"></i></span>
                                            </label>
                                            <textarea name="description" id="description" rows="5" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="note">Note
                                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Enter Note"></i></span>
                                            </label>
                                            <textarea name="note" id="note" rows="5" class="form-control"></textarea>
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
<script src="{{ asset('assets/js/datepicker.js') }}"></script>
<script>
   
    $(function() {
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