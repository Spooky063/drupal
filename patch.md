# Appliquer un patch

## Prérequis

Afin d'appliquer le patch, il va nous falloir utiliser 2 commandes : `curl` et `patch`

## Appliquer le patch

Pour appliquer un patch sans aucun gestionnaire de version, on peut utiliser la commande `patch`.  
Mais au préalable il faut récupérer le patch en question localement (Ici on récupère le patch `id` pour la version 7 de Drupal).

```
curl -so /tmp/patch-$(date +'%Y-%m%d').patch \ 
-X GET -G 'https://cgit.drupalcode.org/drupal/rawdiff/?h=7.x' -d id=`id_du_path`
```

Une fois récupérer, il suffit de se rendre dans le répertoire du drupal et lancer la commande suivante

```
patch -p1 < /tmp/patch-$(date +'%Y-%m%d').patch

OU

patch -d /racine-projet/ -p1 < /tmp/patch-$(date +'%Y-%m%d').patch
```

Vous avez réussi votre patch !

## Revenir en arrière

```
patch -R < /tmp/patch-$(date +'%Y-%m%d').patch
```
