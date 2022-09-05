<?php

namespace App\Http\Controllers\Console\Experiment\ProcessExperiment;

use App\Http\Controllers\Controller;
use App\Models\Experiment\sim_inp_template_upload;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class SimInpTemplateUploadController extends Controller
{
    public function index(Request $request)
    {
        $match[]=['template_id','=',$request->template_id];
        $match[]=['type','=',$request->type];
        $log=sim_inp_template_upload::where($match)->get(DB::raw("id as uploaded_id,tenant_id,template_id,template_name,variation_id,type,excel_file,status,entry_by,ip_add,created_at,updated_at,(select count(id) from simulate_inputs where file_id=uploaded_id) as total"));
        $str='';
        foreach($log as $rows)
        {
            if($rows['tenant_id']>0)
                $inputFileName=public_path('assets/uploads/simulation_input_excel/'.$rows['tenant_id'].'/'.$rows['excel_file']);
            else
                $inputFileName=public_path('assets/uploads/simulation_input_excel/'.$rows['excel_file']);
            $row =  Excel::toArray([],$inputFileName);
            $total=sizeof($row[0])-3;
            $success=$rows['total'];
            $pending=$total-$success;
            $status=$rows['status']==0?"<i class='fas fa-sync-alt text-warning'></i>":"<i class='fa fa-check text-success'></i>";
            $str.="
            <tr>
                <td><a href='".$inputFileName."' download><i class='fa fa-download'></i></a></td>
                <td>".$total."</td>
                <td>".$success."</td>
                <td>".$pending."</td>
                <td>".$status."</td>
                <td>".$rows['created_at']."</td>
            </tr>
            ";
        }
        echo $str;
    }
    public function create()
    {
        
    }
    
    public function store(Request $request)
    {
        
    }

    public function show(sim_inp_template_upload $sim_inp_template_upload)
    {
        
    }
    
    public function edit(sim_inp_template_upload $sim_inp_template_upload)
    {
        
    }
    
    public function update(Request $request, sim_inp_template_upload $sim_inp_template_upload)
    {
        
    }
    
    public function destroy(sim_inp_template_upload $sim_inp_template_upload)
    {
        
    }
}
