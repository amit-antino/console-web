@extends('layout.admin.master')

@push('plugin-styles')
<link href="{{ asset('/assets/plugins/select2/select2.min.css') }}" rel="stylesheet" />
@endpush

@section('content')
<nav class="page-breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{url('/admin/dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant')}}">Tenants</a></li>
        <li class="breadcrumb-item"><a href="{{url('/admin/tenant/manage/'.___encrypt($tenant->id))}}">{{$tenant->organization_name}}</a></li>
        <li class="breadcrumb-item active" aria-current="page">Database Configuration</li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-12 stretch-card">
        <div class="card shadow">
            <form action="{{url('/admin/tenant/manage/'.___encrypt($tenant->id).'/database_config')}}" role="migrate" method="POST">
                <div class="card-header">
                    <h4 class="mb-3 mb-md-0">Database Configuration</h4>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="role_access_level">Select Role Access Level
                                <span class="text-danger">*</span>
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Role Access Level"></i></span>
                            </label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" id="select-all" class="form-check-input" checked name="all_modules">
                                        Check All
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <ul class="tree" id="tree">
                                @php
                                $menu = \DB::table('user_menus')->where('parent_id','=',0)->get();
                                @endphp
                                @if(!empty(_arefy($menu)))
                                @foreach($menu as $menus)
                                @php
                                $submenu = \DB::table('user_menus')->where('parent_id',$menus->id)->get();
                                @endphp
                                @if(!empty(_arefy($submenu)))
                                <li>
                                    <input id="menu_list" class="form-check-input checkSingle" type="checkbox" @if(in_array($menus->id)
                                    checked @endif
                                    value="{{$menus->id}}" name="menu_list[]">{{$menus->name}}
                                    <!-- AND SHOULD CHECK HERE -->
                                    @if(!empty(_arefy($submenu)))
                                    <ul>
                                        @foreach($submenu as $submenus)
                                        <li class="form-check form-check-inline">
                                            <input id="menu_list" class="form-check-input checkSingle" @if(in_array($submenus->id) checked @endif type="checkbox" value="{{$submenus->id}}" name="menu_list[]">{{$submenus->name}}
                                        </li>
                                        @endforeach

                                    </ul>
                                    @endif
                                </li>
                                @else
                                <li>
                                    <input id="menu_list" class="form-check-input checkSingle" type="checkbox" @if(in_array($menus->id)) checked @endif value="{{$menus->id}}" name="menu_list[]">{{$menus->name}}
                                </li>
                                @endif
                                @endforeach
                                @endif
                            </ul>
                        </div>

                    </div>
                    <div class="card-footer text-right">
                        <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="migrate"]' class="btn btn-sm btn-secondary submit">Migrate Database</button>
                        <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{Config::get('constants.message.loader_button_msg')}}
                        </button>
                        <a href="{{url('/admin/tenant')}}" class="btn btn-sm btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
            <form method="POST" action="{{url('/admin/tenant/manage/'.___encrypt($tenant->id).'/seed_data')}}" role="seed">
                <button type="button" id="submit_button_id" data-request="ajax-submit" data-target='[role="seed"]' class="btn btn-sm btn-secondary submit">Seeder Database</button>
                <button id="submit_button_loader" style="display: none;" class="btn btn-sm btn-secondary submit" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    {{Config::get('constants.message.loader_button_msg')}}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
<script src="{{ asset('/assets/plugins/select2/select2.min.js') }}"></script>
@endpush

@push('custom-scripts')
<script>
    $(function() {
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