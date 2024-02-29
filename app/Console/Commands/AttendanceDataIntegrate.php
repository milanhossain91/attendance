<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ZkController;

class AttendanceDataIntegrate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendance:masudrana';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attendance data download';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {   
        info('Welcome to Md. Masud Rana. Successfully run.');
        $controller = new ZkController();
        $controller->postAttDeviceAuto();

        return 0;
    }
}
