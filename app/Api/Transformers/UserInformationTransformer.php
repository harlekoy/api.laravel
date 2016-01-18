<?php

/**
 * This file is part of the Laravel Project Software package.
 *
 * IdeaRobin - Laravel Project
 *
 * @link    https://github.com/g-six/laravel
 */
namespace IdeaRobin\Api\Transformers;

use IdeaRobin\Api\Eloquent\UserInformation;
use League\Fractal\TransformerAbstract;

class UserInformationTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include.
     *
     * @var array
     */
    protected $defaultIncludes = [
        'user'
    ];

    /**
     * Transform object into a generic array.
     *
     * @param UserInformation $user_information
     *
     * @return array
     *
     * @author Donna Borja <donna@idearobin.com>
     */
    public function transform(UserInformation $user_information)
    {
        return [
            'id'         => (int) $user_information->id,
            'first_name' => $user_information->first_name,
            'last_name'  => $user_information->last_name,
            'phone'      => $user_information->phone,
            'address'    => $user_information->address,
            'suburb'     => $user_information->suburb,
            'postcode'   => $user_information->postcode
        ];
    }

    /**
     * Include User.
     *
     * @param UserInformation $user_information
     *
     * @return \League\Fractal\Resource\Item
     *
     * @author Donna Borja <donna@idearobin.com>
     */
    public function includeUser(UserInformation $user_information)
    {
        $user = $user_information->user;

        return $this->item($user, new UserTransformer());
    }
}
