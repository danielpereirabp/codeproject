<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectService
{
	/**
    * @var ProjectRepository
    */
    private $repository;

    /**
    * @var ProjectValidator
    */
    private $validator;

    public function __construct(ProjectRepository $repository, ProjectValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function all($limit = null)
    {
        try {
            // return $this->repository->with(['owner', 'client', 'members'])->all();
            return $this->repository->findWithOwnerAndMember(\Authorizer::getResourceOwnerId(), $limit);
        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function find($id)
    {
        try {
            return $this->repository->with(['owner', 'client', 'members'])->find($id);
        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function delete($id)
    {
        try {
            $this->repository->delete($id);

            return ['success' => true];

        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function create(array $data)
    {
    	try {
    		$this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);

    		return $this->repository->create($data);

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

    public function update(array $data, $id)
    {
    	try {
    		$this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);

    		return $this->repository->update($data, $id);

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
}