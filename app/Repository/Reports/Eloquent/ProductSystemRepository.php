<?php

namespace App\Repository\Reports\Eloquent;

use App\Models\Report\ProductSystemReport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repository\Reports\Interfaces\ProductSystemInterface;

class ProductSystemRepository implements ProductSystemInterface
{
    public function getAll()
    {
        $reports = ProductSystemReport::get();
        return $reports;
    }

    public function createReport($request)
    {
        dd($request->all());
        $simulationData = new ProductSystemReport();
        $simulationData->report_name = $request->report_name;
        $simulationData->product_system_id =  ___decrypt($request->product_system_id);
        // $simulationData->process_simulation_ids =  ($request->process_simulation);
        // $simulationData->number_of_process =  ($request->pscount);
        // $simulationData->description =  ($request->description);
        $simulationData->created_by = Auth::user()->id;
        $simulationData->updated_by = Auth::user()->id;
        $simulationData->tenant_id = session()->get('tenant_id');
        $tags = [];
        // if ($request->tags != "") {
        //     $tags = explode(",", $request->tags);
        // } else {
        //     $tags = [];
        // }
        $simulationData->tags = $tags;
        $simulationData->save();
        $status = true;
        return $status;
    }

    public function destroy($id)
    {
        $del = 0;
        $update['updated_by'] = Auth::user()->id;
        $update['updated_at'] = now();
        if (ProductSystemReport::where('id', ___decrypt($id))->update($update)) {
            $del = ProductSystemReport::destroy(___decrypt($id));
        }
        return $del;
    }
}
