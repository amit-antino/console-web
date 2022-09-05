<div class="row">
    <div class="form-group col-md-12">
        <ul class="tree" id="tree">
            @php
            $menu = \App\Models\UserMenu::where('parent_id','=',0)->get();
            @endphp
            @if(!empty(_arefy($menu)))
            @foreach($menu as $menus)
            @php
            $submenu = \App\Models\UserMenu::where('parent_id',$menus->id)->get();
            @endphp
            @if(!empty(_arefy($submenu)))
            <li >
                <input type="checkbox" value="{{$menus->id}}" id="menu_list" class="form-check-input checkSingle" name="menu_list[]">{{$menus->name}}
                @if(!empty(_arefy($submenu)))
                <ul>
                    @foreach($submenu as $submenus)
                    <li class="form-check form-check-inline">
                        <input type="checkbox" value="{{$submenus->id}}" id="menu_list" class="form-check-input checkSingle" name="menu_list[]">{{$submenus->name}}
                    </li>
                    @endforeach
                </ul>
                @endif
            </li>
            @else
            <li >
                <input type="checkbox" value="{{$menus->id}}" id="menu_list" class="form-check-input checkSingle" name="menu_list[]">{{$menus->name}}
            </li>
            @endif
            @endforeach
            @endif
        </ul>
    </div>
</div>