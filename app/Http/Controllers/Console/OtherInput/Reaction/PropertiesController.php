<?php

namespace App\Http\Controllers\Console\OtherInput\Reaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OtherInput\Reaction\ReactionProperty;
use App\Models\OtherInput\Reaction;
use Illuminate\Support\Facades\Auth;

class PropertiesController extends Controller
{
    public function index($id)
    {
        $data['reaction_properties'] = ReactionProperty::where('reaction_id', ___decrypt($id))->get();
        $data['reaction_data'] = Reaction::where('id', ___decrypt($id))->first();
        $data['reaction_id'] = ___decrypt($id);
        return view('pages.console.other_input.reaction.properties.index', $data);
    }

    public function store(Request $request, $id)
    {
        $id = ___decrypt($id);
        $reaction_properties = new ReactionProperty();
        $reaction_properties['reaction_id'] = $id;
        $reaction_properties['created_by'] = Auth::user()->id;
        $reaction_properties['updated_by'] = Auth::user()->id;
        $reaction_properties['created_at'] = now();
        $reaction_properties['updated_at'] = now();
        if ($request->type == 'rate_calculation') {
            $json_data = [
                'reaction_type' => $request->reaction_type,
                'name' => $request->name,
                'a' => $request->a,
                'e' => $request->e,
                'rate_constant' => $request->rate_constant,
                'temperature_k' => $request->temperature_k,
                'cat_type' => $request->cat_type,
                'catalyst_factor' => $request->cat_or_exp
            ];
            $reaction_properties['properties'] = $json_data;
            $reaction_properties['type'] = 'rate_parameter';
            $reaction_properties['sub_type'] = 'calculation';
        } elseif ($request->type == 'rate_user_input') {
            $json_data = [
                'reaction_type' => $request->reaction_type,
                'name' => $request->name,
                'rate_constant' => $request->rate_constant,
                'temperature_k' => $request->temperature_k,
                'cat_type' => $request->cat_type,
                'catalyst_factor' => $request->cat_or_exp
            ];
            $reaction_properties['properties'] = $json_data;
            $reaction_properties['type'] = 'rate_parameter';
            $reaction_properties['sub_type'] = 'user_input';
        } elseif ($request->type == 'equi_calculation') {
            $json_data = [
                'name' => $request->name,
                'keq_value' => $request->keq_value,
                'temperature_k' => $request->temperature_k
            ];
            $reaction_properties['properties'] = $json_data;
            $reaction_properties['type'] = 'equilibrium';
            $reaction_properties['sub_type'] = 'calculation';
        } elseif ($request->type == 'equi_user_input') {
            $json_data = [
                'name' => $request->name,
                'keq_value' => $request->keq_value,
                'temperature_k' => $request->temperature_k
            ];
            $reaction_properties['properties'] = $json_data;
            $reaction_properties['type'] = 'equilibrium';
            $reaction_properties['sub_type'] = 'user_input';
        }
        $reaction_properties->save();
        $this->status = true;
        $this->modal = true;
        $this->alert = true;
        $this->redirect = true;
        $this->message = "Reaction Properties Added successfully.";
        return $this->populateresponse();
    }

    public function destroy(Request $request, $reaction_id, $id)
    {
        ReactionProperty::find(___decrypt($id))->delete();
        $this->status = true;
        $this->redirect = true;
        return $this->populateresponse();
    }

    public function edit(Request $request, $reaction_id, $id)
    {
        $property = ReactionProperty::where('id', ___decrypt($id))->first();
        $prop_data  = $property->properties;
        return response()->json([
            'status' => true,
            'html' => view('pages.console.other_input.reaction.properties.' . $request->edit_type, ['property' => $property, 'reaction_id' => $reaction_id, 'prop_data' => $prop_data])->render()
        ]);
    }

    public function update(Request $request, $reaction_id, $id)
    {
        $id = ___decrypt($id);
        $reaction_properties =  ReactionProperty::find($id);
        $reaction_properties['updated_by'] = Auth::user()->id;
        $reaction_properties['updated_at'] = now();
        if ($request->type == 'rate_calculation') {
            $json_data = [
                'reaction_type' => $request->reaction_type,
                'name' => $request->name,
                'a' => $request->a,
                'e' => $request->e,
                'rate_constant' => $request->rate_constant,
                'temperature_k' => $request->temperature_k,
                'cat_type' => $request->cat_type,
                'catalyst_factor' => $request->cat_or_exp
            ];
            $reaction_properties['properties'] = $json_data;
            $reaction_properties['type'] = 'rate_parameter';
            $reaction_properties['sub_type'] = 'calculation';
        } elseif ($request->type == 'rate_user_input') {
            $json_data = [
                'reaction_type' => $request->reaction_type,
                'name' => $request->name,
                'rate_constant' => $request->rate_constant,
                'temperature_k' => $request->temperature_k,
                'cat_type' => $request->cat_type,
                'catalyst_factor' => $request->cat_or_exp
            ];
            $reaction_properties['properties'] = $json_data;
            $reaction_properties['type'] = 'rate_parameter';
            $reaction_properties['sub_type'] = 'user_input';
        } elseif ($request->type == 'equi_calculation') {
            $json_data = [
                'name' => $request->name,
                'keq_value' => $request->keq_value,
                'temperature_k' => $request->temperature_k
            ];
            $reaction_properties['properties'] = $json_data;
            $reaction_properties['type'] = 'equilibrium';
            $reaction_properties['sub_type'] = 'calculation';
        } elseif ($request->type == 'equi_user_input') {
            $json_data = [
                'name' => $request->name,
                'keq_value' => $request->keq_value,
                'temperature_k' => $request->temperature_k
            ];
            $reaction_properties['properties'] = $json_data;
            $reaction_properties['type'] = 'equilibrium';
            $reaction_properties['sub_type'] = 'user_input';
        } elseif ($request->type == 'notes_editor') {
            $reaction_properties['notes'] = $request->note;
        }
        $reaction_properties->save();
        $this->status = true;
        $this->modal = true;
        $this->alert = true;
        $this->redirect = true;
        $this->message = "Reaction Properties Updated successfully.";
        return $this->populateresponse();
    }
}
