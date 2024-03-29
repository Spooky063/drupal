# Commandes Drush

Le gestionnaire Drush existe en plusieurs versions. Cependant pour les projets
Drupal 8.x, nous devons faire appel à des commandes de
[Drush en version 8](https://drushcommands.com/drush-8x/).

## Hash

Lors de la création d'un nouveau site, la variable `hash_salt` dans le fichier
`settings.php` est généré. Cependant il est possible d'en générer un nouveau
avec la commande suivante :
```bash
drush eval "var_dump(Drupal\Component\Utility\Crypt::randomBytesBase64(55))"
```

## Mot de passe

Il est possible de générer un nouveau mot de passe avec le hash de Drupal.
Pour cela il suffit de lancer la commande :
```bash
php core/scripts/password-hash.sh <new_password>
```

## Apparence

Si on utilise un thème d'administration, il est possible de le changer assez facilement.
```bash
drush en adminimal_theme -y
drush config-set system.theme admin adminimal_theme -y
drush en adminimal_admin_toolbar -y
```

## Configuration

### Régionalisation et langue

#### Paramètres régionaux

On va changer les valeurs par défaut necessaire à notre pays.
```bash
drush cset system.date country.default FR -y
drush cset system.date timezone.default Europe/Berlin -y
```

### Développement

#### Performance

Pour pouvoir effacer les caches de façon rapide, je vous propose cette petite
commande :
```bash
drush cr
```

Pour vider uniquement les caches après la création d'un nouveau template, utilisez cette
commande :
```bash
drush cc theme-registry
```

Pour activer la minification des ressources CSS, les commandes suivantes suffissent :
```bash
# Agréger des fichiers CSS
drush cset system.performance css.preprocess 1

# Désagréger des fichiers CSS
drush cset system.performance css.preprocess 0
```

Pour activer la minification des ressources JS, les commandes suivantes suffissent :
```bash
# Agréger des fichiers JS
drush cset system.performance js.preprocess 1

# Désagréger des fichiers JS
drush cset system.performance js.preprocess 0
```

Pour reconstruire la compression des assets du core Drupal :
```
drush ev '\Drupal::service("asset.css.collection_optimizer")->deleteAll(); \Drupal::service("asset.js.collection_optimizer")->deleteAll(); _drupal_flush_css_js();'
```

#### Journalisation et erreurs

Il existe plusieurs niveaux pour la gestion des erreurs.
 * Aucun(e)
 * Erreurs et avertissements
 * Tous les messages
 * Tous les messages, avec les informations de trace

Respectivement nous pouvons lancer les commandes suivantes pour modifier
cette valeur :
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

#### Synchronisation de configuration

Sur Drupal 8, les configurations peuvent être stockées dans des fichiers.
Pour cela il suffit d'activer le module `Configuration Manager`.

```bash
drush en config
```

Les répertoires distants contenant tous les fichiers sont spécifiés dans le fichier
`settings.php` sous la variable `$config_directories`.
Il est possible dans cette variable (qui est un tableau) de mettre plusieurs
entrées avec comme clé un identifiant unique et comme valeur un chemin.
Il sera alors possible d'importer ou d'exporter les configurations voulues
avec de simple commande :

```bash
# Importer les fichiers de configuration
drush cim <identifiant>

# Exporter les fichiers de configuration
drush cex <identifiant>
```
