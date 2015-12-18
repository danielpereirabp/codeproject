<?php

use CodeProject\Entities\User;
use CodeProject\Entities\Client;
use CodeProject\Entities\Project;

use CodeProject\Services\ProjectTaskService;

class ProjectTaskServiceTest extends TestCase
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

	public function testShouldAddOneTaskToTheProject()
    {
    	factory(User::class, 10)->create();
        factory(Client::class, 10)->create();

        $project = factory(Project::class)->create();

        $data = [
            'project_id' => $project->id,
            'name' => $this->faker->word,
            'start_date' => $this->faker->dateTime('now')->format('Y-m-d'),
	        'due_date' => $this->faker->dateTime('now')->format('Y-m-d'),
	        'status' => rand(1, 3)
        ];

        $service = App::make(ProjectTaskService::class);
		$response = $service->create($data);

		$this->assertArrayHasKey('data', $response);
		$this->assertArrayHasKey('project_id', $response['data']);
    }
}