<?php

namespace CodeProject\Repositories;

use CodeProject\Entities\User;
use CodeProject\Entities\Client;
use CodeProject\Entities\Project;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use Mockery as m;

class ProjectRepositoryEloquentTest extends \TestCase
{
	public function tearDown()
    {
        m::close();
    }

	public function testShouldCheckIfIsOwner()
	{
		// Set
		$project    = m::mock(Project::class);
		$repository = m::mock(ProjectRepositoryEloquent::class)->makePartial();
		
		// Expect
		$repository->shouldReceive('findWhere')->once()->withAnyArgs()->andReturn($project);

		// Assert
		$this->assertTrue(
			$repository->isOwner(1, 1)
		);
	}

	public function testShouldCheckIfIsNotOwner()
	{
		// Set
		$repository = m::mock(ProjectRepositoryEloquent::class)->makePartial();
		
		// Expect
		$repository->shouldReceive('findWhere')->once()->withAnyArgs()->andReturn(null);

		// Assert
		$this->assertFalse(
			$repository->isOwner(1, 1)
		);
	}

	public function testShouldCheckIfIsMember()
	{
		// Set
		$user       = m::mock(User::class);
		$project    = m::mock(Project::class);
		$members    = m::mock(BelongsToMany::class);
		$repository = m::mock(ProjectRepositoryEloquent::class)->makePartial();

		// Expect
		$members->shouldReceive('find')->once()->andReturn($user);

		$project->shouldReceive('members')->once()->andReturn($members);

		$repository->shouldReceive('find')->once()->withAnyArgs()->andReturn($project);

		// Assert
		$this->assertTrue(
			$repository->isMember(1, 1)
		);
	}

	public function testShouldCheckIfIsNotMember()
	{
		// Set
		$project    = m::mock(Project::class);
		$members    = m::mock(BelongsToMany::class);
		$repository = m::mock(ProjectRepositoryEloquent::class)->makePartial();

		// Expect
		$members->shouldReceive('find')->once()->andReturn(null);

		$project->shouldReceive('members')->once()->andReturn($members);

		$repository->shouldReceive('find')->once()->withAnyArgs()->andReturn($project);

		// Assert
		$this->assertFalse(
			$repository->isMember(1, 1)
		);
	}

	public function testShouldAddAMemberToTheProject()
	{
		// Set
		$project    = m::mock(Project::class);
		$members    = m::mock(BelongsToMany::class);
		$collection = m::mock(Collection::class);
		$repository = m::mock(ProjectRepositoryEloquent::class)->makePartial();

		// Expect
		$members->shouldReceive('attach');

		$collection->shouldReceive('contains')->once()->with('id', 1)->andReturn(false);
		
		$project->shouldReceive('getAttribute')->with('members')->andReturn($collection);
		$project->shouldReceive('members')->andReturn($members);
		
		$repository->shouldReceive('find')->once()->with(1)->andReturn($project);

		// Assert
		$this->assertTrue(
			$repository->addMember(1, 1)
		);
	}

	public function testShouldTryAddAnExistingProjectMember()
	{
		// Set
		$project    = m::mock(Project::class);
		$collection = m::mock(Collection::class);
		$repository = m::mock(ProjectRepositoryEloquent::class)->makePartial();

		// Expect
		$collection->shouldReceive('contains')->once()->with('id', 1)->andReturn(true);
		
		$project->shouldReceive('getAttribute')->with('members')->andReturn($collection);
		
		$repository->shouldReceive('find')->once()->with(1)->andReturn($project);

		// Assert
		$this->assertFalse(
			$repository->addMember(1, 1)
		);
	}

	public function testShouldRemoveOneProjectMember()
	{
		// Set
		$project    = m::mock(Project::class);
		$members    = m::mock(BelongsToMany::class);
		$repository = m::mock(ProjectRepositoryEloquent::class)->makePartial();

		// Expect
		$members->shouldReceive('detach')->once()->andReturn(true);

		$project->shouldReceive('members')->once()->andReturn($members);

		$repository->shouldReceive('find')->once()->with(1)->andReturn($project);

		// Assert
		$this->assertTrue(
			$repository->removeMember(1, 1)
		);
	}

	public function testShouldTryRemoveAnInvalidProjectMember()
	{
		// Set
		$project    = m::mock(Project::class);
		$members    = m::mock(BelongsToMany::class);
		$repository = m::mock(ProjectRepositoryEloquent::class)->makePartial();

		// Expect
		$members->shouldReceive('detach')->once()->andReturn(false);

		$project->shouldReceive('members')->once()->andReturn($members);

		$repository->shouldReceive('find')->once()->with(1)->andReturn($project);

		// Assert
		$this->assertFalse(
			$repository->removeMember(1, 1)
		);
	}
}