<?php

namespace gamepedia\models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, string $string2)
 */
class RatingBoard extends Model
{

    protected $table = 'rating_board';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;

    public function ratings()
    {
        return $this->hasMany('gamepedia\models\Rating', 'rating_board_id');
    }

}