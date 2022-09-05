<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreJobsQueueRequest;
use App\Http\Requests\UpdateJobsQueueRequest;
use App\Models\Experiment\JobsQueue;
use Illuminate\Http\Request;
use App\Models\Experiment\sim_inp_template_upload;
use DB;

class JobsQueueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $simInp=sim_inp_template_upload::orderBy('created_at','desc')->get(DB::raw("id,id as uId,tenant_id,template_id,template_name,variation_id,type,excel_file,status,entry_by,ip_add,created_at,updated_at,(select count(created_at) from simulate_inputs where file_id=uId) as total"));
        $joblist=JobsQueue::orderBy('created_at','desc')->get(DB::raw("id,id as jId,jobs,queue_data,status,created_by,deleted_at,created_at,updated_at,(select count(created_at) from experiment_reports where job_id=jId and status='success') as total,(select count(created_at) from experiment_reports where job_id=jId and status='failure') as failed"));;
        $data['jobslist']=$simInp->merge($joblist)->sortByDesc('created_at');
        return view('pages.admin.job_queue.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreJobsQueueRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJobsQueueRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Experiment\JobsQueue  $jobsQueue
     * @return \Illuminate\Http\Response
     */
    public function show(JobsQueue $jobsQueue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Experiment\JobsQueue  $jobsQueue
     * @return \Illuminate\Http\Response
     */
    public function edit(JobsQueue $jobsQueue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateJobsQueueRequest  $request
     * @param  \App\Models\Experiment\JobsQueue  $jobsQueue
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJobsQueueRequest $request, JobsQueue $jobsQueue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Experiment\JobsQueue  $jobsQueue
     * @return \Illuminate\Http\Response
     */
    public function deleteSimulateInputJob($id=null)
    {
        sim_inp_template_upload::destroy(___decrypt($id));
        $this->status = true;
        $this->modal = true;
        $this->redirect = true;
        return $this->populateresponse();
    }
    public function destroy($id=null)
    {
        JobsQueue::destroy(___decrypt($id));
        $this->status = true;
        $this->modal = true;
        $this->redirect = true;
        return $this->populateresponse();
    }
    public function bulkDelete(Request $request)
    {
        $jobslist = implode(',', $request->bulk);
        $jobsId = explode(',', ($jobslist));
       
        foreach ($jobsId as $idval) {
            $ids=explode('@',$idval);
            if($ids[1]=="job")
                $jobId[] = ___decrypt($ids[0]);
            else
                $simId[] = ___decrypt($ids[0]);
           
        }
        if(isset($jobId))
        {
            JobsQueue::destroy($jobId);
        }
        if(isset($simId))
        {
            sim_inp_template_upload::destroy($simId);
        }
        $this->status = true;
        $this->redirect = url('admin/job-queue');
        return $this->populateresponse();
    }
}
