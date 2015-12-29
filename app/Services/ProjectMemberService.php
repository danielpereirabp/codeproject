<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Repositories\ProjectMemberRepository;
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

    public function __construct(ProjectRepository $projectRepository, ProjectMemberRepository $memberRepository, ProjectMemberValidator $validator)
    {
        $this->projectRepository = $projectRepository;
        $this->memberRepository = $memberRepository;
        $this->validator = $validator;
    }

    public function getMembers($projectId)
    {
        try {
            return $this->memberRepository->getMembers($projectId);
        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

	public function addMember($data)
    {
        try {

        	$this->validator->with($data)->passesOrFail();

            return [
                'success' => $this->projectRepository->addMember($data['project_id'], $data['user_id'])
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
                'success' => $this->projectRepository->removeMember($projectId, $memberId)
            ];

        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }
}