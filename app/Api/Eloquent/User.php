<?php

/**
 * This file is part of the Laravel Project Software package.
 *
 * IdeaRobin - Laravel Project
 *
 * @link    https://github.com/g-six/laravel
 */
namespace IdeaRobin\Api\Eloquent;

use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;
use Exception;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;

/**
 * Class User.
 *
 * @SWG\Definition(definition="User")
 * @SWG\Property(property="email", type="string", default="janedoe@example.com", description="Unique email address")
 * @SWG\Property(property="password", type="string", default="helloworld", description="Password must be at least 6 characters")
 * @SWG\Property(property="password_confirmation", type="string", default="helloworld", description="Re-enter password")
 * @SWG\Property(property="first_name", type="string", default="Jane", description="First Name")
 * @SWG\Property(property="last_name", type="string", default="Doe", description="Last Name")
 * @SWG\Property(property="phone", type="string", default="555-1234", description="Phone number")
 * @SWG\Property(property="address", type="string", default="Galway St.", description="Address")
 * @SWG\Property(property="suburb", type="string", default="Adamantine", description="Suburb")
 * @SWG\Property(property="postcode", type="string", default="90218", description="Postal Code")
 * @SWG\Property(property="state_id", type="integer", format="int64", default=2, description="STATE_ID of state")
 */
class User extends SentinelUser implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * @throws Exception
     *
     * @return mixed
     *
     * @author Bertrand Kintanar <bertrand@idearobin.com>
     */
    public function role()
    {
        $roles = $this->getRoles();

        if (empty($roles)) {
            throw new Exception('User not in group.');
        }

        return $roles[0];
    }

    /**
     * Link with all Beneficiaries.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @author Donna Borja <donna@idearobin.com>
     */
    public function beneficiaries()
    {
        return $this->hasMany('IdeaRobin\Api\Eloquent\Beneficiary', 'user_id', 'id');
    }

    /**
     * Get all of the estates of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     * @author Donna Borja <donna@idearobin.com>
     */
    public function estates()
    {
        return $this->belongsToMany('IdeaRobin\Api\Eloquent\Estate');
    }

    /**
     * Link with all EOIs.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @author Donna Borja <donna@idearobin.com>
     */
    public function eois()
    {
        return $this->hasMany('IdeaRobin\Api\Eloquent\Eoi', 'user_id', 'id');
    }
}
