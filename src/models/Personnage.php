<?php

namespace gamepedia\models;

use Illuminate\Database\Eloquent\Model;

class Personnage extends Model
{

    protected $table = 'character';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    public function jeux()
    {
        return $this->belongsToMany('gamepedia\models\Jeu', 'game2character', 'character_id', 'game_id');
    }
}