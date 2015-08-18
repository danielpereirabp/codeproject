<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;

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

    /**
    * @var Filesystem
    */
    private $filesystem;

    /**
    * @var Storage
    */
    private $storage;

    public function __construct(ProjectRepository $repository, ProjectValidator $validator, Filesystem $filesystem, Storage $storage)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
    }

    public function all()
    {
        try {
            return $this->repository->with(['owner', 'client', 'members'])->all();
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
    		$this->validator->with($data)->passesOrFail();

    		return $this->repository->create($data);

    	} catch (ValidatorException $e) {
    		return [
    			'error' => true,
    			'message' => $e->getMessageBag()
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
    	}
    }

    public function members($id)
    {
        try {
            return $this->repository->find($id)->members;
        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function addMember($projectId, $userId)
    {
        try {

            $this->repository->find($projectId)->members()->attach($userId);

            return ['success' => true];

        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function removeMember($projectId, $userId)
    {
        try {

            $this->repository->find($projectId)->members()->detach($userId);

            return ['success' => true];

        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function isMember($projectId, $userId)
    {
        try {
            return $this->repository->find($projectId)->members()->find($userId) ? ['success' => true] : ['success' => false];
        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }

    public function createFile(array $data)
    {
        try {

            $project = $this->repository->skipPresenter()->find($data['project_id']);
            $projectFile = $project->files()->create($data);

            $this->storage->put($projectFile->id.'.'.$data['extension'], $this->filesystem->get($data['file']));

            return ['success' => true];

        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }
}