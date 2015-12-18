<?php

use CodeProject\Entities\User;
use CodeProject\Entities\Client;
use CodeProject\Entities\Project;

use Illuminate\Foundation\Testing\WithoutMiddleware;

class ProjectTaskControllerTest extends TestCase
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

        $this->post("project/{$project->id}/task", $data)
            ->seeJson($data);

        $this->seeInDatabase('project_tasks', $data);
    }
}