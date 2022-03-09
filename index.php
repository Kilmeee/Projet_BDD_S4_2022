<?php

use gamepedia\db\Eloquent;
use gamepedia\models\{Compagnie, Genre, Jeu, Plateforme, Rating};

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
Eloquent::start(__DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'conf.ini');


// Q3
$jeuxSony = Jeu::whereHas('compagnies', function ($query) {
    $query->where('name', '%Sony%');
})->get();
foreach($jeuxSony as $jeu){
    echo $jeu->name . "\n";
}

// Q4
$ratingsMario = Rating::whereHas('jeux', function($j){
    $j->where('name', 'like', '%Mario%');
})->get();
foreach($ratingsMario as $rating) {
    echo $rating->ratingBoard->name. " ".$rating->nom . "\n";
}

// Q5

$jeux = Jeu::where('name', 'like', 'Mario%')->has('characters', '>', '3')->get();
foreach($jeux as $jeu) {
    print($jeu->name . "\n");
}

// Q6

$jeux = Jeu::where('name', 'like', 'Mario%')->whereHas('ratings', function($q) {
    $q->where('name', 'like', '%3+%');
})->get();

foreach($jeux as $jeu) {
    print($jeu->name . "\n");
}





















// Q9

$genre = new Genre();
$genre->name = "test";
$genre->deck = "test";
$genre->description = "test";
$jeu12 = Jeu::find('12');
$jeu56 = Jeu::find('56');
$jeu345 = Jeu::find('345');

$jeu12->genres()->save($genre);
$jeu56->genres()->save($genre);
$jeu345->genres()->save($genre);

echo(Genre::where('name', '=', 'test')->first());

Genre::where('name', '=', 'test')->delete();

echo(Genre::where('name', '=', 'test')->first());