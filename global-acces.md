# Accès sur les répertoires/fichiers

Il est important de respecter les bon accès. Pour cela, il suffit de suivre les commandes suivantes :

```bash
find sites/ -maxdepth 2 -type f -exec chmod 664 "{}" \;
find sites/ -maxdepth 2 -type d -exec chmod 775 "{}" \;
find sites/default/ -maxdepth 1 -type f \( -iname "*.*" ! -iname "default*" \) -exec chmod 444 "{}" \;
find sites/default/ -maxdepth 0 -type d -exec chmod 755 "{}" \;
find sites/ -maxdepth 2 -type d -exec chgrp www-data "{}" \;

# Optional
setfacl -R -m u:$(id -u):rw sites/default/
setfacl -dR -m u:$(id -u):rw sites/default/
```
