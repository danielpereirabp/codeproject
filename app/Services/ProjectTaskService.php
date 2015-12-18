<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Validators\ProjectTaskValidator;

use Prettus\Validator\Exceptions\ValidatorException;

class ProjectTaskService
{
	/**
    * @var ProjectTaskRepository
    */
    private $repository;

    /**
    * @var ProjectTaskValidator
    */
    private $validator;

    public function __construct(ProjectTaskRepository $repository, ProjectTaskValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function all($projectId)
    {
        try {
            return $this->repository->findWhere(['project_id' => $projectId]);
        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function find($projectId, $id)
    {
        try {
            return $this->repository->findWhere(['project_id' => $projectId, 'id' => $id]);
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
    		$this->validator->with($data)->passesOrFail();

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
    		$this->validator->with($data)->passesOrFail();

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