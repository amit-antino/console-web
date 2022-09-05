<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\MailCron::class,
        Commands\MultipleGenerationReport::class,
        Commands\ReportGenerationApiCall::class,
        Commands\SimulationInputImportExcel::class,
    ];
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('mail:cron')
                 ->everyMinute();
        $schedule->command('MultipleGeneration:Report')
                 ->everyMinute();
        $schedule->command('ReportGeneration:ApiCall')
                 ->everyMinute();
        $schedule->command('Input:SimulationInputImportExcel')
                 ->everyMinute();
    }

    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');
        require base_path('routes/console.php');
    }
}
