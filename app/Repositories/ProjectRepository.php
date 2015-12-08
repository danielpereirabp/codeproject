<?php

namespace CodeProject\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

interface ProjectRepository extends RepositoryInterface
{
	public function isOwner($projectId, $userId);
	public function isMember($projectId, $userId);
	public function addMember($projectId, $memberId);
	public function removeMember($projectId, $memberId);
}