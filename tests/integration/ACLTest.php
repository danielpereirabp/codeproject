<?php

use CodeProject\Entities\User;
use CodeProject\Entities\Client;
use CodeProject\Entities\Project;
use CodeProject\Entities\ProjectNote;

class ACLTest extends TestCase
{
	/**
    * @var Faker
    */
    private $faker;

	private $user;

	private $token;

	private $header;

	public function setUp()
	{
		parent::setUp();

		$this->faker = Faker\Factory::create();

		$this->generateAccessToken();
	}

	public function testProjectControllerUnauthenticated()
	{
		$this->get('project')->seeJson(['error' => 'invalid_request']);
		$this->post('project', [])->seeJson(['error' => 'invalid_request']);
		$this->get('project/1')->seeJson(['error' => 'invalid_request']);
		$this->put('project/1', [])->seeJson(['error' => 'invalid_request']);
		$this->delete('project/1')->seeJson(['error' => 'invalid_request']);
	}

	public function testProjectControllerAuthenticatedAsProjectOwner()
	{
		$client = factory(Client::class)->create();

        $data = [
			'owner_id'  => $this->user->id,
			'client_id' => $client->id,
			'name'      => $this->faker->word,
			'progress'  => 0,
			'status'    => 3,
			'due_date'  => date('Y-m-d')
        ];

        $project = factory(Project::class)->create($data);

		$this->get('project', $this->header)->seeJson(['project_id' => "{$project->id}"]);
		$this->post('project', [], $this->header)->seeJson(['error' => true]);
		$this->get("project/{$project->id}", $this->header)->seeJson(['project_id' => "{$project->id}"]);
		$this->put("project/{$project->id}", [], $this->header)->seeJson(['project_id' => "{$project->id}"]);
		$this->delete("project/{$project->id}", [], $this->header)->seeJson(['success' => true]);
	}

	public function testProjectControllerAuthenticatedAsProjectMember()
	{
		$owner = factory(User::class)->create();
        $client = factory(Client::class)->create();

        $data = [
			'owner_id'  => $owner->id,
			'client_id' => $client->id,
			'name'      => $this->faker->word,
			'progress'  => 0,
			'status'    => 3,
			'due_date'  => date('Y-m-d')
        ];

        $project = factory(Project::class)->create($data);
        $project->members()->save($this->user);

		$this->get('project', $this->header)->seeJson(['project_id' => "{$project->id}"]);
		$this->post('project', [], $this->header)->seeJson(['error' => true]);
		$this->get("project/{$project->id}", $this->header)->seeJson(['project_id' => "{$project->id}"]);
		$this->put("project/{$project->id}", [], $this->header)->seeJson(['error' => 'Access forbidden']);
		$this->delete("project/{$project->id}", [], $this->header)->seeJson(['error' => 'Access forbidden']);
	}

	public function testProjectControllerWithoutPermissions()
	{
		//
	}

	public function testProjectNoteControllerUnauthenticated()
	{
		$this->get('project/1/note')->seeJson(['error' => 'invalid_request']);
		$this->post('project/1/note', [])->seeJson(['error' => 'invalid_request']);
		$this->get('project/1/note/1')->seeJson(['error' => 'invalid_request']);
		$this->put('project/1/note/1', [])->seeJson(['error' => 'invalid_request']);
		$this->delete('project/1/note/1')->seeJson(['error' => 'invalid_request']);
	}

	public function testProjectNoteControllerAuthenticatedAsProjectOwner()
	{
		//
	}

	public function testProjectNoteControllerAuthenticatedAsProjectMember()
	{
		factory(User::class, 10)->create();
        factory(Client::class, 10)->create();

        $project = factory(Project::class)->create();
        $project->members()->save($this->user);

        $data = [
			'project_id' => $project->id,
	        'title' => $this->faker->word,
	        'note' => $this->faker->paragraph
        ];

        $note = factory(ProjectNote::class)->create($data);

		$this->get("project/{$project->id}/note", $this->header)->seeJson(['project_id' => "{$project->id}"]);
		$this->post("project/{$project->id}/note", $data, $this->header)->seeJson(['project_id' => $project->id]);
		$this->get("project/{$project->id}/note/{$note->id}", $this->header)->seeJson(['project_id' => "{$project->id}"]);
		$this->put("project/{$project->id}/note/{$note->id}", [], $this->header)->seeJson(['project_id' => "{$project->id}"]);
		$this->delete("project/{$project->id}/note/{$note->id}", [], $this->header)->seeJson(['success' => true]);
	}

