<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ProcessSubmission;

class SubmissionController extends Controller
{
    public function submit(Request $request)
    {
        // Validate the incoming JSON payload
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'required|string',
        ]);

        // Dispatch a job to process the submission
        ProcessSubmission::dispatch($request->only(['name', 'email', 'message']))
            ->onQueue('submissions'); // Optional: Assign the job to a specific queue

        // Return a success response
        return response()->json(['message' => 'Submission received.'], 200);
    }
}
