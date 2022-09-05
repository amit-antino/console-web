<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            <img class="img-fluid" src="{{ asset('/assets/images/logo.png') }}" alt="" width="150px;">
        </a>
        <div class="sidebar-toggler @if (!empty($get_cookie_value)) {{ $get_cookie_value }} @else not-active @endif ">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <?php

            use App\Models\Organization\Users\UserPermission;
            use App\Models\Tenant\TenantConfig;
            use App\Models\UserMenu;

            $user = Auth::user();
            if ($user->role == 'admin') {
                $tenant_id = Session::get('tenant_id');
            } else {
                $tenant = getTenent();
                $tenant_id = $tenant['id'];
            }

            $permissionEmp = UserPermission::where(['tenant_id' => $tenant_id, 'user_id' => Auth::user()->id, 'status' => 'active'])->first();

            $roles = !empty($permissionEmp->permission) ? $permissionEmp->permission : '';
            $config = TenantConfig::where(['tenant_id' => $tenant_id])
                ->first();
            $user_menu_group = $config->menu_group;
            $main_menu_id = [];
            $sub_menu_id = [];
            $sub_menu_ids = [];
            if (!empty($roles)) {
                $permission = $roles;
                $menus_id = [];
                foreach ($permission as $keys => $sub_perm) {
                    foreach ($sub_perm as $sub_keys => $perm) {
                        $menus_id[] = $perm['menu_id'];
                    }
                }
                $array_menu = UserMenu::whereIn('id', $menus_id)
                    ->get();
                if (!empty($array_menu)) {
                    foreach ($array_menu as $array_menu) {
                        if ($array_menu->parent_id == 0) {
                            $main_menu_id[] = $array_menu->id;
                        } else {
                            $sub_menu_id[] = $array_menu->parent_id;
                            $sub_menu_ids[] = $array_menu->id;
                        }
                    }
                }
                $menu_array = array_unique(array_merge($sub_menu_id, $main_menu_id));
                $menu = UserMenu::whereIn('id', $menu_array)
                    ->get();
            } else {
                if (!empty($user_menu_group->menu_list)) {
                    $array_menu = UserMenu::whereIn('id', $user_menu_group->menu_list)
                        ->get();
                    if (!empty($array_menu)) {
                        foreach ($array_menu as $array_menu) {
                            if ($array_menu->parent_id == 0) {
                                $main_menu_id[] = $array_menu->id;
                            } else {
                                $sub_menu_id[] = $array_menu->parent_id;
                                $sub_menu_ids[] = $array_menu->id;
                            }
                        }
                    }
                    $menu_array = array_unique(array_merge($sub_menu_id, $main_menu_id));
                    $menu = UserMenu::whereIn('id', $menu_array)
                        ->get();
                } else {
                    $menu = UserMenu::where('id', '=', 1)
                        ->get();
                }
            }
            ?>
            @php
            @endphp
            @if (!empty(_arefy($menu)))
            @foreach ($menu as $menus)
            @php
            $submenu = \DB::table('user_menus')
            ->where('parent_id', $menus->id)
            ->get();
            @endphp
            @if (!empty(_arefy($submenu)))
            <li class="nav-item {{ active_class([$menus->active_route . '/*']) }}">
                <a class="nav-link" data-toggle="collapse" href="#{{ $menus->menu_id }}" role="button" aria-expanded="{{ is_active_route([$menus->active_route . '/*']) }}" aria-controls="{{ $menus->menu_id }}">
                    <i class="link-icon" data-feather="{{ $menus->menu_icon }}"></i>
                    <span class="link-title">{{ $menus->name }}</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                @if (!empty(_arefy($submenu)))
                <div class="collapse {{ show_class([$menus->active_route . '/*']) }}" id="{{ $menus->menu_id }}">
                    <ul class="nav sub-menu">
                        @foreach ($submenu as $submenus)
                        @if (!empty($sub_menu_ids))
                        @if (in_array($submenus->id, $sub_menu_ids))
                        <li class="nav-item">
                            <a href="{{ url($submenus->menu_url) }}" class="nav-link {{ active_class([$submenus->active_route]) }}{{ active_class([$submenus->active_route . '/*']) }}">{{ $submenus->name }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item">
                            <a href="{{ url($submenus->menu_url) }}" class="nav-link {{ active_class([$submenus->active_route]) }}{{ active_class([$submenus->active_route . '/*']) }}">{{ $submenus->name }}</a>
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </div>
                @endif
            </li>
            @else
            <li class="nav-item {{ active_class([$menus->active_route]) }}{{ active_class([$menus->active_route . '/*']) }}">
                <a href="{{ url($menus->menu_url) }}" class="nav-link {{ active_class([$menus->active_route]) }}{{ active_class([$menus->active_route . '/*']) }}">
                    <i class="link-icon" data-feather="{{ $menus->menu_icon }}"></i>
                    <span class="link-title">{{ $menus->name }}</span>
                </a>
            </li>
            @endif
            @endforeach
            @endif
        </ul>
    </div>
</nav>