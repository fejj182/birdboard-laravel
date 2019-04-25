<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Project;

class ManageProjectsTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    /** @test */
    public function a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $attributes = [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph
        ];

        $this->get('/projects/create')->assertSee('form');
        $this->post('/projects', $attributes)->assertRedirect('/projects');
        $this->assertDatabaseHas('projects', $attributes);
        $this->get('/projects')->assertSee($attributes['title']);
    }

    /** @test */
    public function a_user_can_view_their_project()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->user()->id]);

        $this->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

    /** @test */
    public function a_user_cannot_view_someone_elses_project()
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->get($project->path())
            ->assertForbidden();
    }

    /** @test */
    public function a_project_requires_a_title()
    {
        $this->signIn();

        $attributes = factory('App\Project')->raw(['title' => '']);

        $this->post('projects', $attributes)
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_project_requires_a_description()
    {
        $this->signIn();

        $attributes = factory('App\Project')->raw(['description' => '']);

        $this->post('projects', $attributes)
            ->assertSessionHasErrors('description');
    }

    /** @test */
    public function guests_cannot_manage_projects()
    {
        $project = factory(Project::class)->create();

        $this->post('projects', $project->toArray())
            ->assertRedirect('/login');

        $this->get('projects')
            ->assertRedirect('/login');

        $this->get('projects/create')
            ->assertRedirect('/login');

        $this->get($project->path())
            ->assertRedirect('/login');
    }
}
