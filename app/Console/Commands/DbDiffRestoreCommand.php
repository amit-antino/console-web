<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;

class DbDiffRestoreCommand extends Command
{
    protected $signature = 'db_diffbackup:restore';

    protected $description = 'This Command is used for Database backup';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $server_name   = env('DB_HOST');
        $username      = env('DB_USERNAME');
        $password      = env('DB_PASSWORD');
        $database_name = env('DB_DATABASE');
        $date_string   = date("d_m_Y");
        $list = DB::select('SHOW BINARY LOGS');
        $cnt = count($list);
        $path  = $list[$cnt - 2]->Log_name;
        $cmd = "mysqlbinlog /var/log/mysql/{$path} | mysql -u{$username} -p{$password} {$database_name}";
        exec($cmd);
        return Command::SUCCESS;
    }
}
