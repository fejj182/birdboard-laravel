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
    public function guests_cannot_add_tasks_to_projects()
    {
        $project = factory(Project::class)->create();

        $this->post($project->path() . '/tasks')
            ->assertRedirect('/login');
    }

    /** @test */
    public function only_owners_of_a_project_can_add_a_task()
    {
        $this->signIn();
        $project = factory(Project::class)->create();

        $taskRaw = factory(Task::class)->raw();
        
        $this->post($project->path() . '/tasks', $taskRaw)
            ->assertForbidden();
        $this->assertDatabaseMissing('tasks', ['description' => $taskRaw['description']]);
    }
    
    

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
