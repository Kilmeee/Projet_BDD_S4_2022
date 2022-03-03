<?php

use gamepedia\db\Eloquent;
use gamepedia\models\{Plateforme, Jeu};

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

Eloquent::start(__DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'conf.ini');

print_r("Q1 : \n");
$gamesMario = Jeu::where('name', 'LIKE', '%Mario%')->get();
foreach ($gamesMario as $game) {
    print_r($game->name . "\n");
}

//Q3
print_r("Q3 : \n");
$installBasePlat = Plateform::where('install_base', '>=', '10000000')->get();
foreach ($installBasePlat as $plat) {
    print_r($plat->name . "\n");
}
