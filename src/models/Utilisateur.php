<?php

namespace gamepedia\models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, string $string1, string $string2)
 */
class Utilisateur extends Model
{

    protected $table = 'utilisateur';
    protected $primaryKey = 'email';
    public $incrementing = false;
    public $timestamps = false;

    public function commentaires() : \Illuminate\Database\Eloquent\Relations\HasMany{   
        return $this->hasMany('gamepedia\models\Commentaire', 'email_utilisateur');
    }
}