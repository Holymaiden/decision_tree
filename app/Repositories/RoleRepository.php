<?php

namespace App\Repositories;

use App\Models\Role;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\RoleContract;

class RoleRepository extends BaseRepository implements RoleContract
{
    /**
     * @var
     */
    protected $model;

    public function __construct(Role $models)
    {
        $this->model = $models->whereNotNull('id');
    }
}
