>>> voir la pagination.
ch'é chtilal

## Les pages



### Entête
>>> on retrouve sur toutes les pages


L'entête du site doit afficher un menu qui propose :
>>> menu bootstrap en html css qui pointe vers accueil (c'est "/")

>>> pour les liens qui ne sont pas accessible par tous:
{% if is_granted('ROLE_ADMIN')%}
    // le lien accessible uniquement par l'admin
{% endif %}
il faut avoir défini dans la BDD que ses rôles existent.
(Dans le controller En php ça s'écris $this->is_granted ('ROLE_ADMIN'))
et dans le fichier sécurity.yamlb (voir le repo-src-symfony-p8)
>>> - { path... 'ROLE_ADMIN', 'ROLE_STUDENT'}
****** un pb le student ne doit pas pouvoir delete d'autres students.
sur la page des students, il faut détecter si c'est un student qui est log. du coup les données affiché sont que ses données à lui. 
voir le show de student controller avec la fonction redirectStudent... dans function show(...)
(qui est aussi utiliser dans la function edit(...))



  - navbar
  DONE
  - un lien clickable qui pointe vers la page d'accueil
  DONE
  - un lien clickable nommé `login` qui permet d'accéder à la page d'authentification (`/login`)
  DONE


Et si l'utilisateur est admin, le menu doit aussi proposer des liens vers :

A générer avec code twig

---------générer les adresses-------------
<a href="{{ path('book_index')}}">
----------------------

- la page liste des utilisateurs    >>> user Index -> CRUD DONE

- la page liste des livres          >>> book Index -> CRUD DONE

- la page liste des auteurs         >>> author Index -> CRUD DONE

- la page liste des genres          >>> type Index -> CRUD DONE

- la page liste des emprunteurs     >>> borrower Index -> CRUD DONE

- la page liste des emprunts        >>> loan Index -> CRUD DONE


### Page d'accueil



La page d'accueil, accessible par tout le monde, doit afficher un catalogue des livres.
DONE

Dans le catalogue des livres, le titre doit être un lien clickable qui pointe vers la page détails du livre.
DONE


- URL : `/`

- méthode : `GET`

- accessibilité : tout le monde



### Page détails d'un livre



La page détails d'un livre, accessible par tout le monde, doit afficher les données complètes d'un livre et doit aussi indiquer si le livre est disponible ou non (c-à-d s'il fait partie d'un emprunts non rendu ou pas).



- données :

- titre
DONE
- disponibilité
DONE
- année d'édition
DONE
- nombre de pages
DONE
- code ISBN
DONE
- auteur
DONE
- genre
DONE


- URL : `/livre/{id}`

- méthode : `GET`

- accessibilité : tout le monde



### Page d'authentification



La page d'authentification, accessible par tout le monde, doit afficher un formulaire d'authentification (email et mot de passe).
DONE
Les messages d'erreur doivent respecter les règles de sécurité.
DONE
Une authentification réussie doit rediriger l'utilisateur vers la page liste des emprunts.
DONE


- formulaire :

- email

- mot de passe



- résultats : redirection vers la page liste des emprunts



- URL : `/login`

- méthode : `GET`, `POST`

- accessibilité : tout le monde



### Pages CRUD des emprunts



Dans es pages CRUD des emprunts :



- la page liste des emprunts est accessibles par tout utilisateur authentifié (`ROLE_ADMIN` ou `ROLE_EMRUNTEUR`)
DONE
- la page détail d'un emprunt est accessible par tout utilisateur authentifié (`ROLE_ADMIN` ou `ROLE_EMRUNTEUR`)
DONE
- les autres pages (création, modification, suppression) ne sont accessibles que par les admins (`ROLE_ADMIN`)
DONE


Dans la page liste des emprunts :



- si l'utilisateur est un admin (`ROLE_ADMIN`), on peut afficher tous les emprunts
DONE
- si l'utilisateur est un emprunteur (`ROLE_EMRUNTEUR`), on ne doit afficher que ses emprunts
DONE


Dans la page détails d'un emprunt :


- si l'utilisateur est un admin (`ROLE_ADMIN`), il a accès à tous les emprunts
DONE
- si l'utilisateur est un emprunteur (`ROLE_EMRUNTEUR`) et qu'il essaie d'afficher un emprunt qui n'est pas à lui, il faut renvoyer une erreur `404 NOT FOUND`
DONE



- les pages de type CRUD des emprunts :

- URL : `/admin/emprunt`

méthode : `GET`

accessibilité : admin, emprunteur

- URL : `/admin/emprunt/new`

méthode : `GET`, `POST`

accessibilité : admin

- URL : `/admin/emprunt/{id}`

méthode : `GET`

accessibilité : admin, emprunteur

- URL : `/admin/emprunt/{id}/edit`

méthode : `GET`, `POST`

accessibilité : admin

- URL : `/admin/emprunt/{id}`

méthode : `DELETE`

accessibilité : admin



### Les autres pages de type CRUD



Les pages de type CRUD ne doivent être accessible que pour les utilisateurs de type admin.



Ces pages doivent permettre de gérer :



- des utilisateurs (de la table `user`)
DONE
- des livres
DONE
- des auteurs
DONE
- des genres
DONE
- des emprunteurs
DONE


- les pages de type CRUD des livres :

- URL : `/admin/livre`

méthode : `GET`

- URL : `/admin/livre/new`

méthode : `GET`, `POST`

- URL : `/admin/livre/{id}`

méthode : `GET`

- URL : `/admin/livre/{id}/edit`

méthode : `GET`, `POST`

- URL : `/admin/livre/{id}`

méthode : `DELETE`

- accessibilité : admin



Les autres pages de type CRUD sont construites en remplaçant le mot clé `livre` par la ressource correspondante.

Exemple : `/admin/user`, `/admin/auteur`, `/admin/genre`, etc.