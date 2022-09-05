<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJobsQueueRequest;
use App\Http\Requests\UpdateJobsQueueRequest;
use App\Models\Experiment\JobsQueue;

class JobsQueueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function destroy(JobsQueue $jobsQueue)
    {
        //
    }
}
