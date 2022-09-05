@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/datatables-net/dataTables.bootstrap4.css') }}" rel="stylesheet" />
@endpush
@php
$per = request()->get('sub_menu_permission');
$permission=!empty($per['profile']['method'])?$per['profile']['method']:[];
@endphp
@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Vendors</li>
    </ol>
</nav>
<div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
    <div>
        <h4 class="mb-3 mb-md-0">Vendors</h4>
    </div>
    <div class="d-flex align-items-center flex-wrap text-nowrap">
        <button type="button" class="btn btn-sm btn-outline-info btn-icon-text mr-2 d-none d-md-block" data-toggle="modal" data-target="#vendorModal">
            <i class="fas fa-download"></i>&nbsp;
            Import
        </button>
        <a href="{{url('/organization/vendor/create')}}" class="btn btn-sm btn-secondary btn-icon-text mr-2 d-none d-md-block" @if(in_array('create',$permission)) href="{{url('/organization/vendor/create')}}" @else data-request="ajax-permission-denied" @endif>
            <i class="fas fa-plus"></i>&nbsp;
            Add Vendor
        </a>
        <div class="deletebulk">
            <button type="button" data-url="{{url('/organization/vendor/bulk-delete')}}" data-method="POST" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" data-id="bulk-delete" class="btn btn-sm btn-danger btn-icon-text mb-2 mb-md-0" @if(in_array('delete',$permission)) href="{{url('/organization/vendor/create')}}" @else data-request="ajax-permission-denied" @endif>
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
                    <table id="vendor_list" class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="example-select-all"></th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Classifications</th>
                                <th>Location</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $cnt = count($vendors)
                            @endphp
                            @if(!empty($vendors))
                            @foreach($vendors as $vendor)
                            <tr>
                                <td><input type="checkbox" value="{{___encrypt($vendor->id)}}" class="checkSingle" name="select_all[]"></td>
                                <td>{{ $vendor->name}}</td>
                                <td>{{ !empty($vendor->category->name)?$vendor->category->name:''}}</td>
                                <td>{{ !empty($vendor->classification->name)?$vendor->classification->name:''}}</td>
                                <td>{{ !empty($vendor->location->name)?$vendor->location->name:''}}</td>
                                <td class="text-center">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" data-url="{{url('/organization/vendor/'.___encrypt($vendor->id).'?status='.$vendor->status)}}" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" class="custom-control-input" id="customSwitch{{___encrypt($vendor->id)}}" @if($vendor->status=='active') checked @endif>
                                        <label class="custom-control-label" for="customSwitch{{___encrypt($vendor->id)}}"></label>
                                    </div>
                                </td>
                                <td class="text-center">


                                    <div class="btn-group btn-group-sm" role="group">
                                        <a class="btn btn-icon" data-toggle="tooltip" data-placement="top" title="Manage Vendor" @if(in_array('manage',$permission)) href="{{ url('/organization/vendor/'.___encrypt($vendor->id).'/manage') }}" @else data-request="ajax-permission-denied" @endif>
                                            <i class="fas fa-cogs text-secondary"></i>
                                        </a>
                                        <a class="btn btn-icon" data-toggle="tooltip" data-placement="top" title="View Vendor" @if(in_array('view',$permission)) href="{{ url('/organization/vendor/'.___encrypt($vendor->id)) }}" @else data-request="ajax-permission-denied" @endif>
                                            <i class="fas fa-eye text-secondary"></i>
                                        </a>
                                        <a class="btn btn-icon" data-toggle="tooltip" data-placement="top" title="Edit Vendor" @if(in_array('edit',$permission)) href="{{ url('/organization/vendor/'.___encrypt($vendor->id).'/edit') }}" @else data-request="ajax-permission-denied" @endif>
                                            <i class="fas fa-edit text-secondary"></i>
                                        </a>
                                        <a href="javascript:void(0);" data-method="DELETE" data-request="ajax-confirm" data-ask_image="warning" data-ask="Are you sure you want to delete?" class="btn btn-icon" data-toggle="tooltip" data-placement="top" title="Delete Vendor" @if(in_array('delete',$permission)) data-url="{{url('/organization/vendor/'.___encrypt($vendor->id))}}" @else data-request="ajax-permission-denied" @endif>
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

<div class="modal fade " id="vendorModal" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userLabel">Import Vendors</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{url('/organization/vendor/importFile')}}" method="post" enctype="multipart/form-data" role="vendors-import">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="control-label">Import CSV
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Profile"></i></span>
                            </label>
                            <input type="file" id="select_file" name="select_file" class="form-control-file">
                        </div>
                    </div>
                    <hr>
                    <div class="text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="vendors-import"]' class="btn btn-sm btn-secondary">Upload</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                    </div>
                </form>
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
    // alert(2);
    var cnt = '{{$cnt}}'
    $(function() {
        if (cnt > 10) {
            $('#vendor_list').DataTable();
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
        $('.checkSingle').click(function() {
            var len = $("[name='select_all[]']:checked").length;
            if (len > 1) {
                $(".deletebulk").show();
            } else {
                $(".deletebulk").hide();
            }

        });
    });
</script>
@endpush