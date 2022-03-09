<?php

use gamepedia\db\Eloquent;
use gamepedia\models\{Compagnie, Genre, Jeu, Plateforme, Rating};

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
Eloquent::start(__DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'conf.ini');

// Q1
print("Question 1 : \n\n");
$charactersGame = Jeu::find('12342')->characters()->get();
foreach ($charactersGame as $character){
    print($character->name . ', ' . $character->deck . "\n");
}
print("\n");


// Q2
print("Question 2 : \n\n");
$marioGames = Jeu::where('name','like','Mario%')->get();
foreach ($marioGames as $mc){
    foreach ($mc->characters as $character){
        print($character->name . "\n");
    }
}
print("\n");






































//Q3
print_r("Q3 :\n");
$compagnies = Compagnie::where('name', 'like', '%Sony%')->has('jeuxDeveloppes')->get();
foreach ($compagnies as $compagny) {
    echo $compagny->name . "\n";
    foreach ($compagny->jeuxDeveloppes as $jeu) {
        print_r("\t".$jeu->name . "\n");
    }
}
print_r("\n");

//Q4
print_r("Q4 :\n");
$ratingsMario = Rating::whereHas('jeux', function ($j) {
    $j->where('name', 'like', '%Mario%');
})->get();
foreach ($ratingsMario as $rating) {
    echo $rating->ratingBoard->deck . " -> " . $rating->name . "\n";
}
print_r("\n");

// Q5
print_r("Q5 :\n");
$jeux = Jeu::where('name', 'like', 'Mario%')->has('characters', '>', '3')->get();
foreach($jeux as $jeu) {
    print($jeu->name . "\n");
}
print_r("\n");

// Q6
print_r("Q6 :\n");
$jeux = Jeu::where('name', 'like', 'Mario%')->whereHas('ratings', function($q) {
    $q->where('name', 'like', '%3+%');
})->get();
foreach($jeux as $jeu) {
    print($jeu->name . "\n");
}
print_r("\n");

//Q7
print_r("Q7 :\n");
$jeux = Jeu::where('name', 'like', 'Mario%')->whereHas('publishers', function ($query) {
    $query->where('name', 'like', '%Inc.%');
})->whereHas('ratings', function ($query) {
    $query->where('name', 'like', '%3+%');
})->get();
foreach ($jeux as $jeu) {
    echo $jeu->name . "\n";
}

//Q8
print_r("Q8 :\n");
$jeux = Jeu::where('name', 'like', 'Mario%')->whereHas('publishers', function ($query) {
    $query->where('name', 'like', '%Inc%');
})->whereHas('ratings', function ($query) {
    $query->where('name', 'like', '%3+%');
})->whereHas('ratings.ratingBoard', function ($query) {
    $query->where('name', 'LIKE', 'CERO');
})->get();
foreach ($jeux as $jeu) {
    echo $jeu->name . "\n";
}
print_r("\n");

// Q9
print_r("Q9 :\n");
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
print_r("\n");