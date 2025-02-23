<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\JobModeratorService;

class SyncJobPosts extends Command
{
    /**
     * This command can execute cron to 
     * run every 30 minutes to sync update from external sources
     *
     * @var string
     */
    protected $signature = 'jobs:sync';

    /**
     * @var string
     */
    protected $description = 'This command is to sync external jobs into internal ones';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        private readonly JobModeratorService $jobModeratorService
    ) {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->jobModeratorService->syncExternalJobs();
        $this->info('DONE');
        return 0;
    }
}
