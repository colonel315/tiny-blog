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

    /**
     * User has a Customer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    /**
     * User has many addresses
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * User has many statuses
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    /**
     * User has many relationships
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userRelationships()
    {
        return $this->belongsToMany(User::class, 'user_relationship', 'user_id', 'relationship_id');
    }

    /**
     * Adds address to the database
     *
     * @param Address $address
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function addAddress(Address $address)
    {
        $address->user_id = $this->id;

        return $this->addresses()->save($address);
    }

    /**
     * Adds status to the database
     * 
     * @param $newStatus
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function addStatus($newStatus)
    {
        $status = new Status;
        $status->status = $newStatus;
        $status->user_id = $this->id;

        return $this->statuses()->save($status);
    }

    /**
     * Adds a blocked user to the database
     * 
     * @param $userId
     * @param $blockedId
     */
    public function addBlocked($userId, $blockedId)
    {
        Block::create(['user_id' => $userId, 'relationship_id' => $blockedId]);
    }

    /**
     * Removes a blocked user from the database
     * 
     * @param $blockedId
     */
    public function removeBlocked($blockedId)
    {
        $this->userRelationships()->detach($blockedId);
    }

    /**
     * Adds a friend to the database
     * 
     * @param $userId
     * @param $friendId
     */
    public function addFriend($userId, $friendId)
    {
        Friend::create(['user_id' => $userId, 'relationship_id' => $friendId]);
    }

    /**
     * Removes a friend from the database
     * 
     * @param $friendId
     */
    public function removeFriend($friendId)
    {
        $this->userRelationships()->detach($friendId);
    }
}