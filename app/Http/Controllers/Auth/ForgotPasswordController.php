<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return response()->json([
            'status' => true,
            'html' => view("auth.passwords.email")->render()
        ]);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } else {
            $user = User::where(['email' => $request->email])->first();
            if (!empty($user)) {
                $users = User::find($user->id);
                $token = $users['remember_token'] = Str::random(60);
                $users->save();
                $name = $user->first_name . ' ' . $user->last_name;
                $email = $user->email;
                $title = 'Forgot Password';
                $url = url('create-new-password/' . $token . '/pass?email=' . $user->email);
                Mail::send('email_templates.reset_password_email', ['name' => $name, 'url' => $url, 'email' => $email, 'title' => $title], function ($message) use ($user) {
                    $message->to($user->email)->subject('Forgot Password request');
                });
                Session::flash('success', 'Forgot Password Reset Email sent successfully');
                return Redirect::back();
            } else {
                $validator->errors()->add('email', 'no record match with this email.');
                return Redirect::back()->withErrors($validator);
            }
        }
    }
}
