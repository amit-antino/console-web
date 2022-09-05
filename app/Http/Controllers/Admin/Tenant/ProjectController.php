<?php

namespace App\Http\Controllers\Admin\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Country;
use App\Models\Tenant\TenantConfig;
use App\Models\Tenant\TenantUser;

class ProjectController extends Controller
{
    public function index($tenant_id)
    {
        $data['project'] = Project::where(['tenant_id' => ___decrypt($tenant_id)])->get();
        $data['countries'] = Country::all();
        $config = TenantConfig::where(['tenant_id' => ___decrypt($tenant_id)])->first();
        $data['locations'] = $config->location;
        $data['tenant_id'] = $tenant_id;
        $where = 1;
        $where .= ' AND tenant_id =' . ___decrypt($tenant_id);
        $tenent_users = TenantUser::list('array', $where);
        $user_data = [];
        if (!empty($tenent_users)) {
            foreach ($tenent_users as $key => $users) {
                if (!empty($users['user_details'])) {
                    $user_data[$key]['id'] = $users['user_details']['id'];
                    $user_data[$key]['first_name'] = $users['user_details']['first_name'];
                    $user_data[$key]['last_name'] = $users['user_details']['last_name'];
                    $user_data[$key]['email'] = $users['user_details']['email'];
                }
            }
        }
        $data['users'] = $user_data;
        return view('pages.admin.tenant.project.index', $data);
    }

    public function store(Request $request, $tenant_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'users' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $project =  new Project();
            $project['tenant_id'] = ___decrypt($tenant_id);
            $project['name'] = $request->name;
            $project['description'] = $request->description;
            $project['tags'] = $request->tags;
            $user_id = [];
            if (!empty($request->users)) {
                foreach ($request->users as $user) {
                    $user_id[] = ___decrypt($user);
                }
            }
            $project['users'] = $user_id;
            $location['location'] = !empty($request->location) ? ___decrypt($request->location) : '';
            $location['country'] = !empty($request->country) ? ___decrypt($request->country) : '';
            $location['state'] = $request->state;
            $location['city'] = $request->city;
            $location['geo_cordinate'] = $request->geo_cordinate;
            $project['location'] = $location;
            $project['updated_by'] = Auth::user()->id;
            $project['created_by'] = Auth::user()->id;
            $project->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/tenant/' . $tenant_id . '/project');
            $this->message = "Project Added Successfully.";
        }
        return $this->populateresponse();
    }

    public function destroy(Request $request, $tenant_id, $id)
    {
        if (!empty($request->status)) {
            if ($request->status == 'active') {
                $status = 'inactive';
            } else {
                $status = 'active';
            }
            $update = Project::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (Project::where('id', ___decrypt($id))->update($update)) {
                Project::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/tenant/' . $tenant_id . '/project');
        return $this->populateresponse();
    }

    public function bulkDelete(Request $request, $tenant_id)
    {
        $account_id_string = implode(',', $request->bulk);
        $processID = explode(',', ($account_id_string));
        foreach ($processID as $idval) {
            $processIDS[] = ___decrypt($idval);
        }
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (Project::whereIn('id', $processIDS)->update($update)) {
            Project::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('admin/tenant/' . $tenant_id . '/project');
        return $this->populateresponse();
    }

    public function edit($tenant_id, $id)
    {
        $data['countries'] = Country::all();
        $where = 1;
        $where .= ' AND tenant_id =' . ___decrypt($tenant_id);
        $tenent_users = TenantUser::list('array', $where);
        $user_data = [];
        if (!empty($tenent_users)) {
            foreach ($tenent_users as $key => $users) {
                if (!empty($users['user_details'])) {
                    $user_data[$key]['id'] = $users['user_details']['id'];
                    $user_data[$key]['first_name'] = $users['user_details']['first_name'];
                    $user_data[$key]['last_name'] = $users['user_details']['last_name'];
                    $user_data[$key]['email'] = $users['user_details']['email'];
                }
            }
        }
        $config = TenantConfig::where(['tenant_id' => ___decrypt($tenant_id)])->first();
        $data['locations'] = $config->location;
        $data['project'] = Project::where('id', ___decrypt($id))->first();
        $data['users'] = $user_data;
        $data['tenant_id'] = $tenant_id;
        return view('pages.admin.tenant.project.edit', $data);
        // return response()->json([
        //     'status' => true,
        //     'html' => view('pages.admin.tenant.project.edit', ['project' => $project,'tenant_id'=>$tenant_id,'users'=>$user_data,'countries'=>$countries])->render()
        // ]);
    }

    public function update(Request $request, $tenant_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'users' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $project =  Project::find(___decrypt($id));
            $project['name'] = $request->name;
            $project['description'] = $request->description;
            $project['tags'] = $request->tags;
            $user_id = [];
            if (!empty($request->users)) {
                foreach ($request->users as $user) {
                    $user_id[] = ___decrypt($user);
                }
            }
            $project['users'] = $user_id;
            $location['location'] = !empty($request->location) ? ___decrypt($request->location) : '';
            $location['country'] = !empty($request->country) ? ___decrypt($request->country) : '';
            $location['state'] = $request->state;
            $location['city'] = $request->city;
            $location['geo_cordinate'] = $request->geo_cordinate;
            $project['location'] = $location;
            $project['updated_by'] = Auth::user()->id;
            $project->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/tenant/' . $tenant_id . '/project');
            $this->message = "Project Updated Successfully.";
        }
        return $this->populateresponse();
    }

    public function location_fetch(Request $request, $tenant_id)
    {
        $id = ___decrypt($request->parameters);
        $config = TenantConfig::where(['tenant_id' => ___decrypt($tenant_id)])->first();
        $locations = $config->location;
        $loc = [];
        $countries = Country::all();
        if (!empty($locations)) {
            $key = 0;
            foreach ($locations as $key => $location) {
                if ($location['id'] == $id) {
                    $loc['country_id'] = $location['country_id'];
                    $loc['state'] = $location['state'];
                    $loc['city'] = $location['city'];
                    $loc['pincode'] = $location['pincode'];
                }
            }
        }
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.tenant.project.location', ['location' => $loc, 'tenant_id' => $tenant_id, 'countries' => $countries])->render()
        ]);
    }
}
