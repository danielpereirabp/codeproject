<?php

use CodeProject\Entities\User;
use CodeProject\Entities\Client;
use CodeProject\Entities\Project;

use Illuminate\Foundation\Testing\WithoutMiddleware;

// use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class ProjectControllerTest extends TestCase
{
    use WithoutMiddleware;

    /**
    * @var Faker
    */
    private $faker;

    public function setUp()
    {
        parent::setUp();
        
        $this->faker = Faker\Factory::create();

    }

    public function testShouldCreateOneProject()
    {
        $user = factory(User::class)->create();
        $client = factory(Client::class)->create();

        $data = [
            'owner_id' => $user->id,
            'client_id' => $client->id,
            'name' => $this->faker->word,
            'progress' => 0,
            'status' => 3,
            'due_date' => date('Y-m-d')
        ];

        $this->post('/project', $data)
            ->seeJson([
                'data' => []
            ]);
    }

    /**
     * @dataProvider getProjectFields
     */
    public function testShouldUpdateAProjectWithPartialFields($field, $expected)
    {
        $user = factory(User::class)->create();
        $client = factory(Client::class)->create();

        $project = factory(Project::class)->create([
            'owner_id' => $user->id,
            'client_id' => $client->id,
            'name' => $this->faker->word,
            'progress' => 0,
            'status' => 3,
            'due_date' => date('Y-m-d')
        ]);

        //Authorizer::shouldReceive('getResourceOwnerId')->once()->andReturn($project->owner->id);

        $this->put('/project/1', [$field => $expected])
            ->seeJson([
                $field => $expected
            ]);
    }

    public function testShouldShowOneProject()
    {
        $user = factory(User::class)->create();
        $client = factory(Client::class)->create();

        $project = factory(Project::class)->create([
            'owner_id' => $user->id,
            'client_id' => $client->id,
            'name' => $this->faker->word,
            'progress' => 0,
            'status' => 3,
            'due_date' => date('Y-m-d')
        ]);

        //Authorizer::shouldReceive('getResourceOwnerId')->once()->andReturn($project->owner->id);

        $this->put('/project/1', ['name' => 'Faker Project Name Updated'])
            ->seeJson([
                'name' => 'Faker Project Name Updated'
            ]);
    }

    public function getProjectFields()
    {
        return [
            ['name', 'Faker Project Name Updated'],
            ['description', 'Faker Description']
        ];
    }
}
