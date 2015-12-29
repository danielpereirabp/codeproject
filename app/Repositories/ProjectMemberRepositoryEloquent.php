<?php

namespace CodeProject\Repositories;

use CodeProject\Entities\ProjectMember;
use CodeProject\Presenters\ProjectMemberPresenter;
use Prettus\Repository\Eloquent\BaseRepository;

class ProjectMemberRepositoryEloquent extends BaseRepository implements ProjectMemberRepository
{
	public function model()
	{
		return ProjectMember::class;
	}

	public function presenter()
	{
		return ProjectMemberPresenter::class;
	}

	public function getMembers($projectId)
	{
		return $this->findWhere(['project_id' => $projectId]);
	}
}