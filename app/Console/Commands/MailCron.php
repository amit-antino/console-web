<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MailCron extends Command
{
    protected $signature = 'mail:cron';

    protected $description = 'This command is used for execute mail jobs';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // \Log::info("Cron is working fine!");
        return true;
    }
}
