<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nanigans\SingleTableInheritance\SingleTableInheritanceTrait;

class UserRelationships extends Model{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'relationship_id'
    ];

    use SingleTableInheritanceTrait;

    protected $table = "user_relationship";
    
    protected static $persisted = ['user_id', 'relationship_id'];

    protected static $singleTableTypeField = 'type';

    protected static $singleTableSubclasses = [Block::class, Friend::class];
}

class Block extends UserRelationships {
    protected static $singleTableType = 'Block';
}

class Friend extends UserRelationships {
    protected static $singleTableType = 'Friend';
}