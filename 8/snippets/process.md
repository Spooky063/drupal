# Process

# A l'installation

```bash
cd monprojet/
composer install --ignore-platform-reqs --no-scripts --no-dev --prefer-dist --optimize-autoloader
composer drupal-scaffold

cd web/
../vendor/drush/drush/drush si (standard|minimal) --account-name=$DRUPAL_ADMIN_ACCOUNT_NAME --account-pass=$DRUPAL_ADMIN_ACCOUNT_PASS --locale=en -y
```

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
