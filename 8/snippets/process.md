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
```

# Procédure

## A chaque modification

```bash
cd monprojet/
composer install --ignore-platform-reqs --no-scripts --no-dev --prefer-dist --optimize-autoloader
composer drupal-scaffold

cd web/
../vendor/drush/drush/drush cim -y
../vendor/drush/drush/drush updb -y
../vendor/drush/drush/drush locale:update -y
../vendor/drush/drush/drush php-eval 'node_access_rebuild();'
../vendor/drush/drush/drush entity-updates -y
../vendor/drush/drush/drush cr
```
