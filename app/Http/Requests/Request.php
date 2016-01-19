<?php

/**
 * This file is part of the Laravel Project Software package.
 *
 * App - Laravel Project
 *
 * @link    https://github.com/g-six/laravel
 */
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * Override the response for failed validation response for the request.
     *
     * @param array $errors
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @author Donna Borja <donna@idearobin.com>
     */
    public function response(array $errors)
    {
        return response()->json(['message' => 'Please input valid data.', 'data' => $errors]);
    }
}
