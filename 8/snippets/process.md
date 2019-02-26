# Process

# Prérequis

```bash
# Generate password

## Simple
</dev/urandom tr -dc 'A-Za-z0-9@#$%' | head -c 16 ; echo
## Strong
</dev/urandom tr -dc 'A-Za-z0-9@#$%"'\''()*+,-./:;<=>?@[\]^_`{|}~' | head -c 16 ; echo

# Generate hash
../vendor/drush/drush/drush eval "var_dump(Drupal\Component\Utility\Crypt::randomBytesBase64(55))"
```

# Mise en place

 - Récupération du projet GIT `drupal-composer/drupal-project`
 
```json
{
    "name": "drupal-composer/drupal-project",
    "description": "Project template for Drupal 8 projects with composer",
    "type": "project",
    "license": "GPL-2.0-or-later",
    "repositories": [
        {
            "type": "composer",
            "url": "https://packages.drupal.org/8"
        }
    ],
    "require": {
        "composer/installers": "^1.2",
        "cweagans/composer-patches": "^1.6.5",
        "drupal-composer/drupal-scaffold": "^2.5",
        "drupal/console": "^1.0.2",
        "drupal/core": "^8.6.0",
        "drush/drush": "^9.0.0",
        "vlucas/phpdotenv": "^2.4",
        "webflo/drupal-finder": "^1.0.0",
        "webmozart/path-util": "^2.3"
    },
    "require-dev": {
        "webflo/drupal-core-require-dev": "^8.6.0"
    },
    "conflict": {
        "drupal/drupal": "*"
    },
    "minimum-stability": "dev",
    "prefer-stable": true,
    "config": {
        "sort-packages": true
    },
    "autoload": {
        "classmap": [
            "scripts/composer/ScriptHandler.php"
        ],
        "files": ["load.environment.php"]
    },
    "scripts": {
        "pre-install-cmd": [
            "DrupalProject\\composer\\ScriptHandler::checkComposerVersion"
        ],
        "pre-update-cmd": [
            "DrupalProject\\composer\\ScriptHandler::checkComposerVersion"
        ],
        "post-install-cmd": [
            "@composer drupal:scaffold",
            "DrupalProject\\composer\\ScriptHandler::createRequiredFiles"
        ],
        "post-update-cmd": [
            "@composer drupal:scaffold",
            "DrupalProject\\composer\\ScriptHandler::createRequiredFiles"
        ],
        "run-phpcs": [
            "@run-phpcs:modules",
            "@run-phpcs:theme"
        ],
        "run-phpcs:modules": [
            "vendor/bin/phpcs --standard=PSR2 --extensions=php -p -n -s --colors ./web/modules/custom/"
        ],
        "run-phpcs:theme": [
            "vendor/bin/phpcs --standard=PSR2 --extensions=php -p -n -s --colors ./web/themes/custom/"
        ],
        "fix-phpcs": [
            "@fix-phpcs:modules",
            "@fix-phpcs:theme"
        ],
        "fix-phpcs:modules": [
            "vendor/bin/phpcbf --standard=PSR2 --extensions=php -n ./web/modules/custom/"
        ],
        "fix-phpcs:theme": [
            "vendor/bin/phpcbf --standard=PSR2 --extensions=php -n ./web/themes/custom/"
        ]
    },
    "extra": {
        "patchLevel": {
            "drupal/core": "-p2"
        },
        "installer-paths": {
            "web/core": ["type:drupal-core"],
            "web/libraries/{$name}": ["type:drupal-library"],
            "web/modules/contrib/{$name}": ["type:drupal-module"],
            "web/profiles/contrib/{$name}": ["type:drupal-profile"],
            "web/themes/contrib/{$name}": ["type:drupal-theme"],
            "drush/Commands/{$name}": ["type:drupal-drush"]
        },
        "drupal-scaffold": {
            "source": "http://cgit.drupalcode.org/drupal/plain/{path}?h={version}", 
            "excludes": [
                "sites/default/default.settings.php",
                "sites/default/default.services.yml",
                "sites/development.services.yml",
                "sites/example.settings.local.php",
                "sites/example.sites.php"
            ],
            "initial": {
                ".editorconfig": "../.editorconfig",
                ".gitattributes": "../.gitattributes"
            }
        }
    }
}

