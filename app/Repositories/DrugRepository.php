<?php

namespace App\Repositories;

use App\Models\Drug;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\DrugContract;

class DrugRepository extends BaseRepository implements DrugContract
{
    /**
     * @var
     */
    protected $model;

    public function __construct(Drug $models)
    {
        $this->model = $models->whereNotNull('id');
    }
}
