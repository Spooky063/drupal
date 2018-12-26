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
svn add --depth=empty web/sites/default
svn propset svn:ignore "files"$'\n'"private"$'\n'"tmp"$'\n'"translations" web/sites/default

svn add --force .
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