	public function testProjectNoteControllerWithoutPermissions()
	{
		factory(User::class, 10)->create();
        factory(Client::class, 10)->create();

        $project = factory(Project::class)->create();

        $data = [
			'project_id' => $project->id,
	        'title' => $this->faker->word,
	        'note' => $this->faker->paragraph
        ];

        $note = factory(ProjectNote::class)->create($data);

		$this->get("project/{$project->id}/note", $this->header)->seeJson(['project_id' => "{$project->id}"]);
		$this->post("project/{$project->id}/note", $data, $this->header)->seeJson(['error' => 'Access forbidden']);
		$this->get("project/{$project->id}/note/{$note->id}", $this->header)->seeJson(['project_id' => "{$project->id}"]);
		$this->put("project/{$project->id}/note/{$note->id}", [], $this->header)->seeJson(['error' => 'Access forbidden']);
		$this->delete("project/{$project->id}/note/{$note->id}", [], $this->header)->seeJson(['error' => 'Access forbidden']);
	}

	public function testProjectTaskControllerUnauthenticated()
	{
		$this->get('project/1/task')->seeJson(['error' => 'invalid_request']);
		$this->post('project/1/task', [])->seeJson(['error' => 'invalid_request']);
		$this->get('project/1/task/1')->seeJson(['error' => 'invalid_request']);
		$this->put('project/1/task/1', [])->seeJson(['error' => 'invalid_request']);
		$this->delete('project/1/task/1')->seeJson(['error' => 'invalid_request']);
	}

	public function testProjectTaskControllerAuthenticatedAsProjectOwner()
	{
		//
	}

	public function testProjectTaskControllerAuthenticatedAsProjectMember()
	{
		//
	}

	public function testProjectTaskControllerWithoutPermissions()
	{
		//
	}

	public function testProjectFileControllerUnauthenticated()
	{
		$this->get('project/1/file')->seeJson(['error' => 'invalid_request']);
		$this->post('project/1/file', [])->seeJson(['error' => 'invalid_request']);
		$this->delete('project/1/file/1')->seeJson(['error' => 'invalid_request']);
	}

	public function testProjectFileControllerAuthenticatedAsProjectOwner()
	{
		//
	}

	public function testProjectFileControllerAuthenticatedAsProjectMember()
	{
		//
	}

	public function testProjectFileControllerWithoutPermissions()
	{
		//
	}

	public function testProjectMemberControllerUnauthenticated()
	{
		$this->get('project/1/member')->seeJson(['error' => 'invalid_request']);
		$this->post('project/1/member', [])->seeJson(['error' => 'invalid_request']);
		$this->delete('project/1/member/1')->seeJson(['error' => 'invalid_request']);
	}

	public function testProjectMemberControllerAuthenticatedAsProjectOwner()
	{
		//
	}

	public function testProjectMemberControllerAuthenticatedAsProjectMember()
	{
		//
	}

	public function testProjectMemberControllerWithoutPermissions()
	{
		//
	}

	public function generateAccessToken()
	{
		DB::table('oauth_clients')->insert([
            'id' => 'appid1',
            'secret' => 'secret',
            'name' => 'APP AngularJS'
        ]);

        $user = factory(CodeProject\Entities\User::class)->create([
            'name' => 'Daniel Pereira',
            'email' => 'danielpereirabp@gmail.com',
            'password' => bcrypt(123456),
            'remember_token' => str_random(10)
        ]);

        $data = [
        	'username' => 'danielpereirabp@gmail.com',
            'password' => '123456',
            'client_id' => 'appid1',
            'client_secret' => 'secret',
            'grant_type' => 'password'
        ];

		$jsonResponse = $this->call('POST', 'oauth/access_token', $data)->getContent();
        $responseData = json_decode($jsonResponse);

        $this->user = $user;
        $this->token = $responseData;
        $this->header = ['Authorization' => 'Bearer ' . $responseData->access_token];
	}
}