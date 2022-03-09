<?php

use gamepedia\db\Eloquent;
use gamepedia\models\{Compagnie, Jeu, Plateforme};

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
Eloquent::start(__DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'conf.ini');

//Q3
$jeuxSony = Jeu::where('compagnie_id', '=', Compagnie::where('nom', 'like', '%Sony%')->first()->id)->get();
foreach($jeuxSony as $jeu) {
    echo $jeu->nom . '<br>';
}

//Q4
$ratingsMario = Rating::has('jeux', function($j){
    $j->where('nom', 'like', '%Mario%');
})->get();