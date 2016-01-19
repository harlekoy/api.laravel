<?php

/**
 * This file is part of the Laravel Project Software package.
 *
 * App - Laravel Project
 *
 * @link    https://github.com/g-six/laravel
 */
namespace App\Api\Eloquent;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Image.
 */
class Image extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'images';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'path',
        'is_default',
        'imageable_id',
        'imageable_type',
    ];

    /**
     * Get all of the owning imageable models.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     *
     * @author Donna Borja <donna@idearobin.com>
     */
    public function imageable()
    {
        return $this->morphTo();
    }
}
