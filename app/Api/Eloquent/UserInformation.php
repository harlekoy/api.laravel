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
use Swagger\Annotations as SWG;

/**
 * Class User Information.
 */
class UserInformation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_information';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'address',
        'suburb',
        'postcode',
        'state_id'
    ];

    /**
     * Merge user_information.user_id to users table
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     *
     * @author Donna Borja <donna@idearobin.com>
     */
    public function user()
    {
        return $this->belongsTo('App\Api\Eloquent\User', 'user_id');
    }

    /**
     * Merge user_information.state_id from states table
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     *
     * @author Donna Borja <donna@idearobin.com>
     */
    public function state()
    {
        return $this->hasOne('App\Api\Eloquent\State', 'id', 'state_id');
    }
}
