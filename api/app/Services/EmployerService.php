<?php

namespace App\Services;

use App\Models\Job;
use App\Models\User;
use App\Notifications\NewJobPosted;
use App\Notifications\Role;

class EmployerService
{
    public function postJob(array $params): Job
    {
        $email = $params['contact_email'];
        $hasPreviousPost = Job::where('contact_email', $email)->exists();
        $job = Job::create($params);

        if (!$hasPreviousPost) {
            $moderators = User::whereHas('role', function ($query) {
                $query->where('name', 'moderator');
            })->get();

            foreach ($moderators as $moderator) {
                $moderator->notifyNow(new NewJobPosted($job));
            }
        }

        return $job;
    }
}