<?php

use CodeProject\Entities\User;
use CodeProject\Entities\Client;
use CodeProject\Entities\Project;

use Illuminate\Foundation\Testing\WithoutMiddleware;

class ProjectMemberControllerTest extends TestCase
{
    use WithoutMiddleware;

    public function testShouldAddOneMemberToTheProject()
    {
    	factory(User::class, 10)->create();
        factory(Client::class, 10)->create();

        $project = factory(Project::class)->create();
        $member = factory(User::class)->create();

        $data = [
            'project_id' => $project->id,
            'user_id' => $member->id
        ];

        $this->post("project/{$project->id}/member", $data)
            ->seeJson([
                'success' => true
            ]);

        $this->seeInDatabase('project_members', ['project_id' => $project->id, 'member_id' => $member->id]);
    }

    public function testShouldRemoveOneProjectMember()
	{
		factory(User::class, 10)->create();
        factory(Client::class, 10)->create();

        $project = factory(Project::class)->create();

        $member = factory(User::class)->create();
		$project->members()->attach($member->id);

		$this->delete("project/{$project->id}/member/{$member->id}")
            ->seeJson([
                'success' => true
            ]);

        $this->notSeeInDatabase('project_members', ['project_id' => $project->id, 'member_id' => $member->id]);
	}

    public function testShouldListAllMembersOfProject()
    {
        factory(User::class, 10)->create();
        factory(Client::class, 10)->create();

        $project = factory(Project::class)->create();

        $project->members()->attach(factory(User::class)->create()->id);
        $project->members()->attach(factory(User::class)->create()->id);
        $project->members()->attach(factory(User::class)->create()->id);
        $project->members()->attach(factory(User::class)->create()->id);

        $jsonResponse = $this->call('GET', "project/{$project->id}/member")->getContent();
        $responseData = json_decode($jsonResponse);

        $this->assertCount(4, $responseData->data);
    }
}