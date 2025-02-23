<?php

namespace App\Services;

use App\Models\Job;
use SimpleXMLElement;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Notifications\NewJobPosted;
use App\Services\JobApprovalUrlService;
use App\Services\JobSpamUrlService;

class JobModeratorService
{
    public function __construct(
        private readonly JobApprovalUrlService $jobApprovalUrlService,
        private readonly JobSpamUrlService $jobSpamUrlService
    ) { }

    public const EXTERNAL_API_JOB = 'https://mrge-group-gmbh.jobs.personio.de/xml';

    public function approveJob(int $jobId): Job
    {
        $job = Job::find($jobId);
        $job->update(['status' => 'APPROVED']);
        return $job;
    }

    public function markAsSpam(int $jobId): Job
    {
        $job = Job::find($jobId);
        $job->update(['status' => 'SPAM']);
        return $job;
    }

    public function notifyModerators(Job $job)
    {
        $moderators = User::whereHas('role', function ($query) {
            $query->where('name', 'moderator');
        })->get();

        $this->jobApprovalUrlService->createUrlVerification($job->id);
        $this->jobSpamUrlService->createUrlVerification($job->id);

        foreach ($moderators as $moderator) {
            $moderator->notifyNow(new NewJobPosted($job));
        }
    }

    /**
     * Fetch external jobs from API and convert XML Object to Job Collection.
     */
    public function fetchExternalJobs()
    {
        try {
            $response = Http::get(self::EXTERNAL_API_JOB);

            if ($response->failed()) {
                Log::error("Failed to fetch external jobs.");
                return [];
            }

            $xml = new SimpleXMLElement($response->body());
            $externalJobs = [];

            foreach ($xml as $job) {
                $descriptions = '';
                $descArr = $job->jobDescriptions->jobDescription ?? [];
                foreach($descArr as $jd) {
                    $descriptions = '<p><b>'.(string) $jd->name.'</b></p>';
                    $descriptions .= '<p>'. (string) $jd->value.'</p>';
                }

                $jobModel = new Job;
                $externalId = intval((string) $job->id);
                $jobModel->id = $externalId;
                $jobModel->title = (string) $job->name;
                $jobModel->description = $descriptions;
                $jobModel->created_at = (string) $job->createdAt;
                $jobModel->source = 'mrge_group';
                $jobModel->source_id = $externalId;
                $externalJobs[] = $jobModel;
            }

            return collect($externalJobs);

        } catch (\Exception $e) {
            Log::error("Error fetching external jobs: " . $e->getMessage());
            return [];
        }
    }

    public function syncExternalJobs()
    {
        $externalJobs = $this->fetchExternalJobs();
        foreach ($externalJobs as $externalJob) {
            $internalJob = Job::where('source_id', $externalJob->source_id)->first();
            if ($internalJob) {
                $internalJob->title = $externalJob->name;
                $internalJob->description = $externalJob->description;
                $internalJob->save();
                return;
            }

            $newJob = new Job;
            $newJob->title = $externalJob->title;
            $newJob->description = $externalJob->description;
            $newJob->created_at = $externalJob->created_at;
            $newJob->source = $externalJob->source;
            $newJob->source_id =  $externalJob->source_id;
            $newJob->save();

            $this->notifyModerators($newJob);
        }
    }
}