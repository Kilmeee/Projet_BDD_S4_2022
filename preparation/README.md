# Projet_BDD_S4_2022

# Préparation à la séance 03

---

# Partie 1 :

### Question 1 :

```php
<?php
$start=hrtime(true);
$end=hrtime(true);
$time=$end-$start;
echo $time/1e+6;
```

### Question 2 :

L'index a pour intérêt d'accélérer l'exécution d'une requête SQL qui lit des données et ainsi améliorer les performances d’une application utilisant une base de données. Celui-ci est principalement utilisé lorsqu'une colonne est trop grosse afin de pouvoir séparer en petits morceaux la colonne. Ceci dans le but de pouvoir rechercher sur des parties plus restreintes, plutôt que de rechercher directement sur l’entièreté de la colonne.

---

# Partie 2 :

### Question 1 :

//TODO

### Question 2 :

Le problème des **N+1 Query** est que lorsque on veut par exemple afficher un attribut d'une classe B correspondant à une relation d'une classe A, il faut faire une requête pour tous les elements de la classe A.

Exemple :

```php
<?php

use name\models\{A, B}

foreach (A::all() as $a) {
    print_r($a->b->attribut);
}
```
Si on a par exemple 13 lignes dans la table A, on devra faire 14 requêtes pour cette execution.

Je vous laisse imaginer si la table A contenait 300000 lignes.

Pour cela une solution (avec Eloquent) : On récupère d'abord tous les élements de la classe A possédant l'attribut B

```php
<?php

use name\models\{A, B}

$as = A::with('b')->get();

foreach ($as as $a) {
    print_r($a->b->attribut);
}
```
