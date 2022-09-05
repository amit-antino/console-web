<?php

namespace App\Http\Controllers\Admin\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Tenant\DbBackup;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller
{
    public function index($tenant_id)
    {
        $data['tenant_id'] = $tenant_id;
        return view('pages.admin.tenant.backup.index', $data);
    }

    public function create($tenant_id)
    {
        $data['tenant_id'] = $tenant_id;
        $data['backups'] = DbBackup::where('tenant_id', ___decrypt($tenant_id))->get();
        return view('pages.admin.tenant.backup.create', $data);
    }

    public function store(Request $request, $tenant_id)
    {
        $validator = Validator::make($request->all(), [
            'backup_period' => 'required',
        ]);
        if ($validator->fails()) {
            $this->message = $validator->errors();
        } else {
            $data['tenant_id'] = $tenant_id;
            $db_backup = new DbBackup;
            $db_backup->tenant_id = ___decrypt($tenant_id);
            $db_backup->minute = !empty($request->minute) ? $request->minute : '*';
            $db_backup->hour = !empty($request->hour) ? $request->hour : '*';
            $db_backup->day = !empty($request->day) ? $request->day : '*';
            $db_backup->month = !empty($request->month) ? $request->month : '*';
            $db_backup->day_week = !empty($request->day_week) ? $request->day_week : '*';
            $db_backup->backup_period = $request->backup_period;
            $db_backup->created_by = Auth::user()->id;
            $db_backup->updated_by = Auth::user()->id;
            $db_backup->save();
            $this->status = true;
            $this->modal = true;
            $this->redirect = true; //url('admin/tenant/'.$tenant_id.'/backup');
            $this->message = "Backup Config Created Successfully";
        }
        return $this->populateresponse();
    }

    public function destroy($tenant_id)
    {
        $data['tenant_id'] = $tenant_id;
        return view('pages.admin.tenant.backup.config', $data);
    }

    public function backup_run(Schedule $schedule, $tenant_id)
    {
        $backup = DbBackup::orderBy('id', 'desc')->first();
        $minute = $backup->minute;
        $hour = $backup->hour;
        $day = $backup->day;
        $month = $backup->month;
        $day_week = $backup->day_week;
        $schedule->command('backup:run')->cron($minute . ' ' . $hour . ' ' . $day . ' ' . $month . ' ' . $day_week);
        return true;
    }

    public function databse_backup()
    {
        // define("BACKUP_PATH", url('/data_base'));
        // $server_name   = "localhost";
        // $username      = "root";
        // $password      = "";
        // $database_name = "console_dev";
        // $date_string   = date("Ymd");
        // $cmd = "mysqldump --routines -h {$server_name} -u {$username} -p{$password} {$database_name} > " . BACKUP_PATH . "{$date_string}_{$database_name}.sql";
        // exec($cmd);
        define("BACKUP_PATH", public_path('/assets/backups/'));
        $server_name   = env('DB_HOST');
        $username      = env('DB_USERNAME');
        $password      = env('DB_PASSWORD');
        $database_name = env('DB_DATABASE');
        $date_string   = date("d_m_Y");
        $cmd = "mysqldump --routines -h {$server_name} -u {$username} -p{$password} {$database_name} > " . BACKUP_PATH . "{$date_string}_{$database_name}.sql";
        exec($cmd);
        return true;
    }
}
