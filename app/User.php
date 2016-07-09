<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'description', 'high_school', 'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function blockedUsers()
    {
        return $this->belongsToMany(User::class, 'blocked_users', 'user_id', 'blocked_id');
    }

    public function addAddress(Address $address, $userId)
    {
        $address->user_id = $userId;
        return $this->addresses()->save($address);
    }

    public function addBlocked($blockedId)
    {
        $this->blockedUsers()->attach($blockedId);
    }

    public function removeBlocked($blockedId)
    {
        $this->blockedUsers()->detach($blockedId);
    }
}
