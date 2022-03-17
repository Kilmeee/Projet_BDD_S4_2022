<?php

use gamepedia\db\Eloquent;
use gamepedia\models\Jeu;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
Eloquent::start(__DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'conf.ini');

//ini_set('memory_limit', '-1');
//Partie 1

//Q1
print_r("Q1 : \n");
$start1 = hrtime(true);
$q1 = Jeu::all();
$end1 = hrtime(true);
$time1 = number_format((($end1 - $start1)/1e+6), 2, '.', ' ');
print_r("Temps execution : " . $time1 . "\n");

//Q2
print_r("Q2 : \n");
$start2 = hrtime(true);
$marioGames = Jeu::where('name', 'like', '%Mario%')->get();
$end2 = hrtime(true);
$time2 = number_format((($end2 - $start2)/1e+6), 2, '.', ' ');
print_r("Temps execution : " . $time2 . "\n");

print_r("Q3 : \n");
$start3 = hrtime(true);
$marioGames = Jeu::where('name', 'like', 'Mario%')->get();
foreach ($marioGames as $mc) {
    foreach ($mc->characters as $character) {
    }
}
$end3 = hrtime(true);
$time3 = number_format((($end3 - $start3)/1e+6), 2, '.', ' ');
print_r("Temps execution : " . $time3 . "\n");

print_r("Q4 :\n");
$start4 = hrtime(true);
$jeux = Jeu::where('name', 'like', 'Mario%')->whereHas('ratings', function ($q) {
    $q->where('name', 'like', '%3+%');
})->get();
foreach ($jeux as $jeu) {
}
$end4 = hrtime(true);
$time4 = number_format((($end4 - $start4)/1e+6), 2, '.', ' ');
print_r("Temps execution : " . $time4 . "\n");