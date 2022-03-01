<?php

namespace Core\Repositories;

use App\Models\User;
use Core\Repositories\Interfaces\UserRepositoryContract;

class UserRepository implements UserRepositoryContract
{
    protected $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function paginate($perPage)
    {
        return $this->model->paginate($perPage);
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function store($data)
    {
        return $this->model->create($data);
    }

    public function update($id, $data)
    {
        $model = $this->find($id);
        return $model->update($data);
    }

    public function destroy($id)
    {
        $model = $this->find($id);
        return $model->destroy($id);
    }

    public function findByField($fieldName, $fieldValue) {
        return $this->model->where($fieldName, $fieldValue)->first();
    }
}