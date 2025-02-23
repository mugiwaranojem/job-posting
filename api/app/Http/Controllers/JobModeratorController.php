<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JobModeratorService;
use App\Models\UrlVerification;
use App\Http\Resources\JobResource;

class JobModeratorController extends Controller
{
    public function __construct(
        private readonly JobModeratorService $jobModeratorService
    ) { }

    public function syncJobs()
    {
        $this->jobModeratorService->syncExternalJobs();
        return response()->json([
            'success' => true
        ]);
    }

    public function approveJobPost(string $token)
    {
        $verification = UrlVerification::where('token', $token)
            ->where('expiry', '>', now())->first();

        if (!$verification) {
            return response()->json(['message' => 'Invalid token'], 404);
        }

        $job = $this->jobModeratorService->approveJob($verification->source_id);
        return redirect('http://localhost:5173')->with('success', 'Job approved successfully!');
    }

    public function markSpamJobPost(string $token)
    {
        $verification = UrlVerification::where('token', $token)
            ->where('expiry', '>', now())->first();

        if (!$verification) {
            return response()->json(['message' => 'Invalid token'], 404);
        }

        $job = $this->jobModeratorService->markAsSpam($verification->source_id);
        return redirect('http://localhost:5173')->with('success', 'Job marked as spam successfully!');
    }
}
