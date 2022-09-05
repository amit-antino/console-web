<?php

namespace App\Http\Controllers\Admin\Tenant\Reaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OtherInput\Reaction\ReactionType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\OtherInput\Reaction\ReactionPhase;

class ReactionTypeController extends Controller
{
    public function index(Request $request, $tenant_id)
    {
        $data['reaction'] = ReactionType::where(['tenant_id' => ___decrypt($tenant_id)])->get();
        $reaction_props = [];
        foreach ($data['reaction'] as $reaction) {
            $reaction_props[] = [
                'id' => $reaction['id'],
                'name' => $reaction['name'],
            ];
        }
        if ($request->is('api/*')) {
            return response()->json([
                'success' => true,
                'status_code' => 200,
                'status' => true,
                'data' => $reaction_props
            ]);
        }
        $data['tenant_id'] = $tenant_id;
        return view('pages.admin.tenant.reaction.reaction_type.index', $data);
    }

    public function reaction_manage($tenant_id)
    {

        $data['tenant_id'] = $tenant_id;
        $data['reaction'] = ReactionType::where(['tenant_id' => ___decrypt($tenant_id)])->get();
        $data['reaction_phase'] = ReactionPhase::where(['tenant_id' => ___decrypt($tenant_id)])->get();
        $data['reaction_count'] = count($data['reaction']);
        $data['reaction_phase_count'] = count($data['reaction_phase']);
        return view('pages.admin.tenant.reaction.index', $data);
    }

    public function store(Request $request, $tenant_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $property =  new ReactionType();
            $property['name'] = $request->name;
            $property['description'] = $request->description;
            $property['created_by'] = Auth::user()->id;
            $property['updated_by'] = Auth::user()->id;
            $property['tenant_id'] = ___decrypt($tenant_id);
            $property->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/tenant/' . ($tenant_id) . '/reaction/reaction_type');
            $this->message = "Added Successfully!";
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
            $update = ReactionType::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (ReactionType::where('id', ___decrypt($id))->update($update)) {
                ReactionType::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/tenant/' . $tenant_id . '/reaction/reaction_type');
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
        if (ReactionType::whereIn('id', $processIDS)->update($update)) {
            ReactionType::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('admin/tenant/' . $tenant_id . '/reaction/reaction_type');
        return $this->populateresponse();
    }

    public function edit($tenant_id, $id)
    {
        $reaction_type = ReactionType::where('id', ___decrypt($id))->first();
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.tenant.reaction.reaction_type.edit', [
                'reaction_type' => $reaction_type, 'tenant_id' => $tenant_id
            ])->render()
        ]);
    }

    public function update(Request $request, $tenant_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $property = ReactionType::find(___decrypt($id));
            $property['name'] = $request->name;
            $property['description'] = $request->description;
            $property['updated_by'] = Auth::user()->id;
            $property['updated_at'] = now();
            $property['tenant_id'] = ___decrypt($tenant_id);
            $property->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/tenant/' . $tenant_id . '/reaction/reaction_type');
            $this->message = "Updated Successfully!";
        }
        return $this->populateresponse();
    }
}
