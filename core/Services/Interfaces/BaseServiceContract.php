<?php

namespace Core\Services\Interfaces;

interface BaseServiceContract
{
    public function paginate($perPage);
    public function find($id);
    public function store($data);
    public function update($id, $data);
    public function destroy($id);
}