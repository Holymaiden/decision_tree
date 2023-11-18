<?php

namespace App\Repositories\Contracts;

interface CartContract
{
    public function store(array $data);

    public function update(array $data, $id);

    public function delete($id);

    public function paginate();

    public function proses(array $data);
}
