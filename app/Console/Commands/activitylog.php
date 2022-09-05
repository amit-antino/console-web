<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\File;
use ZipArchive;
use Illuminate\Support\Carbon;

class activitylog extends Command
{
    protected $signature = 'miniut:update';

    protected $description = 'Activty Log Clear';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $flag = 0;

        //lastActivity = ::all()->last();
        $lastActivity[] = Activity::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();
        $data = json_encode(compact('lastActivity'));
        $file = now() . '_file.txt';
        $destinationPath = public_path() . "/logs/";
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        if (File::put($destinationPath . $file, $data)) {
            $flag = 1;
        }
        echo "Operation Done";
    }
}
