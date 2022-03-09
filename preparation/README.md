# Projet_BDD_S4_2022

# Préparation à la séance 02

---

## Question 1 :

---

## Question 2 :

Modèle Annonce : **Relation hasMany**

```php
<?php

namespace name\models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasMany;

class Annonce extends Model
{

    protected $table = 'annonce';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
    public $guarded = [];
    
    /**
    * Récupération des photos d'une annonce 
    * Utilisation de la relation hasMany 
    * @return HasMany relation
    */
    public function photos()
    {
        return $this->hasMany('name\models\Photo', 'id_annonce');
    }
}
```

Modèle Photo : **Relation belongsTo**

```php
<?php

namespace name\models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{

    protected $table = 'photo';
    protected $primaryKey = 'id';
    public $incrementing = true;
    public $timestamps = false;
    public $guarded = [];
    
    /**
    * Récupération de l'annonce d'une photo  
    * Utilisation de la relation belongsTo 
    * @return BelongsTo relation
    */
    public function annonce()
    {
        return $this->belongsTo('name\models\Annonce', 'id_annonce');
    }
}
```

---

## Question 3 :

### 3.1 :

### 3.2 :

### 3.3 :

```php
<?php

use name\models\{Annonce, Photo, Categorie};

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
Eloquent::start(__DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'conf' . DIRECTORY_SEPARATOR . 'conf.ini');

$annonces = [];
foreach (Annonce::all() as $annonce) {
    if($annonce->photos()->count() > 3) {
        $annoncesR[] = $annonce;
    }
}
```

### 3.4 :

---

## Question 4 :

---
```php
use name\models\{Annonce, Photo, Categorie};
$photo = new Photo();
$photo->file = "Photo";
$photo->date = "02/10/2022";
$photo->taille_octet = "0";
$annonce = Annonce::find('22');
$annonce->photos()->save($photo);




```

## Question 5 :
```php
use name\models\{Annonce, Photo, Categorie};
$annonce = Annonce::find('22');
$categ42 = Categorie::find('42');
$categ73 = Categorie::find('73');
$categ42->annonces()->save($annonce);
$categ73->annonces()->save($annonce);
```
