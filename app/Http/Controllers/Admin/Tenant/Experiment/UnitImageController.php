<?php

namespace App\Http\Controllers\Admin\Tenant\Experiment;

use App\Http\Controllers\Controller;
use App\Models\Experiment\CriteriaMaster;
use App\Models\Experiment\ExperimentConditionMaster;
use App\Models\Experiment\ExperimentOutcomeMaster;
use Illuminate\Http\Request;
use App\Models\Experiment\ExperimentUnitImage;
use App\Models\Experiment\PriorityMaster;
use App\Models\Models\ModelDetail;
use App\Models\Organization\Experiment\EquipmentUnit;
use App\Models\Organization\Experiment\ExperimentCategory;
use App\Models\Organization\Experiment\ExperimentClassification;
use App\Models\ProcessExperiment\DataRequestModel;
use App\Models\ProcessExperiment\DatasetModel;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class UnitImageController extends Controller
{
    public function index($tenant_id)
    {
        $data['unit_image'] = ExperimentUnitImage::where(['tenant_id' => ___decrypt($tenant_id)])->get();
        $data['tenant_id'] = $tenant_id;
        return view('pages.admin.master.experiment.unit_image.index', $data);
    }

    public function store(Request $request, $tenant_id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => ['required','image', 'mimes:jpg,png,jpeg,gif'],
        ],
        [
            'image.image'=> 'File format must be an Image', // custom message   
        ]
        );
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $unit_image =  new ExperimentUnitImage();
            $unit_image['name'] = $request->name;
            $unit_image['tenant_id'] = ___decrypt($tenant_id);
            $unit_image['description'] = $request->description;
            if (!empty($request->image)) {
                $image = upload_file($request, 'image', 'experiment_base_unit');
                $unit_image['image'] = $image;
            }
            $unit_image['created_by'] = Auth::user()->id;
            $unit_image['updated_by'] = Auth::user()->id;
            $unit_image->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/tenant/' . $tenant_id . '/experiment/unit_image');
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
            $update = ExperimentUnitImage::find(___decrypt($id));
            $update['status'] = $status;
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            $update->save();
        } else {
            $update['status'] = "inactive";
            $update['updated_by'] = Auth::user()->id;
            $update['updated_at'] = now();
            if (ExperimentUnitImage::where('id', ___decrypt($id))->update($update)) {
                ExperimentUnitImage::destroy(___decrypt($id));
            }
        }
        $this->status = true;
        $this->redirect = url('admin/tenant/' . $tenant_id . '/experiment/unit_image');
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
        if (ExperimentUnitImage::whereIn('id', $processIDS)->update($update)) {
            ExperimentUnitImage::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('admin/tenant/' . $tenant_id . '/experiment/unit_image');
        return $this->populateresponse();
    }

    public function edit($tenant_id, $id)
    {
        $unit_image = ExperimentUnitImage::where('id', ___decrypt($id))->first();
        $data['tenant_id'] = $tenant_id;
        return response()->json([
            'status' => true,
            'html' => view('pages.admin.master.experiment.unit_image.edit', ['unit_image' => $unit_image, 'tenant_id' => $tenant_id])->render()
        ]);
    }

    public function update(Request $request, $tenant_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'image' => ['image', 'mimes:jpg,png,jpeg,gif'],
        ],
        [
            'image.image'=> 'File format must be an Image', // custom message   
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $unit_image =  ExperimentUnitImage::find(___decrypt($id));
            $unit_image['name'] = $request->name;

            $unit_image['description'] = $request->description;
            if (!empty($request->image)) {
                $image = upload_file($request, 'image', 'experiment_base_unit');
                $unit_image['image'] = $image;
            }
            $unit_image['updated_by'] = Auth::user()->id;
            $unit_image['updated_at'] = now();
            $unit_image->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = url('admin/tenant/' . $tenant_id . '/experiment/unit_image');
            $this->message = " Updated Successfully!";
        }
        return $this->populateresponse();
    }

    public function experiment_manage($tenant_id)
    {
        $data['unit_image_count'] = ExperimentUnitImage::where(['tenant_id' => ___decrypt($tenant_id)])->count();
        $data['condition_master_count'] = ExperimentConditionMaster::where(['tenant_id' => ___decrypt($tenant_id)])->count();
        $data['outcome_master_count'] = ExperimentOutcomeMaster::where(['tenant_id' => ___decrypt($tenant_id)])->count();
        $data['equipment_count'] = EquipmentUnit::where(['tenant_id' => ___decrypt($tenant_id)])->count();
        $data['model_count'] = ModelDetail::where(['tenant_id' => ___decrypt($tenant_id)])->count();
        $data['priority_count'] = PriorityMaster::where(['tenant_id' => ___decrypt($tenant_id)])->count();
        $data['criteria_count'] = CriteriaMaster::where(['tenant_id' => ___decrypt($tenant_id)])->count();
        $data['category_count'] = ExperimentCategory::where(['tenant_id' => ___decrypt($tenant_id)])->count();
        $data['classification_count'] = ExperimentClassification::where(['tenant_id' => ___decrypt($tenant_id)])->count();
        $data['model_count'] = ModelDetail::where(['tenant_id' => ___decrypt($tenant_id)])->count();
        $data['dataset_count'] = DatasetModel::where(['tenant_id' => ___decrypt($tenant_id)])->count();
        $data['data_request_count'] = DataRequestModel::where(['tenant_id' => ___decrypt($tenant_id)])->count();
        $data['tenant_id'] = $tenant_id;
        return view('pages.admin.master.experiment.manage', $data);
    }
}
