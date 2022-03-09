<?php

namespace gamepedia\models;

use Illuminate\Database\Eloquent\Model;


/**
 * @method static where(string $string, string $string1, string $string2)
 */
class Compagnie extends Model
{
    protected $table = 'company';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    public function jeuxPublies()
    {
        return $this->belongsToMany('gamepedia\models\Jeu', 'game_publishers','comp_id', 'game_id');
    }

    public function jeuxDeveloppes()
    {
        return $this->belongsToMany('gamepedia\models\Jeu', 'game_developers','comp_id', 'game_id');
    }
}