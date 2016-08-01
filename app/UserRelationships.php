<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nanigans\SingleTableInheritance\SingleTableInheritanceTrait;

class UserRelationships extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'relationship_id'];

    use SingleTableInheritanceTrait;

    /**
     * define the table usable
     *
     * @var string $table
     */
    protected $table = "user_relationship";

    /**
     * columns that are usable in classes that extend UserRelationships
     *
     * @var array $persisted
     */
    protected static $persisted = ['user_id', 'relationship_id'];

    /**
     * Field that object gets saved to. The descriminator.
     *
     * @var string $singleTableTypeField
     */
    protected static $singleTableTypeField = 'type';

    /**
     * Sub classes that will be extending UserRelationships
     *
     * @var array $singleTableSubclasses
     */
    protected static $singleTableSubclasses = [Block::class, Friend::class];
}

class Block extends UserRelationships
{
    /**
     * Object that gets saved to the discriminator.
     *
     * @var string $singleTableType
     */
    protected static $singleTableType = 'Block';
}

class Friend extends UserRelationships
{
    /**
     * Object that gets saved to the discriminator.
     *
     * @var string $singleTableType
     */
    protected static $singleTableType = 'Friend';
}