#!/bin/bash

php bin/console doctrine:schema:drop --full-database --force --no-interaction # Détruit tout les tables
php bin/console doctrine:migrations:migrate --no-interaction # Création du schéma de BDD
php bin/console doctrine:schema:validate # Validation du schéma

# préciser dans le terminal que le fichier est executable (rendre executable un fichier de script)avec la ligne chmod +x bin/dofilo.sh