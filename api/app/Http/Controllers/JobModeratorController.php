<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\JobModeratorService;

class JobModeratorController extends Controller
{
    public function __construct(
        private readonly JobModeratorService $jobModeratorService
    ) { }
}
