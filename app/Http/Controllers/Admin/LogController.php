<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\Organization\Users\User;
use App\Models\Tenant\TenantConfig;
use App\Models\UserMenu;
use App\Models\Tenant\TenantMenuGroup;
class LogController extends Controller
{
    public function index(Request $request)
    {
        $data = ActivityLog::orderBy("id", "desc")->limit(450)->get();
        $menu = UserMenu::get();
        // dd($menu);

        // $user=User::get(['first_name']);
        // $user=$userr->get(['first_name']);
        // dd($user);
        // $userr=($user->User);
        // dd($user);
        // $user =$userr->get(['first_name']);

        // dd($user);
        $users = User::where('role', 'admin')->get();

        $object = [];
        if (!empty($data)) {
            $userarray = [];
            if (!empty($arr)) {
                 $userarray =$users;

            }
            if ($request->ajax()) {
                return response()->json([
                    'status'    => true,
                    'html'      => view('pages.console.report.experiment.list', compact('userarray','users','menu'))->render()
                ]);
            }

            foreach ($data as $k => $v) {
                $orgnm=getUser($v['causer_id']);
              
                $object[] = [
                    'id' => $v['id'],
                    'organization_name' =>isset($orgnm['organization_name'])?$orgnm['organization_name']:'',// getUser($v['causer_id'])['organization_name'],
                    'data' => getUser($v['causer_id']),
                    'log_name' => $v['log_name'],
                    'event' => $v['log_name'] . ' ' . $v['description'],
                    'time' => ___ago($v->created_at),
                    'name' =>getUser($v['causer_id'])
                ];
            }
         
        }
        return view('pages.admin.logs.index', compact('object','userarray','users','menu'));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
