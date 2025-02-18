<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JobService;
use App\Http\Resources\JobCollectionResource;   

class JobSeekerController extends Controller
{
    public function __construct(
        private readonly JobService $jobService
    ) { }

    public function allJobPosts()
    {
        return new JobCollectionResource($this->jobService->getJobPosts());
    }
}
