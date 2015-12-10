<?php

use CodeProject\Entities\User;
use CodeProject\Entities\Client;
use CodeProject\Entities\Project;

use CodeProject\Services\ProjectService;

class ProjectServiceTest extends TestCase
{
	/**
    * @var Faker
    */
    private $faker;

    public function setUp()
    {
        parent::setUp();
        
        $this->faker = Faker\Factory::create();

    }
    
	public function testShouldListNoneProject()
	{
		$service = App::make(ProjectService::class);
		$response = $service->all();

		$this->assertEmpty($response['data']);
	}

	public function testShouldListAllProjects()
	{
		factory(User::class, 10)->create();
		factory(Client::class, 10)->create();
		factory(Project::class, 10)->create();

		$service = App::make(ProjectService::class);
		$response = $service->all();

		$this->assertCount(10, $response['data']);
	}

	public function testShouldNotShowAnyProjects()
	{
		$service = App::make(ProjectService::class);
		$response = $service->find(1);

		$this->assertArrayHasKey('error', $response);
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

		$service = App::make(ProjectService::class);
		$response = $service->find($project->id);

		$this->assertArrayHasKey('data', $response);
		$this->assertEquals($project->id, $response['data']['project_id']);
		$this->assertEquals($project->client_id, $response['data']['client_id']);
		$this->assertEquals($project->owner_id, $response['data']['owner_id']);
		$this->assertEquals($project->name, $response['data']['name']);
		$this->assertEquals($project->description, $response['data']['description']);
	}

	public function testShouldTryDeleteAInvalidProject()
	{
		$service = App::make(ProjectService::class);
		$response = $service->delete(1);

		$this->assertArrayHasKey('error', $response);
	}

	public function testShouldDeleteOneProject()
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

		$service = App::make(ProjectService::class);
		$response = $service->delete($project->id);

		$this->assertArrayHasKey('success', $response);
	}

	public function testShouldTryCreateAInvalidProject()
	{
		$data = [
			'name' => $this->faker->word,
            'progress' => 0,
            'status' => 3,
            'due_date' => date('Y-m-d')
		];

		$service = App::make(ProjectService::class);
		$response = $service->create($data);

		$this->assertArrayHasKey('error', $response);
	}

	public function testShouldCreateAProject()
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

		$service = App::make(ProjectService::class);
		$response = $service->create($data);

		$this->assertArrayHasKey('data', $response);
		$this->assertArrayHasKey('project_id', $response['data']);
	}

	public function testShouldTryUpdateAProjectWithInvalidData()
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

		$service = App::make(ProjectService::class);
		$response = $service->update(['owner_id' => 2], $project->id);

		$this->assertArrayHasKey('error', $response);
	}

	public function testShouldUpdateAProject()
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

		$service = App::make(ProjectService::class);
		$response = $service->update(['name' => 'name changed'], $project->id);

		$this->assertArrayHasKey('data', $response);
		$this->assertEquals('name changed', $response['data']['name']);
	}
}