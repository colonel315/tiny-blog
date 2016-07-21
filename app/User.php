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
    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'description', 'high_school', 'username',];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token',];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    public function userRelationships()
    {
        return $this->belongsToMany(User::class, 'user_relationship', 'user_id', 'relationship_id');
    }

    public function addAddress(Address $address)
    {
        $address->user_id = $this->id;

        return $this->addresses()->save($address);
    }

    public function addStatus($newStatus)
    {
        $status = new Status;
        $status->status = $newStatus;
        $status->user_id = $this->id;

        return $this->statuses()->save($status);
    }

    public function addBlocked($userId, $blockedId)
    {
        Block::create(['user_id' => $userId, 'relationship_id' => $blockedId]);
    }

    public function removeBlocked($blockedId)
    {
        $this->userRelationships()->detach($blockedId);
    }

    public function addFriend($userId, $friendId)
    {
        Friend::create(['user_id' => $userId, 'relationship_id' => $friendId]);
    }

    public function removeFriend($friendId)
    {
        $this->userRelationships()->detach($friendId);
    }
}