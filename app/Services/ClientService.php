<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ClientRepository;
use CodeProject\Validators\ClientValidator;

use Prettus\Validator\Exceptions\ValidatorException;

class ClientService
{
	/**
    * @var ClientRepository
    */
    private $repository;

    /**
    * @var ClientValidator
    */
    private $validator;

    public function __construct(ClientRepository $repository, ClientValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function all()
    {
        try {
            return $this->repository->all();
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
            return $this->repository->find($id);
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