<?php

namespace App\Services;

use App\Models\Job;

class JobService
{
    public function getJobPosts()
    {
        $jobs = Job::orderBy('created_at', 'desc')->paginate();
        return $jobs;
    }
}