<?php

namespace App\Repositories\Contracts;

interface RoleContract
{
    public function index();

    public function store(array $data);

    public function show($id);

    public function update(array $data, $id);

    public function delete($id);

    public function paginate();

    public function where($column, $value);
}
