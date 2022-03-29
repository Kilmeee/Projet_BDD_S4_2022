<?php

namespace gamepedia\models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, string $string2)
 * @method static limit(int $int)
 * @method static find(int $id, array $args)
 * @method static select(string[] $array)
 */
class Jeu extends Model
{

    protected $table = 'game';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
}