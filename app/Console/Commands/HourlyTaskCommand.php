<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Log;

class HourlyTaskCommand extends Command
{
    protected $signature = 'app:hourly-task-command';
    protected $description = 'Updates loan transactions to overdue status if older than 7 days';

    public function handle()
    {
        try {
            $controller = new TaskController();
            $controller->hourlyTask();
            $this->info('Hourly task completed successfully.');
        } catch (\Exception $e) {
            Log::error('Hourly task failed: ' . $e->getMessage());
            $this->error('Hourly task failed.');
        }
    }
}
