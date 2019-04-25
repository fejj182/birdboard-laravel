<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;
use App\Task;

class ProjectTasksTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->signIn();
        $this->withoutExceptionHandling();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);
        $taskDescription = $this->faker->paragraph;
        $this->post($project->path() . '/tasks', ['description' => $taskDescription]);
        $this->get($project->path())
            ->assertSee($taskDescription);
    }

    /** @test */
    public function a_task_requires_a_description()
    {
        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);
        $this->post($project->path() . '/tasks', factory(Task::class)->raw(['description' => '']))
            ->assertSessionHasErrors('description');;

    }
    
    
}
