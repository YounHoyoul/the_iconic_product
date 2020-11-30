<?php

namespace App\Console;

use App\Console\Commands\Product;
use App\Console\Commands\ProductSave;
use App\Console\Commands\ProductDownload;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\VideoPreviewDownload;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        ProductDownload::class,
        VideoPreviewDownload::class,
        ProductSave::class,
        Product::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
