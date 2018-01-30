# Ajout de script dans composer

Pour ajouter des scripts personnalisés qui sont disponible via composer, il faut modifier le fichier `composer.json`.

```json
  ...
  "scripts": {
    "run-phpcs": [
      "@run-phpcs:modules",
      "@run-phpcs:theme"
    ],
    "run-phpcs:modules": [
      "vendor/bin/phpcs --standard=Drupal --extensions=php -p -n -s --colors ./modules/custom/"
    ],
    "run-phpcs:theme": [
      "vendor/bin/phpcs --standard=Drupal --extensions=php -p -n -s --colors ./themes/custom/"
    ],
    "fix-phpcs": [
      "@fix-phpcs:modules",
      "@fix-phpcs:theme"
    ],
    "fix-phpcs:modules": [
      "vendor/bin/phpcbf --standard=Drupal --extensions=php -n ./modules/custom/"
    ],
    "fix-phpcs:theme": [
      "vendor/bin/phpcbf --standard=Drupal --extensions=php -n ./themes/custom/"
    ]
  },
  ...
```

Il est alors possible de vérifier si les nouveaux scripts sont bien disponibles.
```bash
composer
```

Lors du lancement des différents scripts personnalisés, si une erreur apparait, il faut alors vérifier si le standard
a bien été ajouté.
```bash
vendor/bin/phpcs -i
# Retour attendu : The installed coding standards are MySource, PHPCS, PSR1, PEAR, PSR2, Squiz, Zend, Drupal and DrupalPractice

# Si `Drupal` n'est pas installé, il faut lancer la commande suivante
vendor/bin/phpcs --config-set installed_paths vendor/drupal/coder/coder_sniffer
```

Il est alors possible de lancer les scripts personnalisés
```bash
composer run-phpcs
```
