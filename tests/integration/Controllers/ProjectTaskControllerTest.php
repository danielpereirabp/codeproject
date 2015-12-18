<?php

use CodeProject\Entities\User;
use CodeProject\Entities\Client;
use CodeProject\Entities\Project;
use CodeProject\Entities\ProjectTask;

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

    public function testShouldAddOneTaskInTheProject()
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

    public function testShouldListAllTasksOfProject()
    {
        factory(User::class, 10)->create();
        factory(Client::class, 10)->create();

        $project = factory(Project::class)->create();

        $task1 = factory(ProjectTask::class)->make();
        $task2 = factory(ProjectTask::class)->make();
        $task3 = factory(ProjectTask::class)->make();
        
        $project->tasks()->save($task1);
        $project->tasks()->save($task2);
        $project->tasks()->save($task3);

        // $this->get("project/{$project->id}/task")
        //     ->seeJson([
        //         'data' => []
        //     ]);

        // $this->seeInDatabase('project_tasks', $data);
        // $this->seeInDatabase('project_tasks', $data);
        // $this->seeInDatabase('project_tasks', $data);
    }

    public function testShouldRemoveOneTaskOfProject()
    {
        //
    }
}