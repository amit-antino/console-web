<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Organization\Users\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\UserNotification;
use App\Notifications\EmailNotification;
use Illuminate\Support\Facades\Http;
use App\Models\Report\ExperimentReport;

class GetProcessExpReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 5;
    public $timeout = 120;
    public ExperimentReport $experimentReport;

    public function __construct(ExperimentReport $experimentReport)
    {
        $this->experimentReport = $experimentReport;
    }

    public function handle()
    {
     
    }
}
