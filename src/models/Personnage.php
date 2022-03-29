<?php

namespace gamepedia\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static find(mixed $id, array $columns = [])
 */
class Personnage extends Model
{

    protected $table = 'character';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    public function jeux(): BelongsToMany
    {
        return $this->belongsToMany('gamepedia\models\Jeu', 'game2character', 'character_id', 'game_id');
    }
}