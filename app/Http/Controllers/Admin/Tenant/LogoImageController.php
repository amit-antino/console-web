<?php

namespace App\Http\Controllers\Admin\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tenant\Tenant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LogoImageController extends Controller
{
    public function show($id)
    {
        $data['tenant'] = Tenant::where('id', ___decrypt($id))->first();
        $data['banner_img'] = !empty($data['tenant']->images['banner_img']) ? $data['tenant']->images['banner_img'] : '';
        $data['main_logo'] = !empty($data['tenant']->images['main_logo']) ? $data['tenant']->images['main_logo'] : '';
        $data['auth_logo'] = !empty($data['tenant']->images['auth_logo']) ? $data['tenant']->images['auth_logo'] : '';
        return view('pages.admin.tenant.logo.edit', $data);
    }

    public function edit($id)
    {
        $data['tenant'] = Tenant::where('id', ___decrypt($id))->first();
        return view('pages.admin.tenant.logo.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            // 'main_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // 'banner_img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // 'auth_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'main_logo' => 'image|mimes:jpg,png,jpeg,gif|max:1024',
            'banner_image' => ['image', 'mimes:jpg,png,jpeg,gif', 'max:1024'],
            'auth_logo' => ['image', 'mimes:jpg,png,jpeg,gif', 'max:1024'],
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $id = ___decrypt($id);
            $tenant = Tenant::find($id);
            $banner_img = !empty($tenant->images['banner_img']) ? $tenant->images['banner_img'] : '';
            $main_logo = !empty($tenant->images['main_logo']) ? $tenant->images['main_logo'] : '';
            $auth_logo = !empty($tenant->images['auth_logo']) ? $tenant->images['auth_logo'] : '';
            if (!empty($request->main_logo)) {
                $main_logo = upload_file($request, 'main_logo', 'main_logo');
            }
            if (!empty($request->banner_image)) {
                $banner_img = upload_file($request, 'banner_image', 'banner_img');
            }
            if (!empty($request->auth_logo)) {
                $auth_logo = upload_file($request, 'auth_logo', 'auth_logo');
            }
            $images = [
                'main_logo' => $main_logo,
                'banner_img' => $banner_img,
                'auth_logo' => $auth_logo,
            ];
            $tenant->images = $images;
            $tenant->updated_by = Auth::user()->id;
            $tenant->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "Updated Successfully!";
        }
        return $this->populateresponse();
    }
    public function destroy(Request $request, $id)
    {
        $id = ___decrypt($id);
        $tenant = Tenant::find($id);
        // $banner_img = !empty($tenant->images['banner_img']) ? $tenant->images['banner_img'] : '';
        // $main_logo = !empty($tenant->images['main_logo']) ? $tenant->images['main_logo'] : '';
        // $auth_logo = !empty($tenant->images['auth_logo']) ? $tenant->images['auth_logo'] : '';
        // if (!empty($request->remove == 'main_logo')) {
        //     $main_logo = '';
        // }
        // if (!empty($request->remove == 'banner_img')) {
        //     $banner_img = '';
        // }
        // if (!empty($request->remove == 'auth_logo')) {
        //     $auth_logo = '';
        // }
        $images = [
            'main_logo' => $request->remove == 'main_logo' ? '' : $tenant->images['main_logo'],
            'banner_img' => $request->remove == 'banner_img' ? '' : $tenant->images['banner_img'],
            'auth_logo' => $request->remove == 'auth_logo' ? '' : $tenant->images['auth_logo'],
        ];
        $tenant->images = $images;
        $tenant->updated_by = Auth::user()->id;
        $tenant->save();
        $this->status = true;
        $this->modal = true;
        $this->redirect = "reload_fail";
        $this->message = "Deleted Successful!";
        return $this->populateresponse();
    }
}
