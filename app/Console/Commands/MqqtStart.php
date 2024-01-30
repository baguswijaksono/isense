<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MqqtStart extends Command
{    protected $signature = 'mqqt:start'; 

    protected $description = 'Start Mqqt Subsciber';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $cmdCommand = 'php artisan mqtt:subscribe';
    
        exec($cmdCommand);
    }
    
}
