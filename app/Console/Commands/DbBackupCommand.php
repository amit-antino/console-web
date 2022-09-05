<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DbBackupCommand extends Command
{
    protected $signature = 'db_backup:get';

    protected $description = 'This Command is used for Database backup';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        define("BACKUP_PATH", public_path('/assets/backups/'));
        $server_name   = env('DB_HOST');
        $username      = env('DB_USERNAME');
        $password      = env('DB_PASSWORD');
        $database_name = env('DB_DATABASE');
        $date_string   = date("d_m_Y");
        $cmd = "mysqldump --routines -h {$server_name} -u {$username} -p{$password} {$database_name} > " . BACKUP_PATH . "{$date_string}_{$database_name}.sql";
        exec($cmd);
        return Command::SUCCESS;
    }
}
