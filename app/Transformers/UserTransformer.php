<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $v)
    {
        $role = $v->role->first();
        $data = [
            'id' => $v->id,
            'name' => $v->name,
            'username' => $v->username,
            'email' => $v->email,
            'active' => $v->active,
            'role' => [
                'id' => $role->id,
                'name' => $role->name
            ]
        ];

        return $data;
    }
}
