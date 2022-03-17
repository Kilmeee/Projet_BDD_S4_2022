# Projet_BDD_S4_2022

# Préparation à la séance 04

---

# Question 1 :

Faker s'installe en utilisant la commande suivante :

```php
composer require fakerphp/faker
```

Puis dans le code :

```php
use Faker\Factory;
$faker = Factory::create();
```

# Question 2 :

La création de cette variable permet d'initialiser le générateur.

Pour générer une adresse américaine :

```php
use Faker\Factory as Faker;
$faker = Faker::create('en_US');
echo $faker->address();
// Outputs: "19412 Estell Prairie, Steuberland, MT 65322-1356"
```

# Question 3 :

Pour formatter un objet DateTime en chaine de caractère, on utilise :

```php
$date = new DateTime('2017-02-16 16:15:00');
echo $date->format('Y/m/d (H:i)');
// Output : 2017/02/16 (16:15)
```