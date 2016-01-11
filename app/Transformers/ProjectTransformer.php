<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\Client;
use CodeProject\Entities\Project;
use League\Fractal\TransformerAbstract;


class ProjectTransformer extends TransformerAbstract
{
	protected $defaultIncludes = ['client', 'members'];

      public function transform(Project $project)
	{
		return [
                  'id'          => $project->id,
                  'client'      => $project->client_id,
                  'owner_id'    => $project->owner_id,
                  'name'        => $project->name,
                  'description' => $project->description,
                  'progress'    => (int)$project->progress,
                  'status'      => (int)$project->status,
                  'due_date'    => $project->due_date
		];
	}

      public function includeClient(Project $project)
      {
            return $this->item($project->client, new ClientTransformer());
      }

      public function includeMembers(Project $project)
      {
            return $this->collection($project->members, new ProjectMemberTransformer());
      }
}