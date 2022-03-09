<?php

namespace gamepedia\models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, string $string2)
 */
class Jeu extends Model
{

    protected $table = 'game';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    public function characters() {
        return $this->belongsToMany('gamepedia\models\Personnage', 'game2character', 'game_id', 'character_id');
    }

    public function ratings() {
        return $this->belongsToMany('gamepedia\models\Rating', 'game2rating', 'game_id', 'rating_id');
    }

    public function compagnies() {
        return $this->belongsToMany('gamepedia\models\Compagnie', 'game_publishers','comp_id', 'game_id');
    }

}