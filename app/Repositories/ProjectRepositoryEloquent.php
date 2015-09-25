<?php

namespace CodeProject\Repositories;

use CodeProject\Entities\Project;
use CodeProject\Presenters\ProjectPresenter;
use Prettus\Repository\Eloquent\BaseRepository;

class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository
{
	public function model()
	{
		return Project::class;
	}

	public function isOwner($projectId, $userId)
	{
		if (count($this->findWhere(['id' => $projectId, 'owner_id' => $userId]))) {
			return true;
		}

		return false;
	}

	public function isMember($projectId, $memberId)
	{
		if (! $members = $this->find($projectId)->members()) {
			return false;
		}

		return $members->find($memberId);
	}

	public function presenter()
	{
		return ProjectPresenter::class;
	}
}