# Commandes Drush

## Installation

Pour installer l'exécutable Drush, il suffit de lancer les commandes suivantes :
```bash
sudo sh -c "curl -L https://s3.amazonaws.com/files.drush.org/drush.phar > /usr/local/bin/drush" \
sudo chmod +x /usr/local/bin/drush \
drush init -y
```

## Commandes

### Connexion sans compte

Création d'un lien unique qui pointe directement dans l'administration du site.
```bash
drush uli
```

Changement de n'importe quel mot de passe
```bash
drush upwd <user> --password="<password>"
```

### Mise à jour de la BDD

Pour mettre à jour la base de données, on peut passer par Drush.
Il faut cependant que le module `update` soit activé au préalable.
```bash
drush updatedb
```

### Mise à jour des traductions

Pour mettre à jour les traductions, on peut passer par Drush.
Il faut cependant que le module `language` soit activé au préalable.

```bash
drush locale-update
```

### Voir le dernier message d'erreur

Quand on a pas accès au back-office ou la flemme d'aller dessus, 
on peut quand même connaitre les erreurs grâce à cette commande toute simple.  
Il faudra au préalable que le module `dblog` soit installé.

```bash
drush watchdog-show --severity=error --count=1
```
