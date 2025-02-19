<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmployerService;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\JobResource;

class EmployerController extends Controller
{
    public function __construct(
        private readonly EmployerService $employerService
    ) { }

    public function postJob(Request $request)
    {
        $requests = $request->all();
        $validator = Validator::make($requests, [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'contact_email' => 'required|string|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 400);
        }

        $job = $this->employerService->postJob($requests);
        return new JobResource($job);
    }
}
