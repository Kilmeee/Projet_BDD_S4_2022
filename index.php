<?php

use gamepedia\db\Eloquent;
use gamepedia\models\Jeu;
use gamepedia\models\Utilisateur;
use gamepedia\models\Commentaire;
use Faker\Factory as Faker;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

Eloquent::start(__DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'conf.ini');

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

$com = Utilisateur::find('Louis.Michèle8@gmail.com')->commentaires()->get()->sortByDesc('created_at');
foreach($com as $c){
    echo $c->contenu."\n";
    echo $c->created_at."\n";
}
