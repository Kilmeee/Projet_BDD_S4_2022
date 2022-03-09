<?php

namespace gamepedia\models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, string $string2)
 */
class Rating extends Model
{

    protected $table = 'rating_board';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    public function jeux()
    {
        return $this->belongsToMany('gamepedia\models\Jeu', 'game2rating','rating_id', 'game_id');
    }

}