<?php

use CodeProject\Entities\User;
use CodeProject\Entities\Client;
use CodeProject\Entities\Project;

use CodeProject\Repositories\ProjectMemberRepository;

class ProjectMemberRepositoryEloquentTest extends TestCase
{
	public function testShouldListAllMembersOfProject()
	{
		$repository = App::make(ProjectMemberRepository::class);

		factory(User::class, 10)->create();
		factory(Client::class, 10)->create();
		
		$project = factory(Project::class)->create();

		$members = $repository->getMembers($project->id);

		$this->assertArrayHasKey('data', $members);
		$this->assertCount(0, $members['data']);
		
		$project->members()->attach(factory(User::class)->create()->id);
		$project->members()->attach(factory(User::class)->create()->id);
		$project->members()->attach(factory(User::class)->create()->id);
		$project->members()->attach(factory(User::class)->create()->id);

		$members = $repository->getMembers($project->id);

		$this->assertArrayHasKey('data', $members);
		$this->assertCount(4, $members['data']);
	}
}