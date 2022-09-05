@extends('layout.console.master')

@push('plugin-styles')
<link href="{{ asset('assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/jquery-tags-input/jquery.tagsinput.min.css') }}" rel="stylesheet" />
<style>
    #years,
    #months,
    #posts {
        cursor: pointer;
    }

    .archive_year {
        margin-left: 1em;
        font-size: large;
        font-weight: bold;
        cursor: pointer;
    }

    .archive_month {
        margin-left: 1em;
        margin-top: 0;
        margin-bottom: 1em;
        list-style-type: circle;
        font-size: medium;
        cursor: pointer;
    }

    .archive_posts {
        margin-left: 1em;
        margin-top: 0;
        margin-bottom: 1em;
        list-style: square url('http://www.webbossuk.com/admin/images/reply-arrow.png');
        font-weight: normal;
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('organization/')}}">Organization</a></li>
        <li class="breadcrumb-item"><a href="{{url('organization/'.$tenant_id.'/user_permission')}}">User Pernission</a></li>
        <li class="breadcrumb-item active">Edit User Permission</li>
    </ol>
</nav>
<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('organization/'.$tenant_id.'/user_permission/'.___encrypt($permissions->id))}}" method="POST" role="employee">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Edit User Permission</h4>
                </div>
                <div class="card-body">
                    @csrf
                    <input type="hidden" value="PUT" name="_method" />
                    <div class="form-row">
                        @if(!empty($permissions->user_id))
                        <div class="form-group col-md-6">
                            <label for="user_id">Select User
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select User"></i></span>
                            </label>
                            <select class="" name="user_id" id="user_id" disabled>
                                @if(!empty($data['admin_user']))
                                <optgroup label="Admin User">
                                    @foreach($data['admin_user'] as $key => $value)
                                    <option @if($permissions->user_id==$value['id']) selected @endif value="{{___encrypt($value['id'])}}">{{$value['first_name']}} {{$value['last_name']}} </option>
                                    @endforeach
                                </optgroup>
                                @endif
                            </select>
                        </div>
                        @endif
                        <div class="form-group col-md-6">
                            <label for="department_id">Select User Group
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select User Group"></i></span>
                            </label>
                            <select class="form-control" name="department_id" id="department_id" disabled>
                                <option value="">Select User Group</option>
                                if(!empty($data['department']))
                                @foreach($data['department'] as $key => $value)
                                <option @if($permissions->user_group_id==$value['id']) selected @endif value="{{___encrypt($value['id'])}}">{{$value['name']}}</option>
                                @endforeach
                            </select>
                            @if(count($data['department']) === 0)
                            <label for="">
                                <span class="text-danger">Please Add User Group</span></label>
                            @endif
                        </div>
                        <!-- <div class="form-group col-md-4">
                            <label for="designation_id">Select Designation
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select Designation"></i></span>
                            </label>
                            <select class="form-control" name="designation_id" id="designation_id">
                                <option value="">Select Designation</option>
                                if(!empty($data['designation']))
                                @foreach($data['designation'] as $key => $value)
                                <option @if($permissions->designation_id==$value['id']) selected @endif value="{{___encrypt($value['id'])}}">{{$value['name']}}</option>
                                @endforeach
                            </select>
                            @if(count($data['designation']) === 0)
                            <label for="">
                                <span class="text-danger">Please Add Designation</span></label>
                            @endif
                        </div> -->
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
                                                                    <input type="checkbox" id="{{$sv['menu_id']}}" @if(!empty($user_perms[$sv['menu_id']]['profile']['method']) && in_array("index",$user_perms[$sv['menu_id']]['profile']['method'])) checked @endif class="form-check-input select-sub">

                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if(!empty($sv['submenu']))
                                                <div class="card-body">
                                                    @foreach($sv['submenu'] as $subk=>$subv)
                                                    @if(in_array($subv['id'],$data['menu_list']))
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            {{$subv['name']}}
                                                        </div>
                                                        @if(empty($subv['sub_child_menus']))
                                                        <div class="col-sm-9 table-responsive">
                                                            <div class=" form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" @if(!empty($user_perms[$subv['id']]['profile']['method']) && in_array("index",$user_perms[$subv['id']]['profile']['method'])) checked @endif name="permission[{{$subv['id']}}][index]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                                    Read
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" @if(!empty($user_perms[$subv['id']]['profile']['method']) && in_array("create",$user_perms[$subv['id']]['profile']['method'])) checked @endif name="permission[{{$subv['id']}}][create]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                                    Create
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" @if(!empty($user_perms[$subv['id']]['profile']['method']) && in_array("show",$user_perms[$subv['id']]['profile']['method'])) checked @endif name="permission[{{$subv['id']}}][show]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}} ">
                                                                    View
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" @if(!empty($user_perms[$subv['id']]['profile']['method']) && in_array("edit",$user_perms[$subv['id']]['profile']['method'])) checked @endif name="permission[{{$subv['id']}}][edit]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                                    Edit
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" @if(!empty($user_perms[$subv['id']]['profile']['method']) && in_array("delete",$user_perms[$subv['id']]['profile']['method'])) checked @endif name="permission[{{$subv['id']}}][delete]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                                    Delete
                                                                </label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <label class="form-check-label">
                                                                    <input type="checkbox" @if(!empty($user_perms[$subv['id']]['profile']['method']) && in_array("manage",$user_perms[$subv['id']]['profile']['method'])) checked @endif name="permission[{{$subv['id']}}][manage]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                                    Manage
                                                                </label>
                                                            </div>
                                                        </div>
                                                        @else
                                                        @include('pages.console.tenant.user_permission.sub_menu')
                                                        @endif
                                                    </div>
                                                    @endif
                                                    @endforeach
                                                </div>
                                                @else
                                                <div class="card-body">
                                                    @if(empty($sv['child_menus']))
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input @if($sv['menu_id']==1) checked @endif type="checkbox" name="permission[{{$sv['menu_id']}}][index]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                            Read
                                                        </label>
                                                    </div>
                                                    @if($sv['menu_id']!=1)
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" @if(!empty($user_perms[$sv['menu_id']]['profile']['method']) && in_array("create",$user_perms[$sv['menu_id']]['profile']['method'])) checked @endif name="permission[{{$sv['menu_id']}}][create]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                            Create
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" @if(!empty($user_perms[$sv['menu_id']]['profile']['method']) && in_array("show",$user_perms[$sv['menu_id']]['profile']['method'])) checked @endif name="permission[{{$sv['menu_id']}}][show]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                            View
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" @if(!empty($user_perms[$sv['menu_id']]['profile']['method']) && in_array("edit",$user_perms[$sv['menu_id']]['profile']['method'])) checked @endif name="permission[{{$sv['menu_id']}}][edit]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                            Edit
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" @if(!empty($user_perms[$sv['menu_id']]['profile']['method']) && in_array("delete",$user_perms[$sv['menu_id']]['profile']['method'])) checked @endif name="permission[{{$sv['menu_id']}}][delete]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                            Delete
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" @if(!empty($user_perms[$sv['menu_id']]['profile']['method']) && in_array("manage",$user_perms[$sv['menu_id']]['profile']['method'])) checked @endif name="permission[{{$sv['menu_id']}}][manage]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                            Manage
                                                        </label>
                                                    </div>
                                                    @endif
                                                    @else

                                                    @foreach($sv['child_menus'] as $child_menu)
                                                    @if(!empty($sv['child_menus']))
                                                    <div class="col-md-6">
                                                        <label><strong>{{ucfirst($child_menu['sub_module_name'])}}</strong></label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" @if(!empty($user_perms[$sv['menu_id']][$child_menu['sub_module_name']]['method']) && in_array("index",$user_perms[$sv['menu_id']][$child_menu['sub_module_name']]['method'])) checked @endif name="permission[{{$sv['menu_id']}}][{{$child_menu['sub_module_name']}}][index]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                            Read
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" @if(!empty($user_perms[$sv['menu_id']][$child_menu['sub_module_name']]['method']) && in_array("create",$user_perms[$sv['menu_id']][$child_menu['sub_module_name']]['method'])) checked @endif name="permission[{{$sv['menu_id']}}][{{$child_menu['sub_module_name']}}][create]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                            Create
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" @if(!empty($user_perms[$sv['menu_id']][$child_menu['sub_module_name']]['method']) && in_array("edit",$user_perms[$sv['menu_id']][$child_menu['sub_module_name']]['method'])) checked @endif name="permission[{{$sv['menu_id']}}][{{$child_menu['sub_module_name']}}][edit]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                            Edit
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <label class="form-check-label">
                                                            <input type="checkbox" @if(!empty($user_perms[$sv['menu_id']][$child_menu['sub_module_name']]['method']) && in_array("delete",$user_perms[$sv['menu_id']][$child_menu['sub_module_name']]['method'])) checked @endif name="permission[{{$sv['menu_id']}}][{{$child_menu['sub_module_name']}}][delete]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                                            Delete
                                                        </label>
                                                    </div>
                                                    @endif
                                                    @endforeach
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
                        <div class="form-group col-md-12">
                            <label for="description">Description
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Add Description"></i></span>
                            </label>
                            <textarea id="description" name="description" class="form-control" maxlength="10000" rows="5" placeholder="Description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="employee"]' class="btn btn-sm btn-secondary submit">Submit</button>
                    <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        {{Config::get('constants.message.loader_button_msg')}}
                    </button>
                    <a href="{{url('organization/'.$tenant_id.'/user_permission')}}" class="btn btn-danger btn-sm">Cancel</a>
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
        if ($(".").length) {
            $(".").select2();
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
    $(document).on('click', '.select-sub', function() {
        $('.checkSub' + this.id).not(this).prop('checked', this.checked);

    });
    // $('.archive_month ul').hide();
    // console.log('out');
    // $('.months').click(function() {
    //     console.log('dfgdsg');
    //     $(this).find('ul').slideToggle();
    // });
</script>
@endpush