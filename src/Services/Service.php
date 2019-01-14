<?php 

namespace App\Services;

class Service
{
    private $repository;

    public function __construct(\App\Repositories\Repository $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }
}