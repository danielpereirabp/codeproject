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

	public function presenter()
	{
		return ProjectPresenter::class;
	}

	public function isOwner($projectId, $userId)
	{
		if (count($this->skipPresenter()->findWhere(['id' => $projectId, 'owner_id' => $userId]))) {
			return true;
		}

		return false;
	}

	public function isMember($projectId, $userId)
	{
		if ($this->skipPresenter()->find($projectId)->members()->find($userId)) {
			return true;
		}

		return false;
	}

	public function addMember($projectId, $memberId)
	{
		$project = $this->skipPresenter()->find($projectId);

		if ($project->members->contains('id', $memberId)) {
			return false;
		}

		$project->members()->attach($memberId);

		return true;
	}

	public function removeMember($projectId, $memberId)
	{
		if ($this->skipPresenter()->find($projectId)->members()->detach($memberId)) {
			return true;
		}

		return false;
	}
}