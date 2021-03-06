## Procédure à suivre pour faire les tests avec TestController


### Installer les dépendances
    - composer install


### Lancer le serveur Web via le terminal
    - symfony serve


### Ouvrir l'url via le navigateur
    - http://127.0.0.1:8000/test



## Les requêtes


### Les utilisateurs

Requêtes de lecture :

    - la liste complète de tous les utilisateurs (de la table `user`)
    DONE

    - les données de l'utilisateur dont l'id est `1`
    DONE

    - les données de l'utilisateur dont l'email est `user1@example.com`
    DONE

    - les données des utilisateurs dont l'attribut `roles` contient le mot clé `ROLE_BORROWER`
    DONE


### Les livres

Requêtes de lecture :

    - la liste complète de tous les livres
    DONE
    - les données du livre dont l'id est `1`
    DONE
    - la liste des livres dont le titre contient le mot clé `elle`
    DONE

    - la liste des livres dont l'id de l'auteur est `2`
    DONE

    - la liste des livres dont le genre contient le mot clé `roman`
    DONE


Requêtes de création :

    - ajouter un nouveau livre
    DONE
    - titre : Totum autem id externum
    DONE
    - année d'édition : 2020
    DONE
    - nombre de pages : 300
    DONE
    - code ISBN : 9790412882714
    DONE
    - auteur : Philippine Gilles (id `2`)
    DONE
    - genre : science-fiction (id `1`)
    DONE


Requêtes de mise à jour :

    - modifier le livre dont l'id est `2`
    DONE
    - titre : Aperiendum est igitur
    DONE
    - genre : roman d'aventure (id `6`)
    DONE


Requêtes de suppression :

    - supprimer le livre dont l'id est `123`
    DONE


### Les emprunteurs

Requêtes de lecture :

    - la liste complète des emprunteurs
    DONE
    - les données de l'emprunteur dont l'id est `3`
    DONE
    - les données de l'emprunteur qui est relié au user dont l'id est `3`
    DONE
    - la liste des emprunteurs dont le nom ou le prénom contient le mot clé `Albert`
    DONE
    - la liste des emprunteurs dont le téléphone contient le mot clé `1234`
    DONE
    - la liste des emprunteurs dont la date de création est antérieure au 01/03/2021 exclu (c-à-d strictement plus petit)
    DONE
    - la liste des emprunteurs inactifs (c-à-d dont l'attribut `actif` est égal à `false`)
    DONE


### Les emprunts

Requêtes de lecture :

    - la liste des 10 derniers emprunts au niveau chronologique
    DONE
    - la liste des emprunts de l'emprunteur dont l'id est `2`
    DONE
    - la liste des emprunts du livre dont l'id est `3`
    DONE
    - la liste des emprunts qui ont été retournés avant le 01/01/2021
    DONE
    - la liste des emprunts qui n'ont pas encore été retournés (c-à-d dont la date de retour est nulle)
    DONE
    - les données de l'emprunt du livre dont l'id est `3` et qui n'a pas encore été retournés (c-à-d dont la date de retour est nulle)
    DONE


Requêtes de création :

    - ajouter un nouvel emprunt
    DONE
    - date d'emprunt : 01/12/2020 à 16h00
    DONE
    - date de retour : aucune date
    DONE
    - emprunteur : foo foo (id `1`)
    DONE
    - livre : Lorem ipsum dolor sit amet (id `1`)
    DONE


Requêtes de mise à jour :

    - modifier l'emprunt dont l'id est `3`
    DONE
    - date de retour : 01/05/2020 à 10h00
    DONE


Requêtes de suppression :

    - supprimer l'emprunt dont l'id est `42`
    DONE
