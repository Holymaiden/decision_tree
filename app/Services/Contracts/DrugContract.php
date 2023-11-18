<?php

namespace App\Services\Contracts;

interface DrugContract
{
    public function getAll();

    public function store($request);

    public function update($update, $id);

    public function show($id);

    public function delete($id);

    public function paginate();

    public function where($column, $value);
}
