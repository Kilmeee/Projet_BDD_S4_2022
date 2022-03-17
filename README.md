# Projet_BDD_S4_2022

# Séance 03

### Préparation de séance disponible [ici](preparation)

---

# Partie 1 :

Mesure du temps d'exécution :
```php
<?php
$start = hrtime(true);
//TODO REQUETE
$end = hrtime(true);
$time = number_format((($end1 - $start1)/1e+6), 2, '.', ' ');
```

### Q1 :
Temps d'exécution de la requête qui liste l'ensemble des jeux: **135 000.86 millisecondes.**
### Q2 :
Temps d'exécution de la requête qui liste les jeux dont le nom contient 'Mario' : **1 091.39 millisecondes.**
### Q3 :
Temps d'exécution de la requête qui liste les personnages des jeux dont le nom débute par 'Mario' : **3 938.84 millisecondes.**
### Q4 :
Temps d'exécution de la requête qui liste les jeux dont le nom débute par 'Mario' et dont le rating initial contient '3+' : **612.02 millisecondes.**
### Q5-7 :
**Temps d'exécution avec 3 valeurs différentes sans index :**

![image](https://user-images.githubusercontent.com/49103056/158780765-e44317ed-6bf6-4ee6-b3fc-a065c0bbf3ff.png)

Moyenne : **590.7 millisecondes.**

Nous pouvons constater que les requêtes prennent un certain temps jusqu'à une demi seconde en moyenne.

**Temps d'exécution avec 3 valeurs différentes avec index :**

![image](https://user-images.githubusercontent.com/49103056/158778539-e324dd27-feac-4271-9baf-8f34a6c8422e.png)

Moyenne : **177.1 millisecondes.**

Nous pouvons constater que les requêtes sont effectivement bien plus rapide grâce à l'index.

---

# Partie 2 :

### Q1 :

```
Requête Originale : Jeu::where('name', 'LIKE', '%Mario%')->get();
Requête SQL : select * from `game` where `name` LIKE ?
Paramètres : ["%Mario%"]
Durée : 2765.94 ms
```

### Q1 :

```
Requête Originale : Jeu::where('name', 'LIKE', '%Mario%')->get();
Requête SQL : select * from `game` where `name` LIKE ?
Paramètres : ["%Mario%"]
Durée : 2765.94 ms
----
Nombre de requêtes : 1
```

### Q2 :

```
Requête Originale : Jeu::find(1234)->characters;
Requête SQL : select * from `game` where `game`.`id` = ? limit 1
Paramètres : [1234]
Durée : 54.92 ms
----
Requête SQL : select `character`.*, `game2character`.`game_id` as `pivot_game_id`, `game2character`.`character_id` as `pivot_character_id` from `character` inner join `game2character` on `character`.`id` = `game2character`.`character_id` where `game2character`.`game_id` = ?
Paramètres : [1234]
Durée : 37.06 ms
----
Nombre de requêtes : 2
```

### Q3 :

```
Requête Originale : Personnage::whereHas('firstGame', function ($query) {
    $query->where('name', 'LIKE', "%Mario%");
})->get();
Requête SQL : select * from `character` where exists (select * from `game` where `character`.`first_appeared_in_game_id` = `game`.`id` and `name` LIKE ?)
Paramètres : ["%Mario%"]
Durée : 1657.18 ms
----
Nombre de requêtes : 1
```

### Q4 :

```
Requête Originale : Jeu::where('name', 'LIKE', "%Mario%")->get();
Requête SQL : select * from `game` where `name` LIKE ?
Paramètres : ["%Mario%"]
Durée : 1258.86 ms
----
Nombre de jeux : 158
Nombre de requêtes : 159
Temps total : 49843.32 ms
```

### Q5 :

```
Requête Originale : Compagnie::where('name', 'LIKE', "%Sony%")->get();
Requête SQL : select * from `company` where `name` LIKE ?
Paramètres : ["%Sony%"]
Durée : 29.6 ms
----
Nombre de compagnies : 13
Nombre de requêtes : 14
Temps total : 5495.6 ms
```

## Chargements liés :

### Q4 :

Avant :
```
Nombre de requêtes : 159
Temps total : 49843.32 ms
```

Apres : 

```
Requête originale : Jeu::where('name', 'LIKE', "%Mario%")->with('characters')->get();
Requête SQL : select * from `game` where `name` LIKE ?
Paramètres : ["%Mario%"]
Durée : 273.53 ms
Requête SQL : select `character`.*, `game2character`.`game_id` as `pivot_game_id`, `game2character`.`character_id` as `pivot_character_id` from `character` inner join `game2character` on `character`.`id` = `game2character`.`character_id` where `game2character`.`game_id` in (506, 750, 983, 1217, 1450, 2611, 2669, 3111, 3898, 3979, 4240, 4337, 4747, 4954, 5321, 5461, 5529, 5753, 5851, 5949, 6044, 6105, 6184, 6310, 6408, 6420, 6518, 6649, 6691, 6736, 6805, 6829, 6868, 6948, 7484, 7610, 7628, 8003, 8145, 8479, 9191, 9392, 9982, 10050, 10219, 11104, 11355, 11367, 11382, 11626, 11722, 12419, 12924, 13146, 13455, 13470, 13845, 14024, 14059, 14158, 14648, 15142, 15265, 16070, 16237, 16650, 16866, 17073, 17350, 17366, 17489, 17841, 17922, 17929, 18023, 18103, 18137, 18217, 18755, 18800, 18852, 19027, 19051, 19236, 19247, 19249, 19253, 20250, 20614, 20687, 20968, 21716, 22293, 22294, 22573, 22829, 22830, 22831, 22889, 22917, 23556, 23557, 24307, 24309, 24317, 24322, 24323, 24722, 24800, 26188, 26189, 27186, 27216, 27217, 27219, 27220, 27221, 27222, 27224, 27225, 27332, 28846, 28858, 28863, 28871, 29111, 31162, 31772, 31857, 31911, 32092, 32307, 32310, 33060, 34575, 35507, 35641, 37819, 37878, 37879, 37885, 38543, 38787, 39043, 39045, 41653, 42338, 42550, 42556, 42557, 42728, 44450, 44823, 45710, 45711, 45901, 45902, 47401)
Paramètres : []
Durée : 51.51 ms
----
Nombre de requêtes : 2
Temps total : 325.04 ms
```

On utilise la méthode SQL [**IN**](https://sql.sh/cours/where/in).

### Q5 :

Avant :
```
Nombre de requêtes : 14
Temps total : 5495.6 ms
```

Apres :

```
Requête originale : Compagnie::where('name', 'LIKE', "%Sony%")->with('jeuxDeveloppes')->get();
Requête SQL : select * from `company` where `name` LIKE ?
Paramètres : ["%Sony%"]
Durée : 34.43 ms
Requête SQL : select `game`.*, `game_developers`.`comp_id` as `pivot_comp_id`, `game_developers`.`game_id` as `pivot_game_id` from `game` inner join `game_developers` on `game`.`id` = `game_developers`.`game_id` where `game_developers`.`comp_id` in (142, 362, 971, 1338, 2134, 3068, 3366, 4803, 4911, 6182, 6465, 8012, 11294)
Paramètres : []
Durée : 35.11 ms
----
Nombre de requêtes : 2
Temps total : 69.54 ms
```