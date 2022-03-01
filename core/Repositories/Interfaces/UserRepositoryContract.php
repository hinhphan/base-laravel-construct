<?php

namespace Core\Repositories\Interfaces;

interface UserRepositoryContract
{
    public function paginate($perPage);
    public function find($id);
    public function findByField($fieldName, $fieldValue);
    public function store($data);
    public function update($id, $data);
    public function destroy($id);
}