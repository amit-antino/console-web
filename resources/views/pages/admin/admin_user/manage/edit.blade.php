@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/organization/settings')}}">Organization</a></li>
        <li class="breadcrumb-item"><a href="{{url('admin/admin_users/'.___encrypt($data['tenant_id']).'/manage')}}">Permission Management</a></li>
        <li class="breadcrumb-item active">Edit Permission</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('/admin/admin_users/'.___encrypt($data['user_id']).'/manage/'.___encrypt($data['roles']['id']))}}" method="POST" role="admin-role">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Edit Permission</h4>
                </div>
                <div class="card-body">
                    <input type="hidden" name="_method" value="PUT">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="user_id">Select User
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select User"></i></span>
                            </label>
                            <select class="js-example-basic-single" name="user_id" id="user_id">
                                <option value="">Select User</option>
                                if(!empty($data['user']))
                                @foreach($data['user'] as $key => $value)
                                @if($data['roles']['user_id']==$value->id))
                                <option selected value="{{___encrypt($value->id)}}">{{$value['first_name']}} {{$value['last_name']}}</option>
                                @else
                                <option value="{{___encrypt($value->id)}}">{{$value['first_name']}} {{$value['last_name']}}</option>
                                @endif
                                @endforeach
                            </select>
                            @if(count($data['user']) === 0)
                            <label for="">
                                <span class="text-danger">Please Add User</span></label>
                            @endif
                        </div>
                        <div class="form-group col-md-6">

                            <input type="hidden" class="form-group" name="tenant_id" id="tenant_id" value="{{___encrypt($data['tenant_id'])}}">

                            @if(count($data['tenants']) === 0)
                            <label for="">
                                <span class="text-danger">Please Add User</span></label>
                            @endif
                        </div>
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="role_access_level">Permission
                                        <span class="text-danger">*</span>
                                        <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Menu Group Access Level"></i></span>
                                    </label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" id="select-all" class="form-check-input">
                                                Check All
                                            </label>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group col-md-12">
                                    <div class="row">
                                        @if(!empty($data['value']))
                                        @foreach($data['value'] as $sk =>$sv)
                                        <div class="col-md-6 grid-margin stretch-card">
                                            <div class="card border-left-secondary shadow h-100 py-2">
                                                <div class="card-header">

                                                    <div class="row no-gutters align-items-center">
                                                        <i data-feather="{{$sv['menu_icon']}}" class="text-secondary text-gray-200 link-icon"></i> &nbsp;
                                                        <div class="col mr-2">
                                                            <div class="h5 font-weight-bold text-secondary text-uppercase">
                                                                {{$sv['menu']}}
                                                                &nbsp; &nbsp; &nbsp;

                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="form-check form-check-inline ">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" id="{{$sv['menu_id']}}" class="form-check-input select-sub">

                                                                </label>
                                                            </div>
                                                        </div>


                                                    </div>

                                                </div>
                                                @if(!empty($sv['submenu']))
                                                <div class="card-body">
                                                    @foreach($sv['submenu'] as $subk=>$subv)
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            {{$subv['name']}}
                                                        </div>
                                                        <div class="col-sm-9 table-responsive">
                                                            <div class=" form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" @if(!empty($data["permission"][$subv['id']]) && in_array("index",$data["permission"][$subv['id']])) checked @endif name="permission[{{$subv['id']}}][index]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                                    Read
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" @if(!empty($data["permission"][$subv['id']]) && in_array("create",$data["permission"][$subv['id']])) checked @endif name="permission[{{$subv['id']}}][create]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                                    Create
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" @if(!empty($data["permission"][$subv['id']]) && in_array("show",$data["permission"][$subv['id']])) checked @endif name="permission[{{$subv['id']}}][show]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}} ">
                                                                    View
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" @if(!empty($data["permission"][$subv['id']]) && in_array("edit",$data["permission"][$subv['id']])) checked @endif name="permission[{{$subv['id']}}][edit]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                                    Edit
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" name="permission[{{$subv['id']}}][delete]" @if(!empty($data["permission"][$subv['id']]) && in_array("delete",$data["permission"][$subv['id']])) checked @endif class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                                    Delete
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" name="permission[{{$subv['id']}}][manage]" @if(!empty($data["permission"][$subv['id']]) && in_array("manage",$data["permission"][$subv['id']])) checked @endif class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                                    Manage
                                                                </label>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @else
                                                <div class="card-body">

                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input @if(!empty($data["permission"][$sv['menu_id']]) && in_array("index",$data["permission"][$sv['menu_id']])) checked @endif type="checkbox" name="permission[{{$sv['menu_id']}}][index]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                            Read
                                                        </label>
                                                    </div>
                                                    @if($sv['menu_id']!=1)
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" @if(!empty($data["permission"][$sv['menu_id']]) && in_array("create",$data["permission"][$sv['menu_id']])) checked @endif name="permission[{{$sv['menu_id']}}][create]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                            Create
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" @if(!empty($data["permission"][$sv['menu_id']]) && in_array("show",$data["permission"][$sv['menu_id']])) checked @endif name="permission[{{$sv['menu_id']}}][show]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                            View
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" @if(!empty($data["permission"][$sv['menu_id']]) && in_array("edit",$data["permission"][$sv['menu_id']])) checked @endif name="permission[{{$sv['menu_id']}}][edit]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                            Edit
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="permission[{{$sv['menu_id']}}][delete]" @if(!empty($data["permission"][$sv['menu_id']]) && in_array("delete",$data["permission"][$sv['menu_id']])) checked @endif class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                            Delete
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" name="permission[{{$sv['menu_id']}}][manage]" @if(!empty($data["permission"][$sv['menu_id']]) && in_array("manage",$data["permission"][$sv['menu_id']])) checked @endif class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                            Manage
                                                        </label>
                                                    </div>
                                                    @endif
                                                </div>
                                                @endif

                                            </div>
                                        </div>
                                        @endforeach
                                        @endif



                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="admin-role"]' class="btn btn-sm btn-secondary submit">Submit</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{url('admin/admin_users/'.___encrypt($data['tenant_id']).'/manage')}}" class="btn btn-danger btn-sm">Cancel</a>
                    </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('assets/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(function() {
        if ($(".js-example-basic-single").length) {
            $(".js-example-basic-single").select2();
        }
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
    });

    function getMenu(id) {

        event.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var url = "{{URL('/admin/admin_users/getmenu')}}";
        objectexp = {
            "id": id
        };
        $.ajax({
            type: 'POST',
            url: url,
            data: JSON.stringify(objectexp),
            cache: false,
            contentType: false,
            processData: false,
            success: function(result) {
                $("#appendmenu").html(result);

            },
        });
    }
    $(document).on('click', '.select-sub', function() {
        $('.checkSub' + this.id).not(this).prop('checked', this.checked);

    });
</script>
@endpush