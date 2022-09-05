<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\TimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index(Request $request, $value = '')
    {
        $data['profile'] = '';
        $preference = !empty($request->update) ? $request->update : '';
        $user_info = User::find(Auth::user()->id);
        $timezones = TimeZone::get();
        $countries = Country::get();
        return view('pages.admin.user.profile', $data,compact('user_info', 'countries', 'timezones', 'preference'));
    }

    public function store(Request $request)
    {
        if ($request->role == 'basic_info') {
            $validator = Validator::make($request->all(), [
                'first_name' => 'required',
                'last_name' => 'required',
                //'mobile_number'=>'nullable|numeric|digits:10'
            ]);
        } elseif ($request->role == 'secuirity') {
            if (!empty($request->old_password) || !empty($request->password) || !empty($request->confirm_password)) {
                $validator = Validator::make($request->all(), [
                    'old_password' => 'required',
                    'password' => 'required',
                    'confirm_password' => 'required|same:password',
                ]);
            } else {
                $validator = Validator::make($request->all(), []);
            }
        } elseif ($request->role == 'preference') {
            $validator = Validator::make($request->all(), [
                'language' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'mobile_number' => 'nullable|numeric|digits:10|Unique:users,mobile_number,' . Auth::user()->id,
            ]);
        }
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $users = User::find(Auth::user()->id);
            if ($request->role == 'basic_info') {
                $users['first_name'] = $request->first_name;
                $users['last_name'] = $request->last_name;
                $users['mobile_number'] = $request->mobile_number;
                if (!empty($request->profile_image)) {
                    $image = upload_file($request, 'profile_image', 'profile_image');
                    $users['profile_image'] = $image;
                }
            } elseif ($request->role == 'secuirity') {
                if (!empty($request->old_password) || !empty($request->password) || !empty($request->confirm_password)) {
                    if (Hash::check($request->old_password, Auth::user()->password)) {
                        $users['password'] = Hash::make($request->password);
                    } else {
                        $validator->errors()->add('old_password', 'Password does not match.');
                        $this->message = $validator->errors();
                        return $this->populateresponse();
                    }
                }
                $users['two_factor_auth'] = !empty($request->is_two_factor_enable) ? 'true' : 'false';
            } elseif ($request->role == 'preference') {
                $set_data['language'] = $request->language;
                $set_data['timezone'] = !empty($request->time_zone) ? ___decrypt($request->time_zone) : 0;
                $set_data['currency_type'] = !empty($request->currency_type) ? ___decrypt($request->currency_type) : 0;
                $set_data['date_format'] = $request->date_format;
                $users['settings'] = $set_data;
            } elseif ($request->role == 'settings') {
                $users['two_factor_auth'] = !empty($request->is_two_factor_enable) ? 'true' : 'false';
                // = $user_settings;
            } else {
                $set_data['language'] = $request->language;
                $set_data['timezone'] = !empty($request->time_zone) ? ___decrypt($request->time_zone) : 0;
                $set_data['currency_type'] = !empty($request->currency_type) ? ___decrypt($request->currency_type) : 0;
                $set_data['date_format'] = $request->date_format;
                $users['settings'] = $set_data;
               // $users['mobile_number'] = $request->mobile_number;
            }
            $users['remember_token'] = Str::random(60);
            $users['updated_by'] = Auth::user()->id;
            $users->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/user/profile');
            $this->message = " Profile Updated Successfully!";
        }
        return $this->populateresponse();
    }

    public function destroy(Request $request)
    {
        $users = User::find(Auth::user()->id);
        $users->profile_image = '';
        $users->save();
        $this->status = true;
        $this->modal = true;
        $this->redirect = url('admin/user/profile');
        $this->message = " Profile Updated Successfully!";
        return $this->populateresponse();
    }
}
