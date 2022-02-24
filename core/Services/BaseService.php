<?php

namespace Core\Services;

use Core\Services\Interfaces\BaseServiceContract;

class BaseService implements BaseServiceContract
{
    protected $repository;

    public function __construct(BaseServiceContract $repository)
    {
        return $this->repository = $repository;
    }

    public function paginate($perPage)
    {
        return $this->repository->paginate($perPage);
    }

    public function find($id)
    {
        return $this->repository->find($id);
    }

    public function store($data)
    {
        return $this->repository->store($data);
    }

    public function update($id, $data)
    {
        return $this->repository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->repository->destroy($id);
    }

}