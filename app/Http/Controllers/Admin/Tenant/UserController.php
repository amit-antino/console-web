<?php

namespace App\Http\Controllers\Admin\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Tenant\Tenant;
use App\Models\Tenant\TenantConfig;
use App\Models\Tenant\TenantUser;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index($id)
    {
        $data['tenant'] = Tenant::where('id', ___decrypt($id))->first();
        $tenent_users = TenantUser::where('tenant_id', ___decrypt($id))->get();
        $userIds = array_column($tenent_users->toArray(), 'user_id');
        $users = User::whereIn('id', $userIds)->get();
        $data['users'] = $users;
        return view('pages.admin.tenant.user.index', $data);
    }

    public function create(Request $request, $tenant_id)
    {
        $data['tenant'] = Tenant::where('id', ___decrypt($tenant_id))->first();
        $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
        $designation = [];
        if (!empty($tenant->designation)) {
            foreach ($tenant->designation as $key => $desig) {
                if ($desig['status'] == 'active') {
                    $designation[$key]['id'] = $desig['id'];
                    $designation[$key]['name'] = $desig['name'];
                }
            }
        }
        $data['designation'] = $designation;
        return view('pages.admin.tenant.user.create', $data);
    }

    public function store(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|Unique:users,email,NULL,id,deleted_at,NULL|email:rfc,dns',
            'mobile_number' => 'nullable|numeric|digits:10|Unique:users,mobile_number,NULL,id,deleted_at,NULL',
            'users_type' => 'required',
        ]);
        $tenant_user_count = TenantUser::where('tenant_id', ___decrypt($id))->count();
        $tenant_user = TenantConfig::where('tenant_id', ___decrypt($id))->first();
        if (!empty($tenant_user)) {
            if ($tenant_user_count >= $tenant_user['number_of_users']) {
                $validator->errors()->add('first_name', 'Can not add more than ' . $tenant_user['number_of_users'] . ' user');
                $this->message = $validator->errors();
                return $this->populateresponse();
            }
        }
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $users = new User();
            $users['first_name'] = $request->first_name;
            $users['last_name'] = $request->last_name;
            $users['email'] = $request->email;
            $users['mobile_number'] = $request->mobile_number;
            $users['password'] = Hash::make(Str::random(10));
            $token = $users['remember_token'] = Str::random(60);
            $users['role'] = $request->users_type;
            $users['created_by'] = Auth::user()->id;
            $users['updated_by'] = Auth::user()->id;
            if (!empty($request->profile_image)) {
                $image = upload_file($request, 'profile_image', 'profile_image');
                $users['profile_image'] = $image;
            }
            $users->save();
            $user_id = $users->id;
            $users_tenant = new TenantUser();
            $users_tenant['tenant_id'] = ___decrypt($id);
            $users_tenant['user_id'] = $user_id;
            $users_tenant['designation_id'] =  !empty($request->designation) ? ___decrypt($request->designation) : 0;
            $users_tenant->save();
            $config = TenantConfig::where('tenant_id', ___decrypt($id))->first();
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
            $up_data['user_settings'] = array_merge($config->user_settings, $user_settings);
            TenantConfig::where('tenant_id', ___decrypt($id))->update($up_data);
            // Sending Email to the user to set password
            $url = url('create-new-password/' . $token . '/pass?email=' . $request->email);
            try {
                // Mail::send('email_templates.welcome_email', [
                //     'url' => $url
                // ], function ($message) use ($request) {
                //     $message->to($request->email)->subject('Welcome to Simreka');
                // });
                $this->status = true;
                $this->modal = true;
                $this->redirect = url('admin/tenant/' . $id . '/user');
                $this->message = "Added Successfully!";
                return $this->populateresponse();
            } catch (\Exception $e) {
                $this->status = true;
                $this->modal = true;
                $this->redirect = url('admin/tenant/' . $id . '/user');
                $this->message = "Added Successfully! Found an issue with sending an email" . $e->getMessage();
                return $this->populateresponse();
            }
        }
        return $this->populateresponse();
    }

    public function show(Request $request, $tenant_id, $user_id)
    {
        $user = User::find(___decrypt($user_id));
        $name = $user->first_name;
        $email = $user->email;
        $token = $user->remember_token;
        $url = url('create-new-password/' . $token . '/pass?email=' . $user->email);
        if ($request->reset_password == 'yes') {
            $title = 'Reset Password Link';
            $subject = 'Reset Password Link';
            $msg = 'Please Create your new password to active your account!';
            // $url = url('create-new-password/' . $token . '/pass?email=' . $user->email);
            Mail::send('email_templates.reset_password_email', [
                'url' => $url
            ], function ($message) use ($user) {
                $message->to($user->email)->subject('Reset Password Link');
            });
        } else {
            $subject = 'Congrats! User Created Sucess';
            $title = 'New User Registration';
            $msg = 'Please Create your new password to active your account!';
            Mail::send('email_templates.welcome_email', [
                'url' => $url
            ], function ($message) use ($user) {
                $message->to($user->email)->subject('Welcome to Simreka');
            });
        }

        try {

            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "Mail Sent Successfull !";
        } catch (\Exception $e) {
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message =  $e->getMessage();
        }
        return $this->populateresponse();
    }

    public function edit($tenant_id, $user_id)
    {
        $data['tenant'] = Tenant::where('id', ___decrypt($tenant_id))->first();
        $data['user'] = User::where('id', ___decrypt($user_id))->first();
        $data['tenant_user'] = TenantUser::where(['tenant_id' => ___decrypt($tenant_id), 'user_id' => ___decrypt($user_id)])->first();
        $tenant = TenantConfig::where('tenant_id', ___decrypt($tenant_id))->first();
        $designation = [];
        if (!empty($tenant->designation)) {
            foreach ($tenant->designation as $key => $desig) {
                if ($desig['status'] == 'active') {
                    $designation[$key]['id'] = $desig['id'];
                    $designation[$key]['name'] = $desig['name'];
                }
            }
        }
        $data['designation'] = $designation;
        return view('pages.admin.tenant.user.edit', $data);
    }

    public function update(Request $request, $tanent_id, $user_id)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|Unique:users,email,' . ___decrypt($user_id) . ',id,deleted_at,NULL|email:rfc,dns',
            'mobile_number' => 'nullable|digits:10|Unique:users,mobile_number,' . ___decrypt($user_id) . ',id,deleted_at,NULL',
            'users_type' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $users = User::find(___decrypt($user_id));
            $users['first_name'] = $request->first_name;
            $users['last_name'] = $request->last_name;
            $users['email'] = $request->email;
            $users['mobile_number'] = $request->mobile_number;
            $users['password'] = Hash::make(Str::random(10));
            $users['updated_by'] = Auth::user()->id;
            $users['role'] = $request->users_type;
            if (!empty($request->profile_image)) {
                $image = upload_file($request, 'profile_image', 'profile_image');
                $users['profile_image'] = $image;
            }
            $users->save();
            $updata_data['designation_id'] = !empty($request->designation) ? ___decrypt($request->designation) : 0;
            TenantUser::where(['user_id' => ___decrypt($user_id), 'tenant_id' => ___decrypt($tanent_id)])->update($updata_data);
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/tenant/' . $tanent_id . '/user');
            $this->message = " Updated Successfully!";
        }
        return $this->populateresponse();
    }

    public function destroy(Request $request, $tid, $id)
    {
        if (!empty($request->status)) {
            if ($request->status == 'active') {
                $status = 'inactive';
            } else {
                $status = 'active';
            }
            $tenant = User::find(___decrypt($id));
            $tenant->status = $status;
            $tenant->save();
            $this->status = true;
            $this->redirect = true;
            return $this->populateresponse();
        }
        $tenent_users = TenantUser::where(['tenant_id' => ___decrypt($tid), 'user_id' => ___decrypt($id)])->first();
        if (TenantUser::destroy($tenent_users->id)) {
            User::destroy(___decrypt($id));
        }
        $this->status = true;
        $this->modal = true;
        $this->redirect = url('admin/tenant/' . $tid . '/user');
        $this->message = "Delete Successfully!";
        return $this->populateresponse();
    }

    public function bulkDelete(Request $request, $id)
    {
        $account_id_string = implode(',', $request->bulk);
        $processID = explode(',', ($account_id_string));
        foreach ($processID as $idval) {
            $processIDS[] = ___decrypt($idval);
        }
        User::destroy($processIDS);
        $this->status = true;
        $this->redirect = url('admin/tenant/' . $id . '/user');
        return $this->populateresponse();
    }
    public function setPassword(Request $request, $tenant_id, $user_id)
    {
        $data['user_id'] = ___decrypt($user_id);
        $data['tenant'] = Tenant::where('id', ___decrypt($tenant_id))->first();
        return view('pages.admin.tenant.user.set_password', $data);
    }
    public function newPassword(Request $request, $tenant_id, $user_id)
    {
        $messsages = array(
            'password.regex' => 'English uppercase characters (A – Z) English lowercase characters (a – z) Base 10 digits (0 – 9) Non-alphanumeric (For example: !, $, #, or %) Unicode characters.',
            'password_confirmation.same'=>'The password does not match.'

        );
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|confirmed',
            'password_confirmation' => 'required|same:password'
        ], $messsages);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $users = User::find(___decrypt($user_id));
            $users['password'] = Hash::make($request->password);
            $users['remember_token'] = Str::random(60);
            $users->save();
            $this->message = 'Password changed successfully';
            $this->status = true;
            $this->redirect = url('admin/tenant/' . $tenant_id . '/user');
        }

        return $this->populateresponse();
    }
}
