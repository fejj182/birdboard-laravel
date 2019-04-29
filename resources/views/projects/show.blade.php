@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3 py-4">
        <div class="flex justify-between w-full items-end">
            <p class="text-grey-dark text-base font-normal">
                <a href="/projects" class="text-grey-dark text-base font-normal no-underline">My Projects</a>
                 / {{ $project->title }}
            </p>
            <a href="/projects/create" class="button">New project</a>
        </div>
    </header>

    <main>
        <div class="lg:flex -m-3">
            <div class="lg:w-3/4 px-3 pb-6">
                <div class="mb-8">
                    <h2 class="text-lg text-grey-dark font-normal mb-3">Tasks</h2>
                    @foreach ($project->tasks as $task)
                        <div class="card mb-3">
                            <form action="{{$task->path()}}" method="POST" class="flex">
                                @method('PATCH')
                                @csrf
                                <input value="{{ $task->description }}" name="description" class="w-full {{ $task->completed ? 'text-grey' : '' }}">
                                <input type="checkbox" name="completed" onChange="this.form.submit()" {{ $task->completed ? 'checked' : ''}}>
                            </form>
                        </div>    
                    @endforeach
                    <div class="card mb-3">
                        <form action="{{$project->path() . '/tasks'}}" method="POST">
                            @csrf
                            <input placeholder="Add a new task..." class="w-full" name="description">
                        </form>
                    </div>
                </div>

                <div>
                    <h2 class="text-lg text-grey-dark font-normal mb-3">General Notes</h2>
                    <textarea class="card w-full" style="min-height: 200px;">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nihil, dicta, illum in ipsa, sit distinctio fugit cupiditate perspiciatis eveniet aut esse corporis sunt dolorem deserunt non. Maiores quam adipisci tempore!</textarea>
                </div>
            </div>
            <div class="lg:w-1/4 px-3">
                @include('projects.card')
            </div>
        </div>
    </main>
@endsection