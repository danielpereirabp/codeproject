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

        $task1 = App::make(ProjectTask::class);
        $task2 = App::make(ProjectTask::class);
        $task3 = App::make(ProjectTask::class);
        
        $project->tasks()->save($task1);
        $project->tasks()->save($task2);
        $project->tasks()->save($task3);

        $jsonResponse = $this->call('GET', "project/{$project->id}/task")->getContent();
        $responseData = json_decode($jsonResponse);

        $this->assertCount(3, $responseData->data);
    }

    public function testShouldRemoveOneTaskOfProject()
    {
        factory(User::class, 10)->create();
        factory(Client::class, 10)->create();

        $project = factory(Project::class)->create();

        $task1 = App::make(ProjectTask::class);
        $task2 = App::make(ProjectTask::class);
        $task3 = App::make(ProjectTask::class);
        
        $project->tasks()->save($task1);
        $project->tasks()->save($task2);
        $project->tasks()->save($task3);

        $this->delete("project/{$project->id}/task/{$task2->id}")
            ->seeJson([
                'success' => true
            ]);

        $this->seeInDatabase('project_tasks', ['id' => $task1->id]);
        $this->seeInDatabase('project_tasks', ['id' => $task3->id]);
        $this->notSeeInDatabase('project_tasks', ['id' => $task2->id]);
    }

    public function testShouldShowOneProjectTask()
    {
        factory(User::class, 10)->create();
        factory(Client::class, 10)->create();

        $project = factory(Project::class)->create();

        $task = App::make(ProjectTask::class);
        $task->name = $this->faker->word;
        
        $project->tasks()->save($task);

        $this->get("project/{$project->id}/task/{$task->id}")
            ->seeJson([
                'project_id' => "{$project->id}",
                'name' => "{$task->name}",
            ]);
    }
}