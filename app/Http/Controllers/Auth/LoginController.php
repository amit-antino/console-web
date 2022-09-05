<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\UserEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Tenant\TenantUser;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function ldap_login(Request $request)
    {
        $connection = new \LdapRecord\Connection([]);
        try {
            $connection->connect();
        } catch (\LdapRecord\Auth\BindException $e) {
            $error = $e->getDetailedError();
            echo $error->getErrorCode();
            echo $error->getErrorMessage();
            echo $error->getDiagnosticMessage();
        }
        try {
            $new_user = $connection->query()->where('samaccountname', '=', $request->username)->firstOrFail();
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }
        $email = '';
        if (!empty($new_user)) {
            foreach ($new_user['mail'] as $mail) {
                $email = $mail;
                break;
            }
        }
        $password = $request->password;
        try {
            if (!empty($new_user)) {
                $username_uid_dn =  !empty($new_user['dn']) ? $new_user['dn'] : '';
                if ($connection->auth()->attempt($username_uid_dn, $password)) {

                    return !empty($new_user['mail'][0]) ? $new_user['mail'][0] : '';
                } else {
                    return 'wrong_password';
                }
            } else {
                return 'no_user_email_data';
            }
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }
    }
    public function showLoginForm(Request $request)
    {
        if ($request->path() != 'logout') {
            $data['redirect_url'] =  !empty(url()->previous()) ? url()->previous() : url('/dashboard');
        } else {
            $data['redirect_url'] = url('/organization/profile');
        }
        return view('auth.login', $data);
    }

    public function login(Request $request)
    {
        //$subdomain = $request->getHttpHost();
        // if (!empty($subdomain)) {
        //     $tenant = Tenant::where('sub_domain', $subdomain)->first();
        //     if (!empty(_arefy($tenant))) {
        //         tenantDBConnection('tenant', $tenant->id);
        //     }
        // }
        if ($request->login_method == 'ldap') {
            $validator = Validator::make($request->all(), [
                'username' => 'required',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            } else {
                $user = $this->ldap_login($request);
                if ($user == 'wrong_password') {
                    $validator->errors()->add('username', 'Username or password incorrect.');
                    return Redirect::back()->withErrors($validator);
                } elseif ($user == 'no_user_email_data') {
                    $validator->errors()->add('username', 'No any record found in LDAP.');
                    return Redirect::back()->withErrors($validator);
                }
                if (!empty($user)) {
                    $data = User::where('email', $user)->first();
                    if (!empty($data)) {
                        Auth::loginUsingId($data->id);

                        if (!empty(Auth::user()->currency_type) && !empty(Auth::user()->timezone) && !empty(Auth::user()->date_format) && !empty(Auth::user()->language)) {
                            return redirect($request->redirect_url);
                        } else {
                            return redirect('/organization/profile?update=preference');
                        }
                    } else {
                        $validator->errors()->add('username', 'This user is not register with simreka.');
                        return Redirect::back()->withErrors($validator);
                    }
                }
            }
        } else {
            $validator = Validator::make($request->all(), [
                'username' => 'required|email',
                'password' => 'required',
            ]);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            } else {
                if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
                    if (Auth::user()->status != 'active') {
                        Auth::logout();
                        $validator->errors()->add('username', 'user must be active for login.');
                        return Redirect::back()->withErrors($validator);
                    }
                    if (Auth::user()->email_verified != 1) {
                        Auth::logout();
                        $validator->errors()->add('username', 'please verify your email.');
                        return Redirect::back()->withErrors($validator);
                    }
                    if (two_factor_is_enable()) {
                        $users = User::find(Auth::user()->id);
                        $rem_token = Str::random(60);
                        $users['remember_token'] = $rem_token;
                        $users->save();
                        $user = Auth::user();
                        $name = $user->first_name . ' ' . $user->last_name;
                        $email = $user->email;
                        $title = 'Two Factor Authentication OTP';
                        $otp = rand(100000, 10000000);
                        $otp_data['user_id'] = ___encrypt(Auth::user()->id);
                        $otp_data['otp'] = ___encrypt($otp);
                        $request->session()->put('otp_data', $otp_data);
                        Auth::logout();
                        $new_data = User::find(___decrypt($otp_data['user_id']));
                        $url = url('authenticate/two_factor_auth/' . $new_data['remember_token'] . '/otp_verify?email=' . $user->email);
                        // $email_data['url']=$url;
                        // $email_data['name']=$name;
                        // $email_data['email']=$email;
                        // $email_data['title']=$title;
                        // $email_data['otp']=$otp;
                        // $email_data['user']=$user;
                        //dispatch(new UserEmail($email_data));
                        Mail::send('email_templates.two_factor_otp', ['name' => $name, 'url' => $url, 'email' => $email, 'title' => $title, 'otp' => $otp], function ($message) use ($user) {
                            $message->to($user->email)->subject('Two Factor Authentication OTP');
                        });
                        Session::flash('success', 'Two Factor Authentication OTP Sent Successfully Please Check Your Email');
                        return redirect('authenticate/two_factor_auth/' . $new_data['remember_token'] . '/otp_verify?email=' . $email . '&redirect_url=' . $request->redirect_url);
                    }
                    if (!empty(Auth::user()->currency_type) && !empty(Auth::user()->timezone) && !empty(Auth::user()->date_format) && !empty(Auth::user()->language)) {
                        return redirect($request->redirect_url);
                    } else {
                        return redirect('/organization/profile?update=preference');
                    }
                } else {
                    $validator->errors()->add('password', 'Wrong email OR password.');
                    return Redirect::back()->withErrors($validator);
                }
            }
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect('/');
    }

    public function user_authenticate(Request $request)
    {
        try {
            $tenant = TenantUser::where(['user_id' => $request->user_id, 'tenant_id' => $request->tenant_id])->first();
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
        if (!empty($tenant)) {
            $response = [
                'data' => true,
                'status_code' => 200,
                'status' => true,
                'message' => "User successfully authenticated"
            ];
        } else {
            $response = [
                'data' => false,
                'status_code' => 500,
                'status' => false,
                'message' => $message
            ];
        }
        return response()->json($response);
    }

    public function two_factor(Request $request, $rem_token)
    {
        $user = User::where('remember_token', $rem_token)->first();
        $data['email'] = $user->email;
        $data['redirect_url'] = $request->redirect_url;
        $data['rem_token'] = $rem_token;
        return view('auth.two_factor', $data);
    }

    public function two_factor_auth(Request $request, $rem_token)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required',
        ]);
        $session = Session('otp_data');
        if (empty($session)) {
            $validator->errors()->add('otp', 'Token Expired!');
            return Redirect::back()->withErrors($validator);
        }
        $otp = ___decrypt($session['otp']);

        $user_id = ___decrypt($session['user_id']);
        if (!empty($otp)) {
            if (intval($request->otp) != $otp) {
                $validator->errors()->add('otp', 'OTP not Matched! Please enter correct OTP');
                return Redirect::back()->withErrors($validator);
            }
        }
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        } else {
            $user = User::where('email', $request->email)->first();
            //Now log in the user if exists
            if (!empty($user)) {
                Auth::loginUsingId($user->id);
                if (Auth::user()->status != 'active') {
                    Auth::logout();
                    $validator->errors()->add('otp', 'user must be active for login.');
                    return Redirect::back()->withErrors($validator);
                }
                if (Auth::user()->email_verified != 1) {
                    Auth::logout();
                    $validator->errors()->add('email', 'please verify your email.');
                    return Redirect::back()->withErrors($validator);
                }
                Session::forget('otp_data');
                if (!empty(Auth::user()->currency_type) && !empty(Auth::user()->timezone) && !empty(Auth::user()->date_format) && !empty(Auth::user()->language)) {
                    return redirect($request->redirect_url);
                } else {
                    return redirect('/organization/profile?update=preference');
                }
            } else {
                $validator->errors()->add('otp', 'OTP Miss Matched!');
                return Redirect::back()->withErrors($validator);
            }
        }
    }

    public function resend_otp(Request $request)
    {
        $users = User::where('remember_token', $request->token)->first();
        $name = $users['first_name'] . ' ' . $users['last_name'];
        $email = $users->email;
        $title = 'Two Factor Authentication OTP';
        $otp = rand(100000, 10000000);
        $otp_data['user_id'] = ___encrypt($users->id);
        $otp_data['otp'] = ___encrypt($otp);
        $request->session()->put('otp_data', $otp_data);
        $new_data = User::find(___decrypt($otp_data['user_id']));
        $url = url('authenticate/two_factor_auth/' . $new_data['remember_token'] . '/otp_verify?email=' . $users->email);
        Mail::send('email_templates.two_factor_otp', ['name' => $name, 'url' => $url, 'email' => $email, 'title' => $title, 'otp' => $otp], function ($message) use ($users) {
            $message->to($users->email)->subject('Two Factor Authentication OTP');
        });
        //Session::flash('success', 'Two Factor Authentication OTP Sent Successfully Please Check Your Email');
        //return redirect('authenticate/two_factor_auth/' . $new_data['remember_token'] . '/otp_verify?email=' . $email . '&redirect_url=' . $request->redirect_url);
        $response = [
            'success' => true,
            'status_code' => 200,
            'status' => true,
            'message' => "Two Factor Authentication OTP Sent Successfully Please Check Your Email"
        ];
        return response()->json($response);
    }
}
