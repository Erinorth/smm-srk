<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JobPosition;
use Illuminate\Http\Request;

class JobPositionController extends Controller
{
    public function manhour()
    {
        $jobposition = JobPosition::whereIn('id',[1,2,3,4,5,6,7,8,9])->get();

        return response()->json($jobposition);
    }
}
