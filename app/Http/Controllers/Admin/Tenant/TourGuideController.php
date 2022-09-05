<?php

namespace App\Http\Controllers\Admin\Tenant;

use App\Http\Controllers\Controller;
use App\Models\UserMenu;
use Illuminate\Http\Request;

class TourGuideController extends Controller
{
    public function index($tenant_id)
    {
        $data['menus'] = UserMenu::get();
        $data['tenant_id'] = $tenant_id;
        return view('pages.admin.tenant.tour_guide.index', $data);
    }

    public function create($tenant_id)
    {
        $data['menus'] = UserMenu::get();
        $data['tenant_id'] = $tenant_id;
        return view('pages.admin.tenant.tour_guide.index', $data);
    }

    public function store(Request $request , $tenant_id)
    {
        $data['menus'] = UserMenu::get();
        $data['tenant_id'] = $tenant_id;
        return view('pages.admin.tenant.tour_guide.index', $data);
    }
}
