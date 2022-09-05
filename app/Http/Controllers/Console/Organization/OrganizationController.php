<?php

namespace App\Http\Controllers\Console\Organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Organization\Users\User;

use App\Models\Organization\Experiment\EquipmentUnit;
use App\Models\Organization\Users\UserPermission;
use App\Models\Tenant\Tenant;
use App\Models\Tenant\TenantConfig;
use App\Models\Tenant\TenantUser;
use Illuminate\Support\Facades\Auth;

class OrganizationController extends Controller
{
    public function index()
    {
        $organization = [];
        $object = getTenent();
        if (!empty($object)) {
            $organization['name'] = $object['name'];
            $organization['organization_logo'] = '';
            $organization['no_users'] = 0;
            $organization['account_name'] = '';
            $organization['billing_email'] = '';
            $organization['billing_phone_no'] = '';
            $organization['billing_address'] = '';
            $organization['description'] = $object['description'];
            $organization['id'] = $object['id'];
        }
        $tenant_id = ___encrypt($object['id']);
        $user_count =  User::where('created_by', Auth::user()->id)->count();
        $data['tenant'] = Tenant::find(___decrypt($tenant_id));
        $config = TenantConfig::find(___decrypt($tenant_id));
        $data['locations_count'] = count(!empty($config->location) ? $config->location : []);
        $user_count =  TenantUser::where('tenant_id', ___decrypt($tenant_id))->count();
        $data['users_count'] = $user_count;
        $data['menu_count'] = 1;
        $data['user_group_count'] = count(!empty($config->user_group) ? $config->user_group : []);
        $data['designation_count'] = count(!empty($config->designation) ? $config->designation : []);
        $user_permission_count = UserPermission::where('tenant_id', ___decrypt($tenant_id))->where('user_group_id', '!=', '0')->count();
        $user_permission_last_update = UserPermission::where('tenant_id', ___decrypt($tenant_id))->where('user_group_id', '!=', '0')->latest()->first();
        if ($user_permission_count) {
            $data['user_permission_count'] = $user_permission_count;
        } else {
            $data['user_permission_count'] = 0;
        }
        return view('pages.console.tenant.index', $data, compact('organization', 'data', 'tenant_id'));
    }

    public function masters()
    {
        return view('pages.console.tenant.masters.index');
    }
}
