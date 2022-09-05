@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ url('/organization/vendor') }}">Vendors</a></li>
        <li class="breadcrumb-item active" aria-current="page">Manage Vendor</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Manage Vendor - {{$vendor->name}}</h4>
    </div>
</div>
<div class="row">
    <div class="col-md-12 mb-3 stretch-card">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                    <h6 class="card-title mb-0">Vendor Location Details</h6>
                    <a href="javascript:void(0);" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" data-toggle="modal" data-target="#vendor_location_detail">
                        <i class="btn-icon-prepend" data-feather="map-pin"></i>
                        Add Location Details
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="vendor_location_details" class="table table-hover mb-0">
                        <thead>
                            <th><input type="checkbox" id="example-select-all"></th>
                            <th>Location Name</th>
                            <th>Address</th>
                            <th>Location Details</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </thead>
                        <tbody>
                            @if(!empty($vendor_locations))
                            @foreach($vendor_locations as $key => $vendor_location)
                            <tr>
                                <td><input type="checkbox" value="{{___encrypt($vendor_location->id)}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{ $vendor_location->location_name }}</td>
                                <td>{{ $vendor_location->address}}</td>
                                <td>
                                {{!empty($vendor_location->city->name)?$vendor_location->city->name:''}},
                                {{!empty($vendor_location->state->name)?$vendor_location->state->name:''}},
                                {{!empty($vendor_location->country->name)?$vendor_location->country->name:''}}
                                </td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" data-url="{{url('/organization/vendor/location/'.___encrypt($vendor_location->id).'?status='.$vendor_location->status)}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" id="customSwitch-loc{{___encrypt($vendor_location->id)}}" @if($vendor_location->status=='pending') disabled @endif
                                        @if($vendor_location->status=='active') checked @endif>
                                        <label class="custom-control-label" for="customSwitch-loc{{___encrypt($vendor_location->id)}}"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a href="javascript:void(0);" data-url="{{url('organization/vendor/location/'.___encrypt($vendor_location->id).'/edit?type=contact')}}" data-request="ajax-popup"  data-target="#edit-div" data-tab="#vendor_contact_detail{{___encrypt($vendor_location->id)}}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Add Contact">
                                    <i class="fas fa-address-book text-secondary"></i>
                                    </a>
                                    <a href="javascript:void(0);" data-url="{{url('organization/vendor/location/'.___encrypt($vendor_location->id).'/edit')}}" data-request="ajax-popup" data-target="#edit-div" data-tab="#editLocationModal{{___encrypt($vendor_location->id)}}" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Edit Location">
                                        <i class="fas fa-edit text-secondary"></i>
                                    </a>
                                    <a href="javascript:void(0);" data-url="{{url('organization/vendor/location/'.___encrypt($vendor_location->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="bottom" title="Delete Tenant">
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
    <div class="col-md-12 mb-3 stretch-card">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                    <h6 class="card-title mb-0">Vendor Contact Details</h6>
                    <a href="javascript:void(0);" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" data-toggle="modal" data-target="#vendor_contact_detail">
                        <i class="btn-icon-prepend" data-feather="user-plus"></i>
                        Add Contact Details
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="vendor_contact_details" class="table table-hover mb-0">
                        <thead>
                            <th><input type="checkbox" id="example-select-all"></th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Email Address</th>
                            <th>Phone Number</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Actions</th>
                        </thead>
                        <tbody>
                            @if(!empty($vendor_contacts))
                            @foreach($vendor_contacts as $key => $vendor_contact)
                            <tr>
                                <td><input type="checkbox" value="{{___encrypt($vendor_contact->id)}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{ $vendor_contact->name }}</td>
                                <td>{{ $vendor_contact->designation }}</td>
                                <td>{{ $vendor_contact->email }}</td>
                                <td>{{ $vendor_contact->phone_no }}</td>

                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" data-url="{{url('/organization/vendor/contact/'.___encrypt($vendor_contact->id).'?status='.$vendor_contact->status)}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" id="customSwitch-con{{___encrypt($vendor_contact->id)}}" @if($vendor_contact->status=='active') checked @endif>
                                        <label class="custom-control-label" for="customSwitch-con{{___encrypt($vendor_contact->id)}}"></label>
                                    </div>
                                </td>
                                <td class="text-center">
                                   
                                    <a href="javascript:void(0);" data-url="{{url('organization/vendor/contact/'.___encrypt($vendor_contact->id).'/edit')}}" data-request="ajax-popup" data-target="#edit-div-contact" data-tab="#editContactModal{{___encrypt($vendor_contact->id)}}" class="btn btn-sm btn-warning text-white btn-icon-text" data-toggle="tooltip" data-placement="bottom" title="Edit Tenant">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0);" data-url="{{url('organization/vendor/contact/'.___encrypt($vendor_contact->id))}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-sm btn-danger text-white btn-icon-text" data-toggle="tooltip" data-placement="bottom" title="Delete Tenant">
                                        <i class="fas fa-trash"></i>
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
@include('pages.console.tenant.vendor.contact_form')
@include('pages.console.tenant.vendor.location')
<div id="edit-div">
</div>
<div id="edit-div-contact">
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-net-bs4/dataTables.bootstrap4.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(function() {
        $('#vendor_contact_details').DataTable();
        $('#vendor_location_details').DataTable();
        $(":input").inputmask();
    });
</script>
@endpush