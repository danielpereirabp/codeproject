<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectMemberValidator;

use Prettus\Validator\Exceptions\ValidatorException;

class ProjectMemberService
{
	/**
    * @var ProjectRepository
    */
    private $repository;

    /**
    * @var ProjectValidator
    */
    private $validator;

    public function __construct(ProjectRepository $repository, ProjectMemberValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

	public function addMember($data)
    {
        try {

        	$this->validator->with($data)->passesOrFail();

            return [
                'success' => $this->repository->addMember($data['project_id'], $data['user_id'])
            ];

        } catch (ValidatorException $e) {
    		return [
    			'error' => true,
    			'message' => $e->getMessageBag()
    		];
    	} catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function removeMember($projectId, $memberId)
    {
        try {

            return [
                'success' => $this->repository->removeMember($projectId, $memberId)
            ];

        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }
}