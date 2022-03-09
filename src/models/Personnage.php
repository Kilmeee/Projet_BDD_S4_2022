<?php

namespace gamepedia\models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, string $string2)
 */

class Personnage extends Model
{

    protected $table = 'character';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

   public function characterGames() {
       return $this->belongsTo('models/Jeu','game_id');
   }

}