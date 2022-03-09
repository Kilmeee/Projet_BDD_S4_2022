<?php

use gamepedia\db\Eloquent;
use gamepedia\models\{Compagnie, Jeu, Plateforme, Rating};

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
Eloquent::start(__DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'conf.ini');








//Q3
$jeuxSony = Jeu::whereHas('compagnies', function ($query) {
    $query->where('name', '%Sony%');
})->get();
foreach($jeuxSony as $jeu){
    echo $jeu->name . "\n";
}

//Q4
$ratingsMario = Rating::whereHas('jeux', function($j){
    $j->where('name', 'like', '%Mario%');
})->get();
foreach($ratingsMario as $rating) {
    echo $rating->ratingBoard->name. " ".$rating->nom . "\n";
}