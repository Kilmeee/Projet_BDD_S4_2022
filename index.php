<?php

use gamepedia\db\Eloquent;
use gamepedia\models\{Utilisateur, Commentaire};

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

Eloquent::start(__DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'conf.ini');







$u1 = new Utilisateur();
$u2 = new Utilisateur();

$c1 = new Commentaire();
$c2 = new Commentaire();
$c3 = new Commentaire();

$u1->email = "keanuharrell@hotmail.fr";
$u1->nom = "Harrell";
$u1->prenom = "Keanu";
$u1->adressedetail = "49 rue de Laxou, 54000, Nancy";
$u1->tel = "0695098351";
$u1->dateNaiss = date_create_from_format("Y-m-d", "2002-05-01");

$u2->email = "pauladnet@hotmail.fr";
$u2->nom = "Adnet";
$u2->prenom = "Paul";
$u2->adressedetail = "23 rue de l'Abbé Gridel, 54000, Nancy";
$u2->tel = "0768249094";
$u2->dateNaiss = date_create_from_format("Y-m-d", "2003-04-02");

$u1->save();
$u2->save();