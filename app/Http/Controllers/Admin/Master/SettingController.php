<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Setting;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $data['settings'] = Setting::orderBy('id', 'desc')->first();
        return view('pages.admin.master.setting', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'logo' => 'required',
                'name' => 'required',
                'cover_image' => 'required',
            ]
        );
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $setting = new Setting;
            $data['logo'] = $request->logo;
            $data['name'] = $request->name;
            $data['cover_image'] = $request->cover_image;
            $setting->login_page = $data;
            $setting->status = 'active';
            $setting->created_at = \Auth::user()->id;
            $setting->updated_at = \Auth::user()->id;
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/settings');
            $this->message = "Added Successfully!";
        }
        return $this->populateresponse();
    }
}
