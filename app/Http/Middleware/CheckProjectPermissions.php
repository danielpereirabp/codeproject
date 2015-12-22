<?php

namespace CodeProject\Http\Middleware;

use Closure;
use CodeProject\Repositories\ProjectRepository;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class CheckProjectPermissions
{
    /**
     * @var ProjectRepository
     */
    private $repository;

    public function __construct(ProjectRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $projectId = $request->project ?: $request->projectId;
        $userId = Authorizer::getResourceOwnerId();

        if ($this->repository->isOwner($projectId, $userId) == false && $this->repository->isMember($projectId, $userId) == false) {
            return ['error' => 'Access forbidden'];
        }

        return $next($request);
    }
}
