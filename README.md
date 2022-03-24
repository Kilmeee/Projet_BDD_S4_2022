# Projet_BDD_S4_2022

# Séance 04
```sql
CREATE TABLE utilisateur(
    email varchar(128) primary key,
    nom varchar(128),
    prenom varchar(128),
    adressedetail varchar(128),
    tel int(14),
    dateNaiss date
)
```


```sql
CREATE TABLE commentaire (
    id INT(11) NOT NULL AUTO_INCREMENT,
    titre VARCHAR(128),
    contenu VARCHAR(128),
    date_creation VARCHAR(128),
    created_at DATETIME,
    updated_at DATETIME,
    email_utilisateur VARCHAR(128),
    id_game INT(11),
    PRIMARY KEY (id)    
        
);

ALTER TABLE commentaire ADD CONSTRAINT FK_CommentaireUtilisateur FOREIGN KEY (email_utilisateur) REFERENCES utilisateur(email);
ALTER TABLE commentaire ADD CONSTRAINT FK_CommentaireGame FOREIGN KEY (id_game) REFERENCES game(id);
```







### Préparation de séance disponible [ici](preparation)