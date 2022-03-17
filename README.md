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
### Q5 :
Temps d'exécution avec 3 valeurs différentes sans index :

Moyenne : **590.7 millisecondes.**

Nous pouvons constater que les requêtes prennent un certain temps jusqu'à une demi seconde en moyenne.

**Temps d'exécution avec 3 valeurs différentes avec index :**

![image](https://user-images.githubusercontent.com/49103056/158778539-e324dd27-feac-4271-9baf-8f34a6c8422e.png)

Moyenne : **177.1 millisecondes.**


![image](https://user-images.githubusercontent.com/49103056/158780765-e44317ed-6bf6-4ee6-b3fc-a065c0bbf3ff.png)

Nous pouvons constater que les requêtes sont effectivement bien plus rapide grâce à l'index.

---

# Partie 2 :
