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

    public function commentaires() : \Illuminate\Database\Eloquent\Relations\HasMany{
        return $this->hasMany('gamepedia\models\Commentaire', 'id_game');
    }
}