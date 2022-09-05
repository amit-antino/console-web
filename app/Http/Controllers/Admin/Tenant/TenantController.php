<?php

namespace App\Http\Controllers\Admin\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Master\TenantMasterPlan;
use App\Models\Master\TenantMasterType;
use Illuminate\Http\Request;
use App\Models\Tenant\Tenant;
use Illuminate\Support\Facades\Validator;
use App\Models\Country;
use App\Models\Organization\Users\UserPermission;
use App\Models\Tenant\Project;
use App\Models\Tenant\TenantConfig;
use App\Models\Tenant\TenantUser;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TenantController extends Controller
{
    public function index()
    {
        $data['tenants'] = Tenant::Select('*')
            ->with([
                'organization_type_details' => function ($q) {
                    $q->select('*');
                },
                'plan_details' => function ($q) {
                    $q->select('*');
                }, 'location' => function ($q) {
                    $q->select('*');
                }, 'tenant_config' => function ($q) {
                    $q->select('*');
                }
            ])
            ->orderBy('id', 'desc')->get();
        return view('pages.admin.tenant.index', $data);
    }

    public function create()
    {
        $plans = TenantMasterPlan::where(['status' => 'active'])->get();
        $types = TenantMasterType::where(['status' => 'active'])->get();
        $country = Country::get();
        return view('pages.admin.tenant.create', compact('plans', 'types', 'country'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'organization_name' => 'required|Unique:tenants,name',
            'organization_type' => 'required',
            'plan_id' => 'required',
            'account_name' => 'required',
            'billing_email' => 'required|Unique:users,email|email:rfc,dns',
            // 'billing_phone_no' => 'required',
            // 'tax_id' => 'required',
            // 'billing_start_from' => 'required',
            // 'billing_address' => 'required',
            // 'country_id' => 'required',
            // 'state' => 'required',
            // 'city' => 'required',I
            // 'pincode' => 'required',
            'no_users' => 'required|min:1',
            'pincode' => 'nullable|numeric|digits:6'
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $tenant = new Tenant();
            $tenant->name = $request->organization_name;
            $tenant->type = $request->organization_type;
            $tenant->plan_type = $request->plan_id;
            $image = '';
            if (!empty($request->organization_logo)) {
                $image = upload_file($request, 'organization_logo', 'organization_logo');
            }
            $account = [
                'account_name' => $request->account_name,
                'billing_email' => $request->billing_email,
                'billing_phone_no' => $request->billing_phone_no,
                'billing_start_from' => $request->billing_start_from,
                'country_id' => $request->country_id, //!empty($request->country_id) ? ___decrypt($request->country_id) : 0,
                'organization_logo' => $image,
            ];
            $billing_information = [
                'tax_id' => $request->tax_id,
                'address' => $request->billing_address,
                'pincode' => $request->pincode,
                'city' => $request->city,
                'state' => $request->state,
                'country_id' => $request->country_id //!empty($request->country_id) ? ___decrypt($request->country_id) : 0,
            ];
            $tenant->billing_information = $billing_information;
            $tenant->account_details = $account;
            $tenant->description = $request->description;
            $tenant->note = $request->note;
            $tenant->status = 'active';
            $tenant->updated_by = Auth::user()->id;
            $tenant->created_by = Auth::user()->id;
            $tenant->save();

            ///USer add
            $users = new User();
            $account_name = split_name($request->account_name);
            $users['first_name'] = $account_name[0];
            $users['last_name'] = $account_name[1];
            $users['email'] = $request->billing_email;
            $users['mobile_number'] = $request->billing_phone_no;
            $users['password'] = Hash::make(Str::random(10));
            $token = $users['remember_token'] = Str::random(60);
            $users['role'] = 'console_admin';
            $users['created_by'] = Auth::user()->id;
            $users['updated_by'] = Auth::user()->id;
            if (!empty($request->profile_image)) {
                $image = upload_file($request, 'profile_image', 'profile_image');
                $users['profile_image'] = $image;
            }
            $users->save();
            ////Tenant User 
            $tenant_users = new TenantUser();
            $tenant_users->user_id = $users->id;
            $tenant_users->tenant_id = $tenant->id;
            $tenant_users->save();
            ///TENANT CONFIG
            $tenant_config = new TenantConfig();
            $tenant_config->tenant_id = $tenant->id;
            $tenant_config->number_of_users = $request->no_users;
            $menu_group = [];
            $user_group = [];
            $designation = [];
            $user_permission = [];
            $location = [];
            $user_settings[] = [
                'id' => $users->id,
                'user_id' => $users->id,
                'lang' => '',
                'currency' => '',
                'timezome' => '',
                'dateformat' => '',
                'profile_img' => '',
                'email_notification' => '',
            ];

            $menu_group['id'] = 1;
            $menu_group['name'] = 'Basic';
            $menu_group['menu_list'] = ["1"];
            $menu_group['description'] = $request->description;
            $menu_group['status'] = 'active';

            $tenant_config->menu_group = $menu_group;
            $tenant_config->location = $location;
            $tenant_config->user_group = $user_group;
            $tenant_config->designation = $designation;
            $tenant_config->user_permission = $user_permission;
            $tenant_config->user_settings = $user_settings;
            $tenant_config->updated_by = Auth::user()->id;
            $tenant_config->created_by = Auth::user()->id;
            $tenant_config->save();

            // $url = url('create-new-password/' . $token . '/pass?email=' . $request->billing_email);
            try {
                // Mail::send('email_templates.welcome_email', [
                //     'url' => $url
                // ], function ($message) use ($request) {
                //     $message->to($request->billing_email)->subject('Welcome to Simreka');
                // });
                $this->status = true;
                $this->modal = true;
                $this->redirect = url('admin/tenant/');
                $this->message = "Added Successfully!";
            } catch (\Exception $e) {
                $this->status = true;
                $this->modal = true;
                $this->redirect = url('admin/tenant/');
                $this->message = "Added Successfully! Found an issue with sending an email" . $e->getMessage();
            }
        }
        return $this->populateresponse();
    }

    public function show($id)
    {
        $id = ___decrypt($id);
        $data['tenant'] = Tenant::with([
            'organization_type_details' => function ($q) {
                $q->select('*');
            },
            'plan_details' => function ($q) {
                $q->select('*');
            }, 'tenant_config' => function ($q) {
                $q->select('*');
            }
        ])->where('id', $id)->first();
        return view('pages.admin.tenant.view', $data);
    }

    public function edit($id)
    {
        $id = ___decrypt($id);
        $data['plans'] = TenantMasterPlan::get();
        $data['types'] = TenantMasterType::get();
        $data['country'] = Country::get();
        $data['tenant'] = Tenant::with('tenant_config')->where('id', $id)->first();
        return view('pages.admin.tenant.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $id = ___decrypt($id);
        $validator = Validator::make($request->all(), [
            'organization_name' => 'required|Unique:tenants,name,' . $id,
            'organization_type' => 'required',
            'plan_id' => 'required',
            //'billing_email' => 'required|email',
            // 'billing_phone_no' => 'required',
            // 'tax_id' => 'required',
            // 'billing_start_from' => 'required',
            // 'billing_address' => 'required',
            // 'country_id' => 'required',
            // 'state' => 'required',
            // 'city' => 'required',
            // 'pincode' => 'required',
            'no_users' => 'required|numeric|min:1',
            'pincode' => 'nullable|numeric|digits:6'
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $tenant = Tenant::find($id);
            $tenant->name = $request->organization_name;
            $tenant->type = !empty($request->organization_type) ? ___decrypt($request->organization_type) : 0;
            $tenant->plan_type = !empty($request->plan_id) ? ___decrypt($request->plan_id) : 0;
            $image = '';
            if (!empty($request->organization_logo)) {
                $image = upload_file($request, 'organization_logo', 'organization_logo');
            }
            $account = [
                'account_name' => $request->account_name,
                'billing_email' => $request->billing_email,
                'billing_phone_no' => $request->billing_phone_no,
                'billing_start_from' => $request->billing_start_from,
                'country_id' => $request->country_id,
                'organization_logo' => $image,
            ];
            $billing_information = [
                'tax_id' => $request->tax_id,
                'address' => $request->billing_address,
                'pincode' => $request->pincode,
                'city' => $request->city,
                'state' => $request->city,
                'country_id' => $request->country_id,
            ];
            $tenant->billing_information = $billing_information;
            $tenant->account_details = $account;
            $tenant->description = $request->description;
            $tenant->note = $request->note;
            $tenant->updated_by = Auth::user()->id;
            $tenant->save();

            ///TENANT CONFIG
            $tenant_config = TenantConfig::find(___decrypt($request->tenant_variation_id));
            $tenant_config->number_of_users = $request->no_users;
            $tenant_config->updated_by = Auth::user()->id;
            $tenant_config->save();

            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/tenant/');
            $this->message = "Updated Successfully!";
        }
        return $this->populateresponse();
    }

    public function destroy(Request $request, $id)
    {
        if (!empty($request->remove) && $request->remove == 'logo') {
            $update_data =  Tenant::find(___decrypt($id));
            $account = [];
            if (!empty($update_data->account_details)) {
                $account = [
                    'account_name' => $update_data->account_details['account_name'],
                    'billing_email' => $update_data->account_details['billing_email'],
                    'billing_phone_no' => $update_data->account_details['billing_phone_no'],
                    'billing_start_from' => $update_data->account_details['billing_start_from'],
                    'country_id' => $update_data->account_details['country_id'],
                    'organization_logo' => ''
                ];
            }
            $update_data->account_details = $account;
            $update_data->save();
            $this->status = true;
            $this->redirect = true;
            return $this->populateresponse();
        }
        if (!empty($request->status)) {
            if ($request->status == 'active') {
                $status = 'inactive';
            } else {
                $status = 'active';
            }
            $tenant = Tenant::find(___decrypt($id));
            $tenant->status = $status;
            $tenant->save();
            $this->status = true;
            $this->redirect = true;
            return $this->populateresponse();
        }
        if (!empty($request->two_factor)) {
            if ($request->two_factor == 'false') {
                $status = 'true';
            } else {
                $status = 'false';
            }
            $tenant_data['two_factor_auth'] = $status;
            $tenan_config = TenantConfig::where('id', ___decrypt($id))->update($tenant_data);
            $this->status = true;
            $this->redirect = true;
            return $this->populateresponse();
        }
        if (!empty($request->ldap_auth)) {
            if ($request->ldap_auth == 'on') {
                $status = 'off';
            } else {
                $status = 'on';
            }
            $tenant = Tenant::find(___decrypt($id));
            $tenant->ldap_auth = $status;
            $tenant->save();
            $this->status = true;
            $this->redirect = true;
            return $this->populateresponse();
        }

        Tenant::destroy(___decrypt($id));
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }

    public function manage($id)
    {
        $data['tenant'] = Tenant::find(___decrypt($id));
        $config = TenantConfig::find(___decrypt($id));
        $data['locations_count'] = count(!empty($config->location) ? $config->location : []);
        $tenent_users =  TenantUser::where('tenant_id', ___decrypt($id))->get();

        $userIds = array_column($tenent_users->toArray(), 'user_id');
        $user_count = User::whereIn('id', $userIds)->count();

        $data['users_count'] = $user_count;
        $data['menu_count'] = 1;
        $data['user_group_count'] = count(!empty($config->user_group) ? $config->user_group : []);
        $data['designation_count'] = count(!empty($config->designation) ? $config->designation : []);
        $data['project_cnt'] = Project::where(['tenant_id' => ___decrypt($id)])->count();
        $user_permission_count = UserPermission::where('tenant_id', ___decrypt($id))->count();
        $user_permission_last_update = UserPermission::where('tenant_id', ___decrypt($id))->latest()->first();
        if ($user_permission_count) {
            $data['user_permission_count'] = $user_permission_count;
        } else {
            $data['user_permission_count'] = 0;
        }
        return view('pages.admin.tenant.manage', compact('data'));
    }

    public function databaseConfig($id)
    {
        $tenant = Tenant::where('id', ___decrypt($id))->first();
        return view('pages.admin.tenant.database-config', compact('tenant'));
    }

    public function bulkDelete(Request $request)
    {
        $account_id_string = implode(',', $request->bulk);
        $processID = explode(',', ($account_id_string));
        foreach ($processID as $idval) {
            $processIDS[] = ___decrypt($idval);
        }
        Tenant::destroy($processIDS);
        $this->status = true;
        $this->redirect = url('admin/tenant');
        return $this->populateresponse();
    }

    public function removeLogo($tenant_id)
    {
        $config = TenantConfig::select('id', 'tenant_id', 'account_details')->where('tenant_id', ___decrypt($tenant_id))->first();
        $update_data =  TenantConfig::find($config->id);

        if (!empty($update_data->account_details)) {
            foreach ($update_data->account_details as $key => $accounts) {
                dd($accounts);
                //         $account = [
                //     'account_name' => $request->account_name,
                //     'billing_email' => $request->billing_email,
                //     'billing_phone_no' => $request->billing_phone_no,
                //     'billing_start_from' => $request->billing_start_from,
                //     'country_id' => !empty($request->country_id) ? ___decrypt($request->country_id) : 0,
                //     'organization_logo' => $image
                // ];
            }
        }
        // $update_data->account_details=$account;
        $update_data->save();
    }
}
