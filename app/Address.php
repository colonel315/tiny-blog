<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['street', 'city', 'state', 'zip'];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