```
 
 - Installation des dépendances
 
```bash
composer install --no-scripts --no-dev --prefer-dist --optimize-autoloader
composer drupal-scaffold OR composer drupal:scaffold SELON LE COMPOSER.JSON
```

 - Création des répertoires

```bash
mkdir -p config/sync
mkdir -p web/sites/default/private
mkdir -p web/sites/default/tmp
```

 - Vérification des droits
 - Gestion des fichiers blobaux (/sites)
 - Création du fichier .env
 - Installation du Drupal
 
```bash
 drush si --account-name=<name> --account-pass=<password> --locale=en -y
```

 - Configuration supplémentaires
 
```bash
drush cset system.date country.default FR -y
drush cset system.date timezone.default Europe/Berlin -y
drush pmu {big_pipe,history,page_cache,quickedit,tour} -y

drush ev '\Drupal::service("entity_field.manager")->getFieldStorageDefinitions("node")["comment"]->delete();'
drush pmu comment -y

drush cex -y
```

Si utilisation de svn
```bash
svn propset svn:global-ignores "vendor" .

svn propset svn:ignore ".env"$'\n'".editorconfig"$'\n'".gitattributes"$'\n'".phpintel"$'\n'"*.sublime-project"$'\n'"*.sublime-workspace"$'\n'".buildpath"$'\n'".DS_Store"$'\n'".idea"$'\n'".project"$'\n'"nbproject" .

svn add --depth=empty web
svn propset svn:ignore "core"$'\n'"autoload.php"$'\n'"update.php"$'\n'"index.php"$'\n'"web.config"$'\n'".*" web

svn add --depth=empty web/modules
svn propset svn:ignore "contrib" web/modules

svn add --depth=empty web/themes
svn propset svn:ignore "contrib" web/themes

svn add --depth=empty web/sites
svn propset svn:ignore "development.services.yml"$'\n'"example.*" web/sites

svn add --depth=empty web/sites/default
svn propset svn:ignore "files"$'\n'"private"$'\n'"tmp"$'\n'"translations"$'\n'"default.*" web/sites/default

svn add --force .
```

# Procédure

## A chaque modification

```bash
cd monprojet/
composer install --no-scripts --no-dev --prefer-dist --optimize-autoloader
composer drupal-scaffold OR composer drupal:scaffold SELON LE COMPOSER.JSON

cd web/
# Si import d'une nouvelle bdd, utiliser la commande suivante avant les autres
../vendor/drush/drush/drush cset system.site uuid <uuid> -y (ou uuid est celle de system.site.yml de l'installation du Drupal)
../vendor/drush/drush/drush config-get language.entity.LANGUAGE_CODE uuid <uuid> -y  (ou uuid est celle de language.entity.LANGUAGE_CODE.yml de l'installation du Drupal)

../vendor/drush/drush/drush sset system.maintenance_mode 0
../vendor/drush/drush/drush cim -y
../vendor/drush/drush/drush updb -y
../vendor/drush/drush/drush locale:update -y
../vendor/drush/drush/drush php-eval 'node_access_rebuild();'
../vendor/drush/drush/drush entity-updates -y
../vendor/drush/drush/drush cron --uri=mondomaine.com # regenerate XML if module simple_sitemap enabled
../vendor/drush/drush/drush cr
../vendor/drush/drush/drush sset system.maintenance_mode 1
```

# Erreurs rencontrées

Si vous rencontrez des erreurs lors de l'import des configurations :
```bash
# Erreur
The import failed due to the following reasons:                                                                             
  Des entités de type <em class="placeholder">Lien de raccourci</em> et <em class="placeholder">Ensemble de raccourcis</em> <em class="placeholder">Par défaut</em> existent. Celles-ci doivent être supprimées avant d'importer.
  
# Solution
../vendor/drush/drush/drush edel shortcut
```
