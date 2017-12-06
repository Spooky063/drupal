# Commandes Drush

Le gestionnaire Drush existe en plusieurs versions. Cependant pour les projets
Drupal 7.x, nous devons faire appel à des commandes de
[Drush en version 7](https://drushcommands.com/drush-7x/).

## Modules

Il existe de multiples commandes spécifiques pour gérer les modules.
Au préalable, il faut d'abord connaître le nom du module avec lequel on veut
intérargir :

```bash
# Télécharger un module
drush dl <module_name>

# Activer un module
drush en <module_name>

# Désactiver un module
drush dis <module_name>

# Supprimer un module
drush pmu <module_name>
```

## Configuration

### Développement

#### Performance

Pour pouvoir effacer les caches de façon rapide, je vous propose cette petite
commande :
```bash
drush cc all
```

#### Journalisation et erreurs

Il existe plusieurs niveaux pour la gestion des erreurs.
 * Aucun(e)
 * Erreurs et avertissements
 * Tous les messages

Respectivement nous pouvons lancer les commandes suivantes pour modifier
cette valeur :
```bash
# Aucun(e)
drush vset error_level 0

# Erreurs et avertissements
drush vset error_level 1

# Tous les messages
drush vset error_level 2
```

#### Mode maintenance

Pour switcher rapidement votre site en mode maintenance, vous pouvez utiliser
cette commande :

```bash
# Désactiver le mode maintenance
drush vset maintenance_mode 0

# Activer le mode maintenance
drush vset maintenance_mode 1
```
