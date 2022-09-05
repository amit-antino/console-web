<div class="col-sm-9 table-responsive">
    <ul class="archive_year">
        @foreach($subv['sub_child_menus'] as $child_menu)
        @if(!empty($child_menu['sub_module_name']))
        <li class="years">
            <div class="col-md-6">
                <label><strong>{{sub_menu_name($child_menu['sub_module_name'])}}</strong></label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input type="checkbox" @if(!empty($user_perms[$subv['id']][$child_menu['sub_module_name']]['method']) && in_array("index",$user_perms[$subv['id']][$child_menu['sub_module_name']]['method'])) checked @endif name="permission[{{$subv['id']}}][{{$child_menu['sub_module_name']}}][index]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                    Read
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input type="checkbox" @if(!empty($user_perms[$subv['id']][$child_menu['sub_module_name']]['method']) && in_array("create",$user_perms[$subv['id']][$child_menu['sub_module_name']]['method'])) checked @endif name="permission[{{$subv['id']}}][{{$child_menu['sub_module_name']}}][create]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                    Create
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input type="checkbox" @if(!empty($user_perms[$subv['id']][$child_menu['sub_module_name']]['method']) && in_array("edit",$user_perms[$subv['id']][$child_menu['sub_module_name']]['method'])) checked @endif name="permission[{{$subv['id']}}][{{$child_menu['sub_module_name']}}][edit]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                    Edit
                </label>
            </div>
            <div class="form-check form-check-inline">
                <label class="form-check-label">
                    <input type="checkbox" @if(!empty($user_perms[$subv['id']][$child_menu['sub_module_name']]['method']) && in_array("delete",$user_perms[$subv['id']][$child_menu['sub_module_name']]['method'])) checked @endif name="permission[{{$subv['id']}}][{{$child_menu['sub_module_name']}}][delete]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                    Delete
                </label>
            </div>

            @if(!empty($child_menu['sub_sub_modules']))
            <ul class="archive_month">
                @foreach($child_menu['sub_sub_modules'] as $sub_sub_module)
                <li class="months">
                    <div class="col-md-6">
                        <label><strong>{{sub_menu_name($sub_sub_module['sub_sub_module_name'])}}</strong></label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input type="checkbox" @if(!empty($user_perms[$subv['id']][$sub_sub_module['sub_sub_module_name']]['method']) && in_array("index",$user_perms[$subv['id']][$sub_sub_module['sub_sub_module_name']]['method'])) checked @endif name="permission[{{$subv['id']}}][{{$sub_sub_module['sub_sub_module_name']}}][index]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                            Read
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input type="checkbox" @if(!empty($user_perms[$subv['id']][$sub_sub_module['sub_sub_module_name']]['method']) && in_array("create",$user_perms[$subv['id']][$sub_sub_module['sub_sub_module_name']]['method'])) checked @endif name="permission[{{$subv['id']}}][{{$sub_sub_module['sub_sub_module_name']}}][create]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                            Create
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input type="checkbox" @if(!empty($user_perms[$subv['id']][$sub_sub_module['sub_sub_module_name']]['method']) && in_array("edit",$user_perms[$subv['id']][$sub_sub_module['sub_sub_module_name']]['method'])) checked @endif name="permission[{{$subv['id']}}][{{$sub_sub_module['sub_sub_module_name']}}][edit]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                            Edit
                        </label>
                    </div>
                    <div class="form-check form-check-inline">
                        <label class="form-check-label">
                            <input type="checkbox" @if(!empty($user_perms[$subv['id']][$sub_sub_module['sub_sub_module_name']]['method']) && in_array("delete",$user_perms[$subv['id']][$sub_sub_module['sub_sub_module_name']]['method'])) checked @endif name="permission[{{$subv['id']}}][{{$sub_sub_module['sub_sub_module_name']}}][delete]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                            Delete
                        </label>
                    </div>
                    @if(!empty($sub_sub_module['sub_sub_sub_modules']))
                    <ul class="archive_posts">

                        @foreach($sub_sub_module['sub_sub_sub_modules'] as $sub_sub_sub_modules)
                        <li class="posts">
                            <div class="col-md-6">
                                <label><strong>{{sub_menu_name($sub_sub_sub_modules['sub_sub_sub_module_name'])}}</strong></label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" @if(!empty($user_perms[$subv['id']][$sub_sub_sub_modules['sub_sub_sub_module_name']]['method']) && in_array("index",$user_perms[$subv['id']][$sub_sub_sub_modules['sub_sub_sub_module_name']]['method'])) checked @endif name="permission[{{$subv['id']}}][{{$sub_sub_sub_modules['sub_sub_sub_module_name']}}][index]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                    Read
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" @if(!empty($user_perms[$subv['id']][$sub_sub_sub_modules['sub_sub_sub_module_name']]['method']) && in_array("create",$user_perms[$subv['id']][$sub_sub_sub_modules['sub_sub_sub_module_name']]['method'])) checked @endif name="permission[{{$subv['id']}}][{{$sub_sub_sub_modules['sub_sub_sub_module_name']}}][create]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                    Create
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" @if(!empty($user_perms[$subv['id']][$sub_sub_sub_modules['sub_sub_sub_module_name']]['method']) && in_array("edit",$user_perms[$subv['id']][$sub_sub_sub_modules['sub_sub_sub_module_name']]['method'])) checked @endif name="permission[{{$subv['id']}}][{{$sub_sub_sub_modules['sub_sub_sub_module_name']}}][edit]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                    Edit
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="checkbox" @if(!empty($user_perms[$subv['id']][$sub_sub_sub_modules['sub_sub_sub_module_name']]['method']) && in_array("delete",$user_perms[$subv['id']][$sub_sub_sub_modules['sub_sub_sub_module_name']]['method'])) checked @endif name="permission[{{$subv['id']}}][{{$sub_sub_sub_modules['sub_sub_sub_module_name']}}][delete]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                    Delete
                                </label>
                            </div>

                            @if(!empty($sub_sub_sub_modules['sub_sub_sub_sub_modules']))
                            <ul class="archive_posts">

                                @foreach($sub_sub_sub_modules['sub_sub_sub_sub_modules'] as $sub_sub_sub_sub_modules)
                                <li class="posts">
                                    <div class="col-md-6">
                                        <label><strong>{{sub_menu_name($sub_sub_sub_sub_modules['sub_sub_sub_sub_module_name'])}}</strong></label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" @if(!empty($user_perms[$subv['id']][$sub_sub_sub_sub_modules['sub_sub_sub_sub_module_name']]['method']) && in_array("index",$user_perms[$subv['id']][$sub_sub_sub_sub_modules['sub_sub_sub_sub_module_name']]['method'])) checked @endif name="permission[{{$subv['id']}}][{{$sub_sub_sub_sub_modules['sub_sub_sub_sub_module_name']}}][index]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                            Read
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" @if(!empty($user_perms[$subv['id']][$sub_sub_sub_sub_modules['sub_sub_sub_sub_module_name']]['method']) && in_array("create",$user_perms[$subv['id']][$sub_sub_sub_sub_modules['sub_sub_sub_sub_module_name']]['method'])) checked @endif name="permission[{{$subv['id']}}][{{$sub_sub_sub_sub_modules['sub_sub_sub_sub_module_name']}}][create]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                            Create
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" @if(!empty($user_perms[$subv['id']][$sub_sub_sub_sub_modules['sub_sub_sub_sub_module_name']]['method']) && in_array("edit",$user_perms[$subv['id']][$sub_sub_sub_sub_modules['sub_sub_sub_sub_module_name']]['method'])) checked @endif name="permission[{{$subv['id']}}][{{$sub_sub_sub_sub_modules['sub_sub_sub_sub_module_name']}}][edit]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                            Edit
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" @if(!empty($user_perms[$subv['id']][$sub_sub_sub_sub_modules['sub_sub_sub_sub_module_name']]['method']) && in_array("delete",$user_perms[$subv['id']][$sub_sub_sub_sub_modules['sub_sub_sub_sub_module_name']]['method'])) checked @endif name="permission[{{$subv['id']}}][{{$sub_sub_sub_sub_modules['sub_sub_sub_sub_module_name']}}][delete]" class="form-check-input checkSingle checkSub{{$sv['menu_id']}}">
                                            Delete
                                        </label>
                                    </div>
                                </li>
                                @endforeach
                            </ul>

                            @endif
                        </li>
                        @endforeach
                    </ul>

                    @endif
                </li>
                @endforeach
            </ul>

            @endif
        </li>

        @endif
        @endforeach
    </ul>

</div>