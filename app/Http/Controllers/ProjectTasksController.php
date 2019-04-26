<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectTasksController extends Controller
{
    public function store(Project $project)
    {
        request()->validate([
            'description' => 'required',
        ]);

        if (auth()->user()->isNot($project->owner)) {
            return abort(403);
        }
        
        $project->addTask(request('description'));
        return redirect($project->path());
        
    }
}
