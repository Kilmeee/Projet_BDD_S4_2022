<?php

namespace gamepedia\models;

use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    protected $table = 'commentaire';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = true;

    public function game() : \Illuminate\Database\Eloquent\Relations\belongsTo {
        return $this->belongsTo('gamepedia\models\Jeu', 'id_game');
    }

    public function user() : \Illuminate\Database\Eloquent\Relations\belongsTo {
        return $this->belongsTo('gamepedia\models\Utilisateur', 'email_utilisateur');
    }
}