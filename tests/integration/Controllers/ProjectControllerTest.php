<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;

// use LucaDegasperi\OAuth2Server\Storage\FluentAccessToken;
// use LucaDegasperi\OAuth2Server\Storage\FluentClient;
// use LucaDegasperi\OAuth2Server\Storage\FluentSession;
// use Mockery as m;

class ProjectControllerTest extends TestCase
{
    // use DatabaseMigrations;
    use WithoutMiddleware;

    protected $token;

    public function test_create_project()
    {
        $data = [
            'owner_id' => $this->createUser()->id,
            'client_id' => $this->createClient()->id,
            'name' => 'Projeto Teste',
            'progress' => 0,
            'status' => 3,
            'due_date' => date('Y-m-d')
        ];

        $this->post('/project', $data)
            ->seeJson([
                'data' => []
            ]);
    }

    public function test_update_project_partial_fields()
    {
        $project = $this->createProject();

        Authorizer::shouldReceive('getResourceOwnerId')->once()->andReturn($project->owner->id);

        $this->put('/project/1', ['name' => 'Faker Project Name Updated'])
            ->seeJson([
                'name' => 'Faker Project Name Updated'
            ]);
    }

    public function test_show_project()
    {
        $project = $this->createProject();

        Authorizer::shouldReceive('getResourceOwnerId')->once()->andReturn($project->owner->id);

        $this->put('/project/1', ['name' => 'Faker Project Name Updated'])
            ->seeJson([
                'name' => 'Faker Project Name Updated'
            ]);
    }

    public function createUser()
    {
        return factory(CodeProject\Entities\User::class)->create([
            'name' => 'Daniel Pereira',
            'email' => 'danielpereirabp@gmail.com',
            'password' => bcrypt(123456),
            'remember_token' => str_random(10)
        ]);
    }

    public function createClient()
    {
        return factory(CodeProject\Entities\Client::class)->create([
            'name' => 'Faker Name',
            'responsible' => 'Faker Responsible',
            'email' => 'faker@email.com',
            'phone' => '88 8888-8888',
            'address' => 'Faker Adress',
            'obs' => 'Faker Obs'
        ]);
    }

    public function createProject()
    {
        return factory(CodeProject\Entities\Project::class)->create([
            'owner_id' => $this->createUser()->id,
            'client_id' => $this->createClient()->id,
            'name' => 'Faker Project',
            'progress' => rand(0, 100),
            'status' => rand(1, 3),
            'due_date' => date('Y-m-d')
        ]);
    }
}
