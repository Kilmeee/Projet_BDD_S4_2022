<?php

use gamepedia\db\Eloquent;
use gamepedia\models\{Jeu, Utilisateur, Commentaire};
use Faker\Factory as Faker;


require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

Eloquent::start(__DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'conf.ini');


// PARTIE 1

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

/********** COMMENTAIRES USER 2 ***************/

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


// PARTIE 2

$faker = Faker::create('fr_FR');
for ($i = 1; $i <= 25000; $i++) {
    $user = new Utilisateur();
    $nom = $faker->lastName();
    $prenom =$faker->firstName();
    $user->email = $nom.$faker->randomDigit().".".$prenom.$faker->randomDigit()."@gmail".$faker->randomDigit().".com";
    $user->nom = $nom;
    $user->prenom = $prenom;
    $user->adressedetail = $faker->address();
    $user->tel = $faker->phoneNumber();
    $user->dateNaiss = $faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d');
    $user->save();
    for($i = 1; $i <= 10; $i++){
        $commentaire = new Commentaire();
        $commentaire->id_game = $faker->numberBetween(1, 25000);
        $commentaire->email_utilisateur = $user->email;
        $commentaire->contenu = $faker->text(50);
        $commentaire->save();
    }
}
