<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tenant\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    public function index()
    {
        $data['users'] = User::where('role', 'admin')->get();
        return view('pages.admin.admin_user.index', $data);
    }

    public function create()
    {
        return view('pages.admin.admin_user.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|Unique:users,email,NULL,id,deleted_at,NULL|email:rfc,dns',
            'mobile_number' => 'nullable|numeric|digits:10|Unique:users,mobile_number,NULL,id,deleted_at,NULL',
        ]);
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
            $users['role'] = 'admin';
            $users['created_by'] = Auth::user()->id;
            $users['updated_by'] = Auth::user()->id;
            if (!empty($request->profile_image)) {
                $image = upload_file($request, 'profile_image', 'profile_image');
                $users['profile_image'] = $image;
            }
            $users->save();
            // Sending Email to the user to set password
            $url = url('create-new-password/' . $token . '/pass?email=' . $request->email);
            try {
                Mail::send('email_templates.welcome_email', [
                    'url' => $url
                ], function ($message) use ($request) {
                    $message->to($request->email)->subject('Welcome to Simreka');
                });
                $this->status = true;
                $this->modal = true;
                $this->redirect = url('admin/admin_users');
                $this->message = "Added Successfully!";
            } catch (\Exception $e) {
                $this->status = true;
                $this->modal = true;
                $this->redirect = url('admin/admin_users/');
                $this->message = "Added Successfully! Found an issue with sending an email" . $e->getMessage();
            }
        }
        return $this->populateresponse();
    }

    public function show(Request $request, $user_id)
    {
        $user = User::find(___decrypt($user_id));
        $name = $user->first_name;
        $email = $user->email;
        $token = $user->remember_token;
        if ($request->reset_password == 'yes') {
            $title = 'Reset Password Link';
            $subject = 'Reset Password Link';
            $msg = 'Please Create your new password to active your account!';
        } else {
            $subject = 'Simreka: Your user account has been created';
            $title = 'New User Registration';
            $msg = 'Please Create your new password to active your account!';
        }
        $url = url('create-new-password/' . $token . '/pass?email=' . $user->email);
        try {
            Mail::send('email_templates.reset_password_email', ['name' => $name, 'url' => $url, 'email' => $email, 'title' => $title, 'msg' => $msg], function ($message) use ($user, $subject) {
                $message->to($user->email)->subject($subject);
            });
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

    public function edit($user_id)
    {
        $user_id = ___decrypt($user_id);
        $data['user'] = User::where('id', $user_id)->first();
        return view('pages.admin.admin_user.edit', $data);
    }

    public function update(Request $request, $user_id)
    {
        $user_id = ___decrypt($user_id);
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email'=>'required',
            // 'email' => 'required|Unique:users,email,' . ___decrypt($user_id) . ',id,deleted_at,NULL|email:rfc,dns',
            'mobile_number' => 'nullable|digits:10|Unique:users,mobile_number,' . ___decrypt($user_id) . ',id,deleted_at,NULL',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $users = User::find($user_id);
            $users['first_name'] = $request->first_name;
            $users['last_name'] = $request->last_name;
            $users['email'] = $request->email;
            $users['mobile_number'] = $request->mobile_number;
            $users['password'] = Hash::make(Str::random(10));
            $users['updated_by'] = Auth::user()->id;
            if (!empty($request->profile_image)) {
                $image = upload_file($request, 'profile_image', 'profile_image');
                $users['profile_image'] = $image;
            }
            $users->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/admin_users');
            $this->message = " Updated Successfully!";
        }
        return $this->populateresponse();
    }

    public function destroy(Request $request, $id)
    {
        if (!empty($request->status)) {
            if ($request->status == 'active') {
                $status = 'inactive';
            } else {
                $status = 'active';
            }
            $users = User::find(___decrypt($id));
            $users->status = $status;
            $users->save();
        } else {
            User::destroy(___decrypt($id));
        }
        $this->status = true;
        $this->modal = true;
        $this->redirect = true;
        return $this->populateresponse();
    }

    public function bulkDelete(Request $request)
    {
        $id_string = implode(',', $request->bulk);
        $processID = explode(',', ($id_string));
        foreach ($processID as $idval) {
            $processIDS[] = ___decrypt($idval);
        }
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (User::whereIn('id', $processIDS)->update($update)) {
            User::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }

    public function setPassword(Request $request, $user_id)
    {
        $data['user_id'] = ___decrypt($user_id);
        return view('pages.admin.admin_user.set_password', $data);
    }

    public function newPassword(Request $request, $user_id)
    {
        $messsages = array(
            'password.regex' => 'English uppercase characters (A – Z) English lowercase characters (a – z) Base 10 digits (0 – 9) Non-alphanumeric (For example: !, $, #, or %) Unicode characters.',
            'password_confirmation.same.password' => 'The password does not match.'
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
            $this->redirect = url('admin/admin_users/');
        }

        return $this->populateresponse();
    }
}
