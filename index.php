<?php

use gamepedia\db\Eloquent;
use gamepedia\models\Jeu;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

Eloquent::start(__DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'conf.ini');

print_r("Q1 : \n");
$gamesMario = Jeu::where('name', 'LIKE', '%Mario%')->get();
foreach ($gamesMario as $game) {
    print_r($game->name . "\n");
}









print_r("Q5 : \n\n");
$page = readline("Quelle page souhaitez-vous ?");
while($page <= 0) $page = readline("ERREUR\nMettez une page positive.");
$allGames = Jeu::where('id', '>', 500*($page-1))->limit(500);
foreach ($allGames as $game) {
    print_r("\t" . $game->id . " : " . $game->name . " " . $game->deck . "\n");
}