#!/bin/bash

php bin/console doctrine:schema:drop --full-database --force --no-interaction # Détruit tout les tables
php bin/console doctrine:migrations:migrate --no-interaction # Création du schéma de BDD
php bin/console doctrine:schema:validate # Validation du schéma
php bin/console doctrine:fixtures:load --no-interaction # --group=test --no-interaction # Injection des données test dans la BDD

# préciser dans le terminal que le fichier est executable (rendre executable un fichier de script)avec la ligne chmod +x bin/dofilo.sh