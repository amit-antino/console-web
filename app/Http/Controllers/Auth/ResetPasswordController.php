<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Models\Tenant\TenantUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ResetPasswordController extends Controller
{
    //use ResetsPasswords;

    protected $redirectTo = '/logout';

    public function createPassword(Request $request, $token)
    {
        $data['token'] = $token;
        $data['email'] = str_replace(' ', '+', $request->email);
        return view('auth.passwords.new-password', $data);
    }

    public function newPassword(Request $request, $token)
    {
        $messsages = array(
            'password.regex' => 'English uppercase characters (A – Z) English lowercase characters (a – z) Base 10 digits (0 – 9) Non-alphanumeric (For example: !, $, #, or %) Unicode characters.',
        );
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%]).*$/|confirmed',
            'password_confirmation' => 'required|same:password'
        ], $messsages);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } else {
            $user = User::where(['email' => $request->email, 'remember_token' => $token])->first();
            if (!empty($user)) {
                $id = $user->id;
                $users = User::find($id);
                $users['email_verified'] = 1;
                $users['status'] = 'active';
                $users['role'] = $user->role;
                $users['password'] = Hash::make($request->password);
                $users['remember_token'] = Str::random(60);
                $users->save();
                Auth::logout();
                Session::flash('success', 'Password created successfully');
                return Redirect('/');
            } else {
                $validator->errors()->add('email', 'this token is expired.');
                return Redirect::back()->withErrors($validator);
            }
        }
    }
}
