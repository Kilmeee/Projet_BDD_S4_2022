# Projet_BDD_S4_2022

# Préparation à la séance 03

---

# Partie 1 :

### Question 1 :

//TODO

### Question 2 :

//TODO

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