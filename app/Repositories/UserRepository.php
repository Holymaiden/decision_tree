<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\Contracts\UserContract;


class UserRepository extends BaseRepository implements UserContract
{
    /**
     * @var
     */
    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user->whereNotNull('id');
    }
}
