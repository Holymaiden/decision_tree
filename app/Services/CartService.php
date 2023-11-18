<?php

namespace App\Services;

use App\Repositories\Contracts\CartContract as CartRepo;
use App\Services\Contracts\CartContract;

class CartService implements CartContract
{
    protected $contractRepo;

    public function __construct(CartRepo $contractRepo)
    {
        $this->contractRepo = $contractRepo;
    }

    /**
     * Store Data
     */
    public function store($request)
    {
        $input = $request->all();
        return $this->contractRepo->store($input);
    }

    /**
     * Update Data
     *
     * @param $request
     * @param $id
     * @return mixed
     */
    public function update($request, $id)
    {
        $input = $request->all();
        return $this->contractRepo->update($input, $id);
    }


    /**
     * Delete Data By ID
     */
    public function delete($id)
    {
        return $this->contractRepo->delete($id);
    }

    /**
     * Get Data with Pagination
     */
    public function paginate($perPage = 0, $columns = array('*'))
    {
        $perPage = $perPage ?: config('constants.PAGINATION');
        return $this->contractRepo->paginate($perPage, $columns);
    }

    /**
     * Proses Data
     */
    public function proses($request)
    {
        $input = $request->all();
        return $this->contractRepo->proses($input);
    }
}
