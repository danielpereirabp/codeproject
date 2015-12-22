<?php

use CodeProject\Entities\User;
use CodeProject\Entities\Client;
use CodeProject\Entities\Project;
use CodeProject\Entities\ProjectMember;
use CodeProject\Entities\ProjectFile;
use CodeProject\Entities\ProjectTask;
use CodeProject\Entities\ProjectNote;

use Illuminate\Foundation\Testing\WithoutMiddleware;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;

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

    public function testShouldListAllProjects()
    {
        factory(User::class, 10)->create();
        factory(Client::class, 10)->create();

        $project1 = factory(Project::class)->create();
        $project2 = factory(Project::class)->create();
        $project3 = factory(Project::class)->create();

        $jsonResponse = $this->call('GET', 'project')->getContent();
        $responseData = json_decode($jsonResponse);

        $this->assertCount(3, $responseData->data);

        $this->seeInDatabase('projects', ['id' => $project1->id]);
        $this->seeInDatabase('projects', ['id' => $project2->id]);
        $this->seeInDatabase('projects', ['id' => $project3->id]);
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

        $this->post('project', $data)
            ->seeJson($data);

        $this->seeInDatabase('projects', $data);
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

        $this->put('project/1', [$field => $expected])
            ->seeJson([
                $field => $expected
            ]);
    }

    public function testShouldShowOneProject()
    {
        factory(User::class, 10)->create();
        factory(Client::class, 10)->create();

        $project = factory(Project::class)->create();

        $this->get("project/{$project->id}")
            ->seeJson([
                'data' => []
            ]);

        $this->seeInDatabase('projects', ['id' => $project->id]);
    }

    public function testShouldDestroyOneProject()
    {
        factory(User::class, 10)->create();
        factory(Client::class, 10)->create();

        $project = factory(Project::class)->create();

        $this->delete("project/{$project->id}")
            ->seeJson([
                'success' => true
            ]);

        $this->notSeeInDatabase('projects', ['id' => $project->id]);
    }

    /**
     * @group project-member
     */
    public function testShouldDestroyOneProjectWithMembers()
    {
        factory(User::class, 10)->create();
        factory(Client::class, 10)->create();

        $member = factory(User::class)->make();

        $project = factory(Project::class)->create();
        $project->members()->save($member);

        // $this->delete("project/{$project->id}")
        //     ->seeJson([
        //         'success' => true
        //     ]);

        // $this->notSeeInDatabase('projects', ['id' => $project->id]);
    }

    /**
     * @group project-file
     */
    public function testShouldDestroyOneProjectWithFiles()
    {
        $filesystem = App::make(FileSystem::class);
        $storage = App::make(Storage::class);

        factory(User::class, 10)->create();
        factory(Client::class, 10)->create();

        $project = factory(Project::class)->create();

        $uploadedFile = new UploadedFile(base_path().'/tests/data/tdd.jpg', 'test-destroy.jpg', 'image/jpeg');
        $storage->put("{$project->id}.jpg", $filesystem->get($uploadedFile)); 

        $projectFile = factory(ProjectFile::class)->create([
            'project_id' => $project->id,
            'name' => 'test destroy',
            'description' => 'test to destroy file',
            'extension' => $uploadedFile->getClientOriginalExtension()
        ]);

        // $this->delete("project/{$project->id}")
        //     ->seeJson([
        //         'success' => true
        //     ]);

        // $this->notSeeInDatabase('projects', ['id' => $project->id]);
    }

    /**
     * @group project-task
     */
    public function testShouldDestroyOneProjectWithTasks()
    {
        //
    }

    /**
     * @group project-note
     */
    public function testShouldDestroyOneProjectWithNotes()
    {
        //
    }

    /**
     * @group project
     */
    public function testShouldDestroyOneProjectWithMembersAndFilesAndTasksAndNotes()
    {
        //
    }

    public function getProjectFields()
    {
        return [
            ['name', 'Faker Project Name Updated'],
            ['description', 'Faker Description']
        ];
    }
}
