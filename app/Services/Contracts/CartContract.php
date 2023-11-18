<?php

namespace App\Services\Contracts;

interface CartContract
{
    public function store($request);

    public function update($request, $id);

    public function delete($id);

    public function paginate();

    public function proses($request);
}
