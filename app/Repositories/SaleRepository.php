<?php

namespace App\Repositories;

use App\Models\Sale;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\SaleContract;

class SaleRepository extends BaseRepository implements SaleContract
{
    /**
     * @var
     */
    protected $model;

    public function __construct(Sale $models)
    {
        $this->model = $models->whereNotNull('id');
    }
}
