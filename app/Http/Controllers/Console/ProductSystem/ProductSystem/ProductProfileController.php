<?php

namespace App\Http\Controllers\Console\ProductSystem\ProductSystem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MFG\ProcessSimulation;
use App\Models\ProductSystem\ProductSystem;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductSystem\ProductSystemProfile;
use Illuminate\Support\Facades\Validator;

class ProductProfileController extends Controller
{
    public function index()
    {
    }

    public function create($id)
    {
        $dataEdit = ProductSystem::find(___decrypt($id));
        $data['id'] = $dataEdit['id'];
        $data['name'] = $dataEdit['name'];
        $prd = $dataEdit['process'];
        $sinIds = array_column($prd, 'process_sim');
        $processIds = ProcessSimulation::select(['id', 'process_name'])->find($sinIds);
        $data['process'] = $processIds->toArray();
        $data['count'] = count($processIds->toArray());
        $data['description'] = $dataEdit['description'];
        return view('pages.console.product_system.product_system.profile_create', compact('data'));
    }

    public function store(Request $request)
    {
        
        $prdInput = $request->prdInput;
        while (($key = array_search("0", $prdInput)) !== false) {
            unset($prdInput[$key]);
        }
        $prdOut = $request->prdOut;
        while (($key = array_search("0", $prdOut)) !== false) {
            unset($prdOut[$key]);
        }
        $validator = Validator::make($request->all(), [
            'prd_system' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $prdData = new ProductSystemProfile();
            $prdData->product_system_id  = $request->prd_system;
            $prdData->process_id  = $request->SimPrcess;
            $prdData->product_input = $prdInput;
            $prdData->product_output = $prdOut;
            $prdData->created_by = Auth::user()->id;
            $prdData->updated_by = Auth::user()->id;
            $prdData->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "Process System Profile Added Successfully!";
        }
        return $this->populateresponse();
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
        $prd_pf = ProductSystemProfile::where('id', ___decrypt($id))->first();
        $processdata = ProcessSimulation::select(['id', 'product', 'energy'])->find($prd_pf->process_id);
        $eng = getEnergyHelper($prd_pf->process_id);
        $chem = getChemicalHelper($prd_pf->process_id);
        $chemdata = [];
        foreach ($chem as $chemKey => $chemVal) {
            $chemdata[$chemKey]['id'] = "ch_" . $chemVal['id'];
            $chemdata[$chemKey]['product'] = $chemVal['chemical_name'];
        }
        $engdata = [];
        foreach ($eng as $engKey => $engVal) {
            $engdata[$engKey]['id'] = "en_" . $engVal['id'];
            $engdata[$engKey]['product'] = $engVal['energy_name'];
        }
        $productEng = array_merge($chemdata, $engdata);
        $data['inpout'] = $productEng;
        $dataEdit = ProductSystem::find($prd_pf['product_system_id']);
        $data['prd_id'] = $dataEdit['id'];
        $prd = $dataEdit['process'];
        $sinIds = array_column($prd, 'process_sim');
        $processIds = ProcessSimulation::select(['id', 'process_name'])->find($sinIds);
        $data['process'] = $processIds->toArray();
        $data['prd_pf'] = $prd_pf;
        return response()->json([
            'status' => true,
            'html' => view('pages.console.product_system.product_system.edit_modal', compact('data'))->render()
        ]);
    }

    public function update(Request $request, $id)
    {
        $prdInput = $request->prdInput;
        while (($key = array_search("0", $prdInput)) !== false) {
            unset($prdInput[$key]);
        }
        $prdOut = $request->prdOut;
        while (($key = array_search("0", $prdOut)) !== false) {
            unset($prdOut[$key]);
        }
        $validator = Validator::make($request->all(), [
            'prd_system' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $prdData = ProductSystemProfile::find(___decrypt($id));
            $prdData->product_system_id = $request->prd_system;
            $prdData->process_id  = $request->SimPrcess;
            $prdData->product_input = $prdInput;
            $prdData->product_output = $prdOut;
            $prdData->updated_at = now();
            $prdData->updated_by = Auth::user()->id;
            $prdData->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true;
            $this->message = "Product System Profile Updates Successfully!";
        }
        return $this->populateresponse();
    }

    public function destroy($id)
    {
        $pid = ProductSystemProfile::select('product_system_id')->where('id', ___decrypt($id))->first();
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (ProductSystemProfile::where('id', ___decrypt($id))->update($update)) {
            ProductSystemProfile::destroy(___decrypt($id));
        }
        $this->status = true;
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
        if (!empty($processIDS)) {
            $pdid = $processIDS[0];
            $pid = ProductSystemProfile::select('product_system_id')->where('id', $pdid)->first();
        }
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (ProductSystemProfile::whereIn('id', $processIDS)->update($update)) {
            ProductSystemProfile::destroy($processIDS);
        }
        $this->status = true;
        $this->redirect = url('/product_system/product/' . ___encrypt($pid->product_system_id));
        return $this->populateresponse();
    }
}
