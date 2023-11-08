<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExerciseController extends Controller
{
    use ApiResponser;
    public function exercises()
    {
        $exercises = Exercise::latest()->get(['id','name']);
        return $this->success('Exercises.', $exercises);
    }
    public function updateViewExerciseCount($exercise_id)
    {
        Exercise::whereId($exercise_id)->update([
            'view_count' => DB::raw('view_count+1')
        ]);
        return $this->success("Success.");
    }

    
}
