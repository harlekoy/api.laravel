<?php

/**
 * This file is part of the Laravel Project Software package.
 *
 * IdeaRobin - Laravel Project
 *
 * @link    https://github.com/g-six/laravel
 */
namespace IdeaRobin\Api\Transformers;

use Cartalyst\Sentinel\Roles\EloquentRole as Role;
use League\Fractal\TransformerAbstract;

class RoleTransformer extends TransformerAbstract
{
    /**
     * Transform object into a generic array.
     *
     * @param Role $role
     *
     * @return array
     *
     * @author Bertrand Kintanar <bertrand@idearobin.com>
     */
    public function transform(Role $role)
    {
        return [
            'id'          => (int) $role->id,
            'slug'        => $role->slug,
            'name'        => $role->name,
            'permissions' => $role->permissions,
        ];
    }
}
