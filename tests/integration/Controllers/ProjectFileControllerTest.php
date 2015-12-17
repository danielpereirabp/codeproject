<?php

use CodeProject\Entities\User;
use CodeProject\Entities\Client;
use CodeProject\Entities\Project;
use CodeProject\Entities\ProjectFile;

use CodeProject\Services\ProjectFileService;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\File\UploadedFile;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;

// use Mockery as m;

class ProjectFileControllerTest extends TestCase
{
    use WithoutMiddleware;

    public function setUp()
    {
        parent::setUp();

        factory(User::class, 10)->create();
        factory(Client::class, 10)->create();
    }

    // public function tearDown()
    // {
    //     m::close();

    //     parent::tearDown();
    // }

    public function testData()
    {
        $jpgPath = base_path() . '/tests/data/tdd.jpg';
        $this->assertTrue(file_exists($jpgPath), 'Test file does not exist');

        $pdfPath = base_path() . '/tests/data/blank.pdf';
        $this->assertTrue(file_exists($pdfPath), 'Test file does not exist');

        return [
            'jpg' => $jpgPath,
            'pdf' => $pdfPath
        ];
    }

    /**
     * @depends testData
     */
    public function testStore(array $path)
    {
        // $service      = m::mock(ProjectFileService::class);
        // $request      = m::mock(Request::class);
        // $uploadedFile = m::mock(UploadedFile::class);

        // $uploadedFile->shouldReceive('getClientOriginalExtension')->andReturn('jpg');

        // $request->shouldReceive('all');
        // $request->shouldReceive('file')->andReturn($uploadedFile);
        // $request->shouldReceive('getAttribute')->with('name')->andReturn('file-name');
        // $request->shouldReceive('getAttribute')->with('description')->andReturn('file description');
        // $request->shouldReceive('getAttribute')->with('project_id')->andReturn(1);

        // $service->shouldReceive('createFile')->withAnyArgs()->andReturn(true);

        // App::instance(ProjectFileService::class, $service);

        // $controller = App::make(ProjectFileController::class);

        // $this->assertTrue(
        //     $controller->store($request)
        // );

        // dd(base_path());

        // $uploadedFile = m::mock(UploadedFile::class);

        // $uploadedFile->shouldReceive('getClientOriginalExtension')->andReturn('jpg');

        // $response = $this->action(
        //         'POST',
        //         'ProjectFileController@store',
        //         [],
        //         ['name' => 'File Name', 'description' => 'File Description', 'project_id' => 1],
        //         ['file' => [$uploadedFile]]
        //     );

        $project = factory(Project::class)->create();
        $uploadedFile = new UploadedFile($path['jpg'], 'original-file-name.jpg', 'image/jpeg');

        $data = [
            'name' => 'File Name',
            'description' => 'File Description',
            'project_id' => $project->id
        ];

        $this->action(
                'POST',
                'ProjectFileController@store',
                [],
                $data,
                [],
                ['file' => $uploadedFile]
            );

        $this->seeJson([
                'success' => true
            ]);

        $this->seeInDatabase('project_files', $data);
        $this->assertFileExists( storage_path("app/1.jpg") );

        $project = factory(Project::class)->create();
        $uploadedFile = new UploadedFile($path['pdf'], 'original-file-name.pdf', 'application/pdf');

        $data = [
            'name' => 'File Name',
            'description' => 'File Description',
            'project_id' => $project->id
        ];

        $this->call(
                'POST',
                "project/{$project->id}/file",
                $data,
                [],
                ['file' => $uploadedFile]
            );
            
        $this->seeJson([
                'success' => true
            ]);

        $this->seeInDatabase('project_files', $data);
        $this->assertFileExists( storage_path("app/2.pdf") );
    }

    public function testDestroy()
    {
        $filesystem = App::make(FileSystem::class);
        $storage = App::make(Storage::class);

        $project = factory(Project::class)->create();

        $uploadedFile = new UploadedFile(base_path().'/tests/data/tdd.jpg', 'test-destroy.jpg', 'image/jpeg');
        $storage->put("{$project->id}.jpg", $filesystem->get($uploadedFile)); 

        $projectFile = factory(ProjectFile::class)->create([
            'project_id' => $project->id,
            'name' => 'test destroy',
            'description' => 'test to destroy file',
            'extension' => $uploadedFile->getClientOriginalExtension()
        ]);

        $this
            ->delete("project/{$project->id}/file/{$projectFile->id}")
            ->seeJson([
                'success' => true
            ]);

        $this->notSeeInDatabase('project_files', ['id' => $projectFile->id]);
        $this->assertFileNotExists( storage_path("app/{$projectFile->id}.{$uploadedFile->getClientOriginalExtension()}") );
    }
}