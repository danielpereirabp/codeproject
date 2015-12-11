<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Validators\ProjectFileValidator;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;

use Prettus\Validator\Exceptions\ValidatorException;

class ProjectFileService
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

    public function __construct(ProjectFileRepository $repository, ProjectFileValidator $validator, Filesystem $filesystem, Storage $storage)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->filesystem = $filesystem;
        $this->storage = $storage;
    }

    public function create(array $data)
    {
        try {

            $this->validator->with($data)->passesOrFail();

            $projectFile = $this->repository->skipPresenter()->create($data);

            $this->storage->put($projectFile->id.'.'.$data['extension'], $this->filesystem->get($data['file']));

            return ['success' => true];

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

    public function delete($id)
    {
        try {
            $projectFile = $this->repository->skipPresenter()->find($id);

            $this->storage->delete($id . "." . $model->extension);

            $this->repository->delete($id);

            return ['success' => true];

        } catch (\Exception $e) {
            return [
                "error" => true,
                "message" => $e->getMessage()
            ];
        }
    }
}