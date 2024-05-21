# First installation processing

> [!NOTE]  
> This may be an old-fashioned way of doing things.

# Prerequisites

```bash
# Generate password

## Simple
</dev/urandom tr -dc 'A-Za-z0-9@#$%' | head -c 16 ; echo
## Strong
</dev/urandom tr -dc 'A-Za-z0-9@#$%"'\''()*+,-./:;<=>?@[\]^_`{|}~' | head -c 16 ; echo
```

```bash
## Generate hash
../vendor/drush/drush/drush eval "var_dump(Drupal\Component\Utility\Crypt::randomBytesBase64(55))"
```

# Set up

 - Get `drupal-composer/drupal-project`

 - Install dependencies
 
```bash
composer install --no-scripts --no-dev --prefer-dist --optimize-autoloader
composer drupal-scaffold OR composer drupal:scaffold
```

 - Create repositories

```bash
mkdir -p config/sync
```

 - Check rights
 - Check global configuration (/sites)
 - Create .env file
 - Installation
 
```bash
 drush si --account-name=<name> --account-pass=<password> --locale=en -y
```

 - Optional configuration
 
```bash
drush cset system.date country.default FR -y
drush cset system.date timezone.default Europe/Berlin -y
drush pmu {big_pipe,history,page_cache,quickedit,tour} -y

drush ev '\Drupal::service("entity_field.manager")->getFieldStorageDefinitions("node")["comment"]->delete();'
drush pmu comment -y

drush cex -y
```

If you are still using SVN
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

## After modification

```bash
cd project/
composer install --no-scripts --no-dev --prefer-dist --optimize-autoloader
composer drupal:scaffold

cd web/
# If importing a new database, use the following command before the others
../vendor/drush/drush/drush cset system.site uuid <uuid> -y # (uuid is on the system.site.yml file)
../vendor/drush/drush/drush config-get language.entity.LANGUAGE_CODE uuid <uuid> -y # (uuid is on the language.entity.LANGUAGE_CODE.yml file)

../vendor/drush/drush/drush sset system.maintenance_mode 1
../vendor/drush/drush/drush updb -y
../vendor/drush/drush/drush cim -y
../vendor/drush/drush/drush locale:update -y
../vendor/drush/drush/drush php-eval 'node_access_rebuild();'
../vendor/drush/drush/drush entity-updates -y
../vendor/drush/drush/drush cron --uri=https://www.mondomaine.com # regenerate XML if module simple_sitemap enabled
../vendor/drush/drush/drush cr
../vendor/drush/drush/drush sset system.maintenance_mode 0
```