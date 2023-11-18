<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\TransactionContract;

class TransactionRepository extends BaseRepository implements TransactionContract
{
    /**
     * @var
     */
    protected $model;

    public function __construct(Transaction $models)
    {
        $this->model = $models->whereNotNull('id');
    }

    public function show($id)
    {
        return $this->model->with('detail')->find($id);
    }
}
