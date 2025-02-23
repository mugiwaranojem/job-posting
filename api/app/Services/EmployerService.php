<?php

namespace App\Services;

use App\Models\Job;
use App\Models\User;
use App\Notifications\NewJobPosted;
use App\Notifications\Role;

class EmployerService
{
    public function __construct(
        private readonly JobModeratorService $jobModeratorService
    ) { }

    public function postJob(array $params): Job
    {
        $email = $params['contact_email'];
        $hasPreviousPost = Job::where('contact_email', $email)->exists();
        $job = Job::create($params);

        if (!$hasPreviousPost) {
            $this->jobModeratorService->notifyModerators($job);
        }

        return $job;
    }
}