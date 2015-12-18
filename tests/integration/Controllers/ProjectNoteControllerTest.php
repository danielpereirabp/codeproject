<?php

use CodeProject\Entities\User;
use CodeProject\Entities\Client;
use CodeProject\Entities\Project;

use Illuminate\Foundation\Testing\WithoutMiddleware;

class ProjectNoteControllerTest extends TestCase
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

    public function testShouldAddOneNoteToTheProject()
    {
    	factory(User::class, 10)->create();
        factory(Client::class, 10)->create();

        $project = factory(Project::class)->create();

        $data = [
            'project_id' => $project->id,
            'title' => $this->faker->word,
            'note' => $this->faker->paragraph
        ];

        $this->post("project/{$project->id}/note", $data)
            ->seeJson($data);

        $this->seeInDatabase('project_notes', $data);
    }

    public function testShouldListAllNotesOfProject()
    {
        //
    }

    public function testShouldRemoveOneNoteOfProject()
    {
        //
    }
}