<?php

/**
 * This file is part of the Laravel Project Software package.
 *
 * App - Laravel Project
 *
 * @link    https://github.com/g-six/laravel
 */
namespace App\Api\Transformers;

use App\Api\Eloquent\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * Resources that can be included if requested.
     *
     * @var array
     *
     * @author Bertrand Kintanar <bertrand@idearobin.com>
     */
    protected $availableIncludes = [
        'role',
    ];

    /**
     * Transform object into a generic array.
     *
     * @param User $user
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand@idearobin.com>
     */
    public function transform(User $user)
    {
        return [
            'id'         => (int) $user->id,
            'email'      => $user->email,
            'last_login' => $user->last_login,
        ];
    }

    /**
     * Include Role.
     *
     * @param User $user
     *
     * @return \League\Fractal\Resource\Collection
     *
     * @author Bertrand Kintanar <bertrand@idearobin.com>
     */
    public function includeRole(User $user)
    {
        $roles = $user->roles;

        return $this->collection($roles, new RoleTransformer());
    }
}
