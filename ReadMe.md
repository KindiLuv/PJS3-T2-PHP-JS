# Site PJS3

Ce site fait partie d'un projet de 7 semaines decoupee en 2 missions, ce site etant la 2eme mision.

## Installation

Pour pouvoir ouvrir ce site correctement il va vous falloir plusieurs outils et etapes d'installation.


### Avoir un serveur local

Si vous avez deja un serveur @localhost alors vous pouvez sauter cette etape.Sinon:
En premier lieu, allez sur [ce site](https://laragon.org) et installez laragon pour votre OS. Ajoutez le bien a votre PATH lors de l'installation. A moins de savoir le faire (ce qui est etrange au vu de votre lecture de ce ReadMe), ne mettez pas d'URL custom.

## Heberger la Base de Donnees

Pour avir accès a une interface de creation de base de donnees, installez [phpmyadmin](https://www.phpmyadmin.net) et glissez le dossier installé dans laragon\etc\apps; sinon utilisez des logiciels tels que [MySQL](https://www.mysql.com) ou [Datagrip](https://www.jetbrains.com/fr-fr/datagrip/) pour gerer vos base de donnees par des softwares.

Une fois Laragon (ou tout autre serveur local) installe, lancez le puis cliquez sur Start/Start All et apres que tout soit initialisé, faite click droit sur la fenetre laragon > MySQL > Create Database. Nommez la comme vous le souhaitez, pour ce ReadMe, nous l'appellerons pjs3.

#### pour phpMyAdmin

Cliquez sur le bouton Database present sur la fenetre de laragon, celui ci vous amenera a phpMyAdmin, de la connectez vous (les id et mots de passe etant theoriquement 'root' et '', le mdp peut aussi etre root). A droite du site, cliquez sur creer une base de données et de la accedez a l'interface qui prends le code SQL puis copiez y le contenu des fichiers SQL fourni dans l'archive en commencant par pjs3_tables.sql pour creer les tables avant d'y ajouter les INSERT.

#### pour DataGrip

Cliquez sur le petit + dans la colone de droite et ajoutez une base de donnée MariaDB. De la remplissez les champs avec les informations necessaires, utilisateur : root, mot de passe : '' ou root, nom de la BD : pjs3, testez la connection, verifiez le numero de port et validez. ENuite dans la console, copiez le contenu des fichiers SQL fourni en archive, en commencant par pjs3_tables.sql pour initialiser les tables puis les autres fichiers sql pour les INSERT.

## Partie Web

Dans le repertoire /www de laragon (accessible par le bouton Root sur l'interface laragon) mettez les fichiers config.php, index.php ainsi que les trois dossier bootstrap-4.5.3-dist, Chart.js-master et node_modules. Sinon, deplacez simplement le dossierbootstrap dans le repertoire /www et ouvrez un terminal a cet endroit ci, entrez:
```bash
npm install chart.js --save
```
ou si vous utilisez bower:
```bash
bower install chart.js --save
```
Ensuite, ouvrez le fichier config.php et modifiez le code de tel sorte a ce que la connection se fasse bien:
```php
define('DB_SERVER', 'localhost'); // ou le nom custom que vous avez mis
define('DB_USERNAME', 'root'); // nom d'utilisateur
define('DB_PASSWORD', ''); // ou root, ou si vous avez modifie le mot de passe, votre mot de passe
define('DB_NAME', 'pjs3'); // le nom de la base de donnees configuree dans laragon.
```

## Acceder au site

Pour acceder au site, cliquez simplement sur le bouton Web de l'interface laragon, celui ci ouvrira votre navigateur par défaut et affichera le site.