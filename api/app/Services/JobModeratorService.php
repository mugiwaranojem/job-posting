<?php

namespace App\Services;

use App\Models\Job;

class JobModeratorService
{
    public function approveJob(int $jobId): void
    {
        $job = Job::find($jobId);
        $job->update(['status' => 'APPROVED']);
    }

    public function markAsSpam(int $jobId)
    {
        $job = Job::find($jobId);
        $job->update(['status' => 'SPAM']);
    }
}