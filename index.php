<?php

use gamepedia\db\Eloquent;
use gamepedia\models\{Compagnie, Jeu, Personnage};

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
Eloquent::start(__DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'conf.ini', true);

ini_set('memory_limit', '-1');

/*-----------Partie 1-----------*/

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

//Q3
print_r("Q3 : \n");
$start3 = hrtime(true);
$marioGames = Jeu::where('name', 'like', 'Mario%')->get();
foreach ($marioGames as $mc) {
    $tmp = $mc->characters;
}
$end3 = hrtime(true);
$time3 = number_format((($end3 - $start3)/1e+6), 2, '.', ' ');
print_r("Temps execution : " . $time3 . "\n");

//Q4
print_r("Q4 :\n");
$start4 = hrtime(true);
$jeux = Jeu::where('name', 'like', 'Mario%')->whereHas('ratings', function ($q) {
    $q->where('name', 'like', '%3+%');
})->get();
$end4 = hrtime(true);
$time4 = number_format((($end4 - $start4)/1e+6), 2, '.', ' ');
print_r("Temps execution : " . $time4 . "\n");

// Q5, Q6, Q7
print_r("Q5, Q6, Q7 :\n");
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

/*-----------Partie 2-----------*/

//Q1
$marioGames = Jeu::where('name', 'LIKE', '%Mario%')->get();

//Q2
$char1234 = Jeu::find(1234)->characters;

//Q3
$faMario = Personnage::whereHas('firstGame', function ($query) {
    $query->where('name', 'LIKE', "%Mario%");
})->get();

//Q4
$charMario = Jeu::where('name', 'LIKE', "%Mario%")->get();
foreach ($charMario as $game) {
    $tmp = $game->characters;
}

//Q5
$sonyGames = Compagnie::where('name', 'LIKE', "%Sony%")->get();
foreach ($sonyGames as $game) {
    $tmp = $game->games;
}

//Affichage
displayQueryLog();

/**
 * Display the query log for debugging
 * Formatted for console
 * @return void
 */
function displayQueryLog(): void
{
    foreach (Eloquent::getQueryLog() as $querylogItem) {
        print_r("\n Requête SQL : " . $querylogItem['query'] . "\n");
        print_r("\t Paramètres : " . json_encode($querylogItem['bindings']) . "\n");
        print_r("\t Durée : " . $querylogItem['time'] . " ms\n");
    }
}