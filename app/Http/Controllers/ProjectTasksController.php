<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;
use App\Task;

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

    public function update(Project $project, Task $task)
    {
        request()->validate([
            'description' => 'required',
        ]);
        
        if (auth()->user()->isNot($project->owner)) {
            return abort(403);
        }

        $task->update([
            'description' => request('description'),
            'completed' => request()->has('completed')
        ]);

        return redirect($project->path());
    }
}
