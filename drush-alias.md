# Alias Drush

## Installation

Une fois drush installé, on va pouvoir créer un alias pour nos projets.
Pour cela, on va se rendre dans le répertoire `~/.drush` et créer un fichier par projet créés.  
Chacun de ces fichiers aura la nomenclature suivantes : `<project_name>.aliases.drushrc.php`.  

A l'intérieur de ce fichier, on va définir autant d'entrée que d'environnement (si possible).  
Pour l'exemple, on va créer un fichier `exemple.aliases.drushrc.php` qui va donc ressembler à cela :

```php
$aliases['dev'] = [
  'root' => '<dev_project_directory_path>',
  'uri'  => '<dev_project_uri>',
];

$aliases['prod'] = [
  'root'   => '<prod_project_directory_path>',
  'uri'    => '<prod_project_uri>',
  'remote-host' => '<remote_ip>',
  'remote-user' => '<remote_user>',
];
```

Une fois cela effectué, on peut éxecuter n'importe quelle commande drush depuis n'importe ou sur le serveur en tapant 
la commande

```bash
# drush @<project_name>.<key> <command>
drush exemple@dev status
```

PS: Si on utilise le project [Drupal composer](https://github.com/drupal-composer/drupal-project), on peut se rendre 
dans le répertoire du projet et lancer la commande suivante : `vendor/bin/drush sac` pour convertir les fichiers en yml
