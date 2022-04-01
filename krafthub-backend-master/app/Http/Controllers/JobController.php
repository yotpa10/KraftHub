<?php

namespace App\Http\Controllers;

use App\Models\Job;
use DB;

class JobController extends Controller
{
    public function getJobTypes() 
    {
        $jobTypes = Job::where('parent_id', null);
        
        return response([
            'results' => $jobTypes->get()->toArray()
        ], 200);
    }

    public function getJobByType($type) 
    {
        $jobTypes = Job::where('parent_id', $type);
        
        return response([
            'results' => $jobTypes->get()->toArray()
        ], 200);
    }
}
