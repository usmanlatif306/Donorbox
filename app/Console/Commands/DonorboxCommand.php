<?php

namespace App\Console\Commands;

use App\Services\DonorboxService;
use Illuminate\Console\Command;

class DonorboxCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'donorbox:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will fetch data fro donorbox and update database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $service = new DonorboxService();

        $service->compaigns();
        $service->donors();
        $service->donations();
        $service->plans();

        $this->info('Success!');
    }
}
