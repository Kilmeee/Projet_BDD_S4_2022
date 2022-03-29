<?php

namespace gamepedia\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{HasMany, BelongsToMany};

/**
 * @method static where(string $string, string $string1, string $string2)
 * @method static limit(int $int)
 * @method static find(int $id, array $args = [])
 * @method static select(string[] $array)
 * @method static simplePaginate(int $int, string[] $array, string $string, mixed $id)
 */
class Jeu extends Model
{

    protected $table = 'game';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    public function commentaires() : HasMany
    {
        return $this->hasMany('gamepedia\models\Commentaire', 'id_game');
    }

    public function personnages(): BelongsToMany
    {
        return $this->belongsToMany('gamepedia\models\Personnage', 'game2character', 'game_id', 'character_id');
    }
}