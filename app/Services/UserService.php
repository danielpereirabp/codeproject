<?php

namespace CodeProject\Services;

use CodeProject\Repositories\UserRepository;

class UserService
{
	/**
    * @var UserRepository
    */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
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
}