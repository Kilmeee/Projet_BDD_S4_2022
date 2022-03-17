<?php

namespace gamepedia\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static where(string $string, string $string1, string $string2)
 * @method static find(int $int)
 */
class Jeu extends Model
{

    protected $table = 'game';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    public function characters(): BelongsToMany
    {
        return $this->belongsToMany('gamepedia\models\Personnage', 'game2character', 'game_id', 'character_id');
    }

    public function ratings(): BelongsToMany
    {
        return $this->belongsToMany('gamepedia\models\Rating', 'game2rating', 'game_id', 'rating_id');
    }

    public function publishers(): BelongsToMany
    {
        return $this->belongsToMany('gamepedia\models\Compagnie', 'game_publishers', 'game_id', 'comp_id');
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany('gamepedia\models\Genre', 'game2genre', 'game_id', 'genre_id');
    }

}