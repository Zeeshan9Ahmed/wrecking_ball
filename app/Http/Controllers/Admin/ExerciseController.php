<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exercise;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function exercises()
	{
		$exercises = Exercise::get();
		return view('admin.exercises.index', compact('exercises'));
	}

	public function createExercise()
	{
		return view('admin.exercises.create');
	}

	public function storeExercise(Request $request)
	{
        $exercise = Exercise::create([
            'title' => $request->title,
            'description' => $request->description,
            'duration' => $request->duration,
            'no_of_days_per_week' => $request->no_of_days_per_week,
          
        ]);
        return redirect()->back()->withSuccess('Exercise Created!');
	}
}
