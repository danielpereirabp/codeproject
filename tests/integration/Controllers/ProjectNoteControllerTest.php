<?php

use CodeProject\Entities\User;
use CodeProject\Entities\Client;
use CodeProject\Entities\Project;
use CodeProject\Entities\ProjectNote;

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
        factory(User::class, 10)->create();
        factory(Client::class, 10)->create();

        $project = factory(Project::class)->create();

        $note1 = App::make(ProjectNote::class);
        $note2 = App::make(ProjectNote::class);
        $note3 = App::make(ProjectNote::class);
        
        $project->notes()->save($note1);
        $project->notes()->save($note2);
        $project->notes()->save($note3);

        $jsonResponse = $this->call('GET', "project/{$project->id}/note")->getContent();
        $responseData = json_decode($jsonResponse);

        $this->assertCount(3, $responseData->data);
    }

    public function testShouldRemoveOneNoteOfProject()
    {
        factory(User::class, 10)->create();
        factory(Client::class, 10)->create();

        $project = factory(Project::class)->create();

        $note1 = App::make(ProjectNote::class);
        $note2 = App::make(ProjectNote::class);
        $note3 = App::make(ProjectNote::class);
        
        $project->notes()->save($note1);
        $project->notes()->save($note2);
        $project->notes()->save($note3);

        $this->delete("project/{$project->id}/note/{$note2->id}")
            ->seeJson([
                'success' => true
            ]);

        $this->seeInDatabase('project_notes', ['id' => $note1->id]);
        $this->seeInDatabase('project_notes', ['id' => $note3->id]);
        $this->notSeeInDatabase('project_notes', ['id' => $note2->id]);
    }

    public function testShouldShowOneProjectNote()
    {
        factory(User::class, 10)->create();
        factory(Client::class, 10)->create();

        $project = factory(Project::class)->create();

        $note = App::make(ProjectNote::class);
        $note->title = $this->faker->word;
        
        $project->notes()->save($note);

        $this->get("project/{$project->id}/note/{$note->id}")
            ->seeJson([
                'project_id' => "{$project->id}",
                'title' => "{$note->title}",
            ]);
    }
}