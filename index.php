<?php

use gamepedia\db\Eloquent;
use gamepedia\models\Commentaire;
use gamepedia\models\Jeu;

use Faker\Factory as Faker;
use gamepedia\models\Utilisateur;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

Eloquent::start(__DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'conf.ini');

$com = new Commentaire();
$com->titre = "kinu are hell";
$com->contenu = "random informations for the first comment, kinu le gaulois";
$com->date_creation = date_create_from_format('Y-m-d',"2022-03-23");
$com->email_utilisateur = "keanuharrell@hotmail.fr";
$com->id_game = 12342;

$com1 = new Commentaire();
$com1->titre = "kinu a la dinette";
$com1->contenu = "keanu gambade vers le jeu du sujet";
$com1->date_creation = date_create_from_format('Y-m-d',"2022-03-22");
$com1->email_utilisateur = "keanuharrell@hotmail.fr";
$com1->id_game = 12342;

$com2 = new Commentaire();
$com2->titre = "kinu part jouer a lol";
$com2->contenu = "kinu est une jeune pousse qui a un mac a 14 pouces";
$com2->date_creation = date_create_from_format('Y-m-d',"2022-03-18");
$com2->email_utilisateur = "keanuharrell@hotmail.fr";
$com2->id_game = 12342;

/*********************************/

$com3 = new Commentaire();
$com3->titre = "pol en ski";
$com3->contenu = "random informations for the 4th comment, polochon";
$com3->date_creation = date_create_from_format('Y-m-d',"2022-03-23");
$com3->email_utilisateur = "pauladnet@hotmail.fr";
$com3->id_game = 12342;

$com4 = new Commentaire();
$com4->titre = "pol a la récré";
$com4->contenu = "Integer gravida sodales nulla, sed ultricies augue pharetra sit amet. Fusce blandit vel diam a tincidunt. Integer augue sem, rhoncus quis nulla non, gravida semper nisi.";
$com4->date_creation = date_create_from_format('Y-m-d',"2022-03-20");
$com4->email_utilisateur = "pauladnet@hotmail.fr";
$com4->id_game = 12342;

$com5 = new Commentaire();
$com5->titre = "pol et ses godasses";
$com5->contenu = " Aliquam eget libero purus. Morbi vestibulum lacus massa, in pharetra ipsum hendrerit eget.";
$com5->date_creation = date_create_from_format('Y-m-d',"2022-03-23");
$com5->email_utilisateur = "pauladnet@hotmail.fr";
$com5->id_game = 12342;


$com->save();
$com1->save();
$com2->save();

$com3->save();
$com4->save();
$com5->save();



















