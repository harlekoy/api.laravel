<?php

/**
 * This file is part of the Laravel Project Software package.
 *
 * App - Laravel Project
 *
 * @link    https://github.com/g-six/laravel
 */
namespace App\Api\Transformers;

use App\Api\Eloquent\Image;
use League\Fractal\TransformerAbstract;

class ImageTransformer extends TransformerAbstract
{
    /**
     * Transform object into a generic array.
     *
     * @param Image $image
     *
     * @return array
     *
     * @author Donna Borja <donna@idearobin.com>
     */
    public function transform(Image $image)
    {
        return [
            'id'         => (int) $image->id,
            'name'       => $image->name,
            'path'       => $image->path,
            'is_default' => $image->is_default,
        ];
    }
}
