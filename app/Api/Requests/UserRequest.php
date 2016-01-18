<?php

/**
 * This file is part of the Laravel Project Software package.
 *
 * IdeaRobin - Laravel Project
 *
 * @link    https://github.com/g-six/laravel
 */
namespace IdeaRobin\Api\Requests;

use IdeaRobin\Api\Eloquent\User;
use IdeaRobin\Http\Requests\Request;

class UserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // request() works in API-Docs Swaggervel, route() works in REST Client postman
        $user_id = (request()->get('user_id') != null) ? request()->get('user_id') : $this->route('user_id');

        $rules = [
            'user.email'      => 'required|email|max:255|unique:users,email',
            'user.password'   => 'required|confirmed|min:6',
            'user.first_name' => 'required|max:255',
            'user.last_name'  => 'required|max:255',
            'user.phone'      => 'max:255',
            'user.suburb'     => 'max:255',
            'user.postcode'   => 'max:255',
            'user.state_id'   => 'integer|exists:states,id',
        ];

        // if Update profile, exempt is_unique validation for email of the current user's email
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $rules['user.email'] .= ','.$user_id;
        }

        return $rules;
    }
}
