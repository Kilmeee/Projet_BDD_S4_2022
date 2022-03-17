<?php

namespace gamepedia\models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, string $string2)
 */

class Genre extends Model
{

    protected $table = 'genre';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    

}