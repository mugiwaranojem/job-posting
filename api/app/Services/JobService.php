<?php

namespace App\Services;

use App\Models\Job;

class JobService
{
    public function __construct(
        private readonly JobModeratorService $jobModeratorService
    ) { }

    public function getMergedJobPosts()
    {
        $jobs = Job::where('status', 'APPROVED')
            ->orderBy('created_at', 'desc')->paginate(10);

        // Fetch external jobs (XML format)
        $externalJobs = $this->jobModeratorService->fetchExternalJobs();

        $mergedJobs = $externalJobs->merge(collect($jobs->items()));

        return $mergedJobs;

    }

    public function getJobPosts()
    {
        $jobs = Job::where('status', 'APPROVED')
            ->orderBy('created_at', 'desc')->paginate(10);

        return $jobs;
    }

    public function getJobDetails(int $id)
    {
        return Job::find($id);
    }
}