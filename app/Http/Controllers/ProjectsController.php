<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Project;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->projects;

        return view('projects.index', compact('projects'));
    }

    public function show(Project $project)
    {
        if (auth()->user()->isNot($project->owner)) {
            return abort(403);
        }
        
        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');   
    }

    public function store()
    {
        // validate
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $attributes['owner_id'] = auth()->id();

        // persist
        $project = auth()->user()->projects()->create($attributes);

        // redirect
        return redirect($project->path());
    }
}
