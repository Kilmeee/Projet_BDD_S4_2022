<?php

use gamepedia\db\Eloquent;
use gamepedia\models\{Jeu};

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
Eloquent::start(__DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'conf.ini', true);

ini_set('memory_limit', '-1');
// Partie 1

// //Q1
// print_r("Q1 : \n");
// $start1 = hrtime(true);
// $q1 = Jeu::all();
// $end1 = hrtime(true);
// $time1 = number_format((($end1 - $start1)/1e+6), 2, '.', ' ');
// print_r("Temps execution : " . $time1 . "\n");

// //Q2
// print_r("Q2 : \n");
// $start2 = hrtime(true);
// $marioGames = Jeu::where('name', 'like', '%Mario%')->get();
// $end2 = hrtime(true);
// $time2 = number_format((($end2 - $start2)/1e+6), 2, '.', ' ');
// print_r("Temps execution : " . $time2 . "\n");

// //Q3
// print_r("Q3 : \n");
// $start3 = hrtime(true);
// $marioGames = Jeu::where('name', 'like', 'Mario%')->get();
// foreach ($marioGames as $mc) {
//     foreach ($mc->characters as $character) {
//     }
// }
// $end3 = hrtime(true);
// $time3 = number_format((($end3 - $start3)/1e+6), 2, '.', ' ');
// print_r("Temps execution : " . $time3 . "\n");

// //Q4
// print_r("Q4 :\n");
// $start4 = hrtime(true);
// $jeux = Jeu::where('name', 'like', 'Mario%')->whereHas('ratings', function ($q) {
//     $q->where('name', 'like', '%3+%');
// })->get();
// foreach ($jeux as $jeu) {
// }
// $end4 = hrtime(true);
// $time4 = number_format((($end4 - $start4)/1e+6), 2, '.', ' ');
// print_r("Temps execution : " . $time4 . "\n");


// Q5, Q6, Q7
$start1=hrtime(true);
$games1 = Jeu::where('name', 'like', 'Spyro%')->get();
foreach ($games1 as $g1) {
    print_r($g1->name . "\n");
}
$end1=hrtime(true);
$time1=number_format(($end1-$start1)/1e+6, 1, '.', '');


$start2=hrtime(true);
$games2 = Jeu::where('name', 'like', 'Crash Bandicoot%')->get();
foreach ($games2 as $g2) {
    print_r($g2->name . "\n");
}
$end2=hrtime(true);
$time2=number_format(($end2-$start2)/1e+6, 1, '.', '');


$start3=hrtime(true);
$games3 = Jeu::where('name', 'like', 'Warcraft%')->get();
foreach ($games3 as $g3) {
    print_r($g3->name . "\n");
}
$end3=hrtime(true);
$time3=number_format(($end3-$start3)/1e+6, 1, '.', '');

print_r("Avec index\n\nTemps d'exécution Tomb Raider : $time1 ms\nTemps d'exécution Crash Bandicoot : $time2 ms\nTemps d'exécution Warcraft : $time3 ms\n\n");
