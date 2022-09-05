<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DbLog extends Model
{
    protected $connection = 'tenant';

    public function set_connection($val)
    {
        $this->connection = $val;
    }

    public function select_all_db2_users()
    {
        $results = DB::connection($this->connection);
        return $results;
    }

    public function select_all_db_users()
    {
        $results = DB::connection($this->connection);
        return $results;
    }

    public function close_connection()
    {
        DB::disconnect('mysql');
    }
}
