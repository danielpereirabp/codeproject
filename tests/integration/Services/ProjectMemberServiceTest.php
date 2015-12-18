<?php

use CodeProject\Entities\User;
use CodeProject\Entities\Client;
use CodeProject\Entities\Project;

use CodeProject\Services\ProjectMemberService;

class ProjectMemberServiceTest extends TestCase
{
	public function testShouldAddOneProjectMember()
	{
		factory(User::class, 10)->create();
        factory(Client::class, 10)->create();

        $project = factory(Project::class)->create();
        $user = factory(User::class)->create();

		$service = App::make(ProjectMemberService::class);
		$response = $service->addMember(['project_id' => $project->id, 'user_id' => $user->id]);

		$this->assertArrayHasKey('success', $response);
		$this->assertTrue($response['success']);
	}

	public function testShouldTryRemoveAInvalidProjectMember()
	{
		factory(User::class, 10)->create();
        factory(Client::class, 10)->create();

        $project = factory(Project::class)->create();

		$service = App::make(ProjectMemberService::class);
		$response = $service->removeMember($project->id, 1);

		$this->assertArrayHasKey('success', $response);
		$this->assertFalse($response['success']);
	}

	public function testShouldRemoveOneProjectMember()
	{
		factory(User::class, 10)->create();
        factory(Client::class, 10)->create();

        $project = factory(Project::class)->create();

        $member = factory(User::class)->create();
		$project->members()->attach($member->id);

		$service = App::make(ProjectMemberService::class);
		$response = $service->removeMember($project->id, $member->id);

		$this->assertArrayHasKey('success', $response);
		$this->assertTrue($response['success']);
	}
}