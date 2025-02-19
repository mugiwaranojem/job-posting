<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Job;
use SimpleXMLElement;
use Illuminate\Support\Facades\Log;

class JobService
{
    public const EXTERNAL_API_JOB = 'https://mrge-group-gmbh.jobs.personio.de/xml';

    public function getJobPosts()
    {
        $jobs = Job::orderBy('created_at', 'desc')->paginate(10);

        // Fetch external jobs (XML format)
        $externalJobs = $this->fetchExternalJobs();

        $mergedJobs = $externalJobs->merge(collect($jobs->items()));

        return $mergedJobs;

    }

    /**
     * Fetch external jobs from API and convert XML Object to Job Collection.
     */
    private function fetchExternalJobs()
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
                    $descriptions = '<h3>'.(string) $jd->name.'<h3>';
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
}