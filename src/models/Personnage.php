<?php

namespace gamepedia\models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, string $string2)
 * @method static whereHas(string $string, \Closure $param)
 */

class Personnage extends Model
{

    protected $table = 'character';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

   public function games() {
       return $this->belongsToMany('gamepedia\models\Jeu', 'game2character', 'character_id', 'game_id');   }

   public function firstGame() {
       return $this->belongsTo('gamepedia\models\Jeu','first_appeared_in_game_id');
   }

}