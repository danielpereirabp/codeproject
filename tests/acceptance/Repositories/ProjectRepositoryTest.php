<?php

use CodeProject\Entities\User;
use CodeProject\Entities\Client;
use CodeProject\Entities\Project;

use CodeProject\Repositories\ProjectRepository;

class ProjectRepositoryTest extends TestCase
{
	/**
    * @var Faker
    */
    private $faker;

    public function setUp()
    {
        parent::setUp();
        
        $this->faker = Faker\Factory::create();

    }

	public function testShouldCheckIfIsOwner()
	{
		$owner = factory(User::class)->create();
		$client = factory(Client::class)->create();
		
		$project = factory(Project::class)->create([
			'owner_id' => $owner->id,
            'client_id' => $client->id,
            'name' => $this->faker->word,
            'progress' => 0,
            'status' => 3,
            'due_date' => date('Y-m-d')
		]);

		$repository = App::make(ProjectRepository::class);
		$isOwner = $repository->isOwner($project->id, $owner->id);

		$this->assertTrue($isOwner);
	}

	public function testShouldCheckIfIsNotOwner()
	{
		$notOwner = factory(User::class)->create();
		$owner = factory(User::class)->create();
		$client = factory(Client::class)->create();
		
		$project = factory(Project::class)->create([
			'owner_id' => $owner->id,
            'client_id' => $client->id,
            'name' => $this->faker->word,
            'progress' => 0,
            'status' => 3,
            'due_date' => date('Y-m-d')
		]);

		$repository = App::make(ProjectRepository::class);
		$isOwner = $repository->isOwner($project->id, $notOwner->id);

		$this->assertFalse($isOwner);
	}

	public function testShouldCheckIfIsMember()
	{
		$owner = factory(User::class)->create();
		$client = factory(Client::class)->create();
		
		$project = factory(Project::class)->create([
			'owner_id' => $owner->id,
            'client_id' => $client->id,
            'name' => $this->faker->word,
            'progress' => 0,
            'status' => 3,
            'due_date' => date('Y-m-d')
		]);

		$user = factory(CodeProject\Entities\User::class)->create();
		$project->members()->attach($user->id);

		$repository = App::make(ProjectRepository::class);
		$isMember = $repository->isMember($project->id, $user->id);

		$this->assertTrue($isMember);
	}

	public function testShouldCheckIfIsNotMember()
	{
		$owner = factory(User::class)->create();
		$client = factory(Client::class)->create();
		
		$project = factory(Project::class)->create([
			'owner_id' => $owner->id,
            'client_id' => $client->id,
            'name' => $this->faker->word,
            'progress' => 0,
            'status' => 3,
            'due_date' => date('Y-m-d')
		]);

		$notMember = factory(User::class)->create();

		$repository = App::make(ProjectRepository::class);
		$isMember = $repository->isMember($project->id, $notMember->id);

		$this->assertFalse($isMember);

		$user = factory(User::class)->create();
		$project->members()->attach($user->id);

		$isMember = $repository->isMember($project->id, $notMember->id);

		$this->assertFalse($isMember);
	}

	/**
     * @group repository
     */
	public function testShouldListAllProjectMembers()
	{
		//
	}

	/**
     * @group repository
     */
	public function testShouldShowAProjectMember()
	{
		//
	}

	public function testShouldAddAMemberToTheProject()
	{
		factory(User::class, 10)->create();
		factory(Client::class, 10)->create();
		
		$project = factory(Project::class)->create();

		$member = factory(User::class)->create();

		$repository = App::make(ProjectRepository::class);
		$added = $repository->addMember($project->id, $member->id);

		$this->assertTrue($added);
		$this->assertCount(1, $project->members);
	}

	public function testShouldTryAddAnExistingProjectMember()
	{
		factory(User::class, 10)->create();
		factory(Client::class, 10)->create();
		
		$project = factory(Project::class)->create();

		$member = factory(User::class)->create();
		$project->members()->attach($member->id);

		$repository = App::make(ProjectRepository::class);
		$added = $repository->addMember($project->id, $member->id);

		$this->assertFalse($added);
		$this->assertCount(1, $project->members);
	}

	/**
     * @expectedException PDOException
     */
	public function testShouldTryAddAnInvalidProjectMember()
	{
		factory(User::class, 10)->create();
		factory(Client::class, 10)->create();
		
		$project = factory(Project::class)->create();

		$repository = App::make(ProjectRepository::class);
		$repository->addMember($project->id, 999);
	}

	public function testShouldRemoveOneProjectMember()
	{
		factory(User::class, 10)->create();
		factory(Client::class, 10)->create();
		
		$project = factory(Project::class)->create();

		$member = factory(User::class)->create();
		$project->members()->attach($member->id);

		$repository = App::make(ProjectRepository::class);
		$removed = $repository->removeMember($project->id, $member->id);

		$this->assertTrue($removed);
	}

	public function testShouldTryRemoveAnInvalidProjectMember()
	{
		factory(User::class, 10)->create();
		factory(Client::class, 10)->create();
		
		$project = factory(Project::class)->create();

		$repository = App::make(ProjectRepository::class);
		$removed = $repository->removeMember($project->id, 999);

		$this->assertFalse($removed);
	}

	/**
     * @group repository
     */
	public function testShouldRemoveAllProjectMembers()
	{
		//
	}
}