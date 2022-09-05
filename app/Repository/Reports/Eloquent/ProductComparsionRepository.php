<?php

namespace App\Repository\Reports\Eloquent;

use App\Models\Report\ProductSystemComparsionReport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repository\Reports\Interfaces\ProductComparsionInterface;

class ProductComparsionRepository implements ProductComparsionInterface
{
    public function getAll()
    {
        $reports = ProductSystemComparsionReport::get();
        return $reports;
    }

    public function createReport($request)
    {
        $simulationData = new ProductSystemComparsionReport();
        $simulationData->report_name = $request->report_name;
        $simulationData->report_type = $request->report_type;
        $simulationData->product_system_id =  ___decrypt($request->product_system);
        $simulationData->description =  ($request->description);
        $simulationData->created_by = Auth::user()->id;
        $simulationData->updated_by = Auth::user()->id;
        $tags = [];
        if ($request->tags != "") {
            $tags = explode(",", $request->tags);
        } else {
            $tags = [];
        }
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
        if (ProductSystemComparsionReport::where('id', ___decrypt($id))->update($update)) {
            $del = ProductSystemComparsionReport::destroy(___decrypt($id));
        }
        return $del;
    }
}
