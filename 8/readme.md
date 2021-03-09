# Drupal 8

## Informations

Ne jamais utiliser le module `Custom Block` natif du coeur de Drupal pour la création de bloc.  
Privilégier le module [Simple Block](https://www.drupal.org/project/simple_block) 
qui permet d'utiliser les fichiers de configuration pour la synchronisation des environnements.

Dans le cas ou il est déjà trop tard, il est possible d'utiliser une astuce avec un module pour les créer dynamiquement
```php
function btest_update_8204() {
    $default_content = [
        'block_content' => [
            '738c82b5-f53d-4570-8379-c221c75a6d8a' => [
                'info' => 'B3 Test',
                'type' => 'basic',
                'body' => '<p>B3 test body</p>',
            ],
        ],
    ];

    foreach ($default_content as $entity_type_id => $items) {
        $storage = \Drupal::entityTypeManager()->getStorage($entity_type_id);
        foreach ($items as $uuid => $item) {
            $entity = $storage->create($item + ['uuid' => $uuid]);
            $entity->save();
        }
    }
}
```

Puis il est possible de changer les informations liées au bloc
```php
function btest_update_8207() {
   if($block = \Drupal::service('entity.repository')->loadEntityByUuid('block_content', 'd12475d0-7be9-428c-aada-e56c9028070a')) {
       $block->set('body', 'B4 Test body update 1');
       $block->save();
   }
}
```
