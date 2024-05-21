# Drush commands

## Hash

How to generate a new variable `hash_salt` in`settings.php`:
```bash
drush eval "var_dump(Drupal\Component\Utility\Crypt::randomBytesBase64(55))"
```

## Password

It's possible to generate a new password with the command line:
```bash
php core/scripts/password-hash.sh <new_password>
```

## Appearance

If you're using an administration theme, you can change it quite easily:
```bash
drush en adminimal_theme -y
drush config-set system.theme admin adminimal_theme -y
drush en adminimal_admin_toolbar -y
```

## Configuration

### Regionalization and language

#### General settings

We're going to change the default values our country needs:
```bash
drush cset system.date country.default FR -y
drush cset system.date timezone.default Europe/Berlin -y
```

### Development

#### Performance

For a quick way to clear caches, I suggest:
```bash
drush cr
```

To clear caches only after a new template has been created, use this command:
```bash
drush cc theme-registry
```

To activate/deactivate CSS resource minification:
```bash
# Agréger des fichiers CSS
drush cset system.performance css.preprocess 1

# Désagréger des fichiers CSS
drush cset system.performance css.preprocess 0
```

To activate/deactivate JS resource minification:
```bash
# Agréger des fichiers JS
drush cset system.performance js.preprocess 1

# Désagréger des fichiers JS
drush cset system.performance js.preprocess 0
```

To rebuild Drupal core asset compression:
```bash
drush ev '\Drupal::service("asset.css.collection_optimizer")->deleteAll(); \Drupal::service("asset.js.collection_optimizer")->deleteAll(); _drupal_flush_css_js();'
```

#### Logging and errors

```bash
# Aucun(e)
drush cset system.logging hide

# Erreurs et avertissements
drush cset system.logging some

# Tous les messages
drush cset system.logging all

# Tous les messages, avec les informations de trace
drush cset system.logging verbose
```

#### Configuration synchronization

From Drupal 8, configurations can be stored in files.  
All you need to do is activate the `Configuration Manager` module.
```bash
drush en config
```

The remote directories containing all files are specified in file 
`settings.php` under the variable `$config_directories`.
In this variable (which is an array), it is possible to set multiple
entries with a unique identifier as the key and a path as the value.
It will then be possible to import or export the desired configurations with a simple command :
```bash
# Importer les fichiers de configuration
drush cim <identifiant>

# Exporter les fichiers de configuration
drush cex <identifiant>
```
