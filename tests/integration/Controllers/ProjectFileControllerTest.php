<?php

use CodeProject\Entities\User;
use CodeProject\Entities\Client;
use CodeProject\Entities\Project;

use CodeProject\Services\ProjectFileService;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\File\UploadedFile;

// use Mockery as m;

class ProjectFileControllerTest extends TestCase
{
  use WithoutMiddleware;

	// public function tearDown()
 //  {
 //      m::close();
 //  }

    /**
     * @group project-file
     */
    public function testStore()
    {
		// $service      = m::mock(ProjectFileService::class);
		// $request      = m::mock(Request::class);
		// $uploadedFile = m::mock(UploadedFile::class);

  //   	$uploadedFile->shouldReceive('getClientOriginalExtension')->andReturn('jpg');

  //   	$request->shouldReceive('all');
  //   	$request->shouldReceive('file')->andReturn($uploadedFile);
  //   	$request->shouldReceive('getAttribute')->with('name')->andReturn('file-name');
  //   	$request->shouldReceive('getAttribute')->with('description')->andReturn('file description');
  //   	$request->shouldReceive('getAttribute')->with('project_id')->andReturn(1);

  //   	$service->shouldReceive('createFile')->withAnyArgs()->andReturn(true);

  //   	App::instance(ProjectFileService::class, $service);
    	
  //   	$controller = App::make(ProjectFileController::class);

  //   	$this->assertTrue(
  //   		$controller->store($request)
  //   	);

     //  dd(base_path());

    	// $uploadedFile = m::mock(UploadedFile::class);

     //  $uploadedFile->shouldReceive('getClientOriginalExtension')->andReturn('jpg');

    	// $response = $this->action(
	    //     'POST',
	    //     'ProjectFileController@store',
	    //     [],
	    //     ['name' => 'File Name', 'description' => 'File Description', 'project_id' => 1],
	    //     ['file' => [$uploadedFile]]
	    // );

      $filePath = base_path() . '/tests/data/tdd.jpg';
      $this->assertTrue(file_exists($filePath), 'Test file does not exist');

      factory(User::class, 10)->create();
      factory(Client::class, 10)->create();
      $project = factory(Project::class)->create();

      $uploadedFile = new UploadedFile($filePath, 'original-file-name.jpg', 'image/jpeg');

      $response = $this->action(
          'POST',
          'ProjectFileController@store',
          [],
          ['name' => 'File Name', 'description' => 'File Description', 'project_id' => $project->id],
          [],
          ['file' => $uploadedFile]
      );

      // dd($response->response);

      // $this->assertTrue($response['success']);
    }
}