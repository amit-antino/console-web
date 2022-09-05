<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\File;
use ZipArchive;
use Illuminate\Support\Carbon;

class activitylogzip extends Command
{
    protected $signature = 'log:zip';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $zip = new ZipArchive;
        $fileName = now() . 'log.zip';
        $path = public_path('logs');
        $destinationPath12 = public_path() . "/logsZip/";
        if ($zip->open(public_path($fileName), ZipArchive::CREATE) === TRUE) {
            $files = File::allfiles($path);
            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }
            $zip->close();
            File::put($destinationPath12 . $fileName, $zip);
            Activity::where('created_at', '>=', Carbon::now()->subdays(15))->delete();
        }
    }
}
