# Pour le TestController

Il faut installer:
    - composer install
    - composer require symfony/webpack-encore-bundle
    - npm run build

# Project library

Cette application à pour but de gérer une liste d'abonnés qui veulent emprunter des livres d'auteurs.

## Cahier des charges

### Borrower

Cette classe représente un emprunteur.

    - id: primary key
    - firstname: varchar 190
    - lastname: varchar 190
    - phone: varchar 190, unique, nullable
    - active: boolean
    - creation_date: datetime
    - modification_date: datetime, nullable

Relation(s):

    - Loan: one to many
    - User: one to one, unidirectional

### Loan

Cette classe représente l'emprunt en lui même.

    - id: primary key
    - borrowing_date: datetime
    - return_date: datetime

Relation(s):

    - Borrower: many to one
    - Book: many to one

### Book

Cette classe représente les livres qui peuvent être empruntés.

    - id: primary key
    - title: varchar 190
    - publication_year: date
    - number_of_pages: int
    - isbn_code: varchar 190, unique

Relation(s):

    - Loan: one to many
    - Author: many to one
    - Type: many to many

### Author

Cette classe représente les auteurs pour chaque livre. (Il n'y a qu'un seul auteur possible par livre)

    - id: primary key
    - firstname: varchar 190
    - lastname: varchar 190

Relation(s):

    - Book: one to many

### Type

Cette classe représente le genre du livre.

    - id: primary key
    - name: varchar 190
    - description: text, nullable

Relation(s):

    - Book: many to many

### User

Cette classe représente un compte d'utilisateur qui peut se connecter à l'application.

- Structure par défaut proposé par Symfony

    - id: primary key
    - email: varchar 190, unique
    - password: varchar 190
    - role: text

### Arbre de épendances des entités

    - Author
    - Book
        - Author
    - Borrower
        - User
    - Loan
        - Borrower
    - Type
        - Book
    - User