# Ajout d'un icône dans un lien

Nous voulons ajouter un élément HTML dans l'ancre pour pouvoir afficher une icone à la place du texte.  

Nous partirons sur un exemple simple :  
 - Nous avons un champ de type **lien** qui s'appelle `field_social_link`,
 - Nous voulons ajouter la valeur `<i class="icon-%"></i>` à l'intérieur de l'ancre et plus particulièrement à la place du texte,
 - Nous désirons ajouter un attribut `title` sur le lien qui aura la valeur du texte que l'on a remplacé

Concernant l'affichage du champ en question (`field_social_link`) dans le back-office, nous lui donneront le format `Lien` ainsi que les paramètres voulus (Ajouter rel="nofollow" aux liens, Ouvrir le lien dans une nouvelle fenêtre, ...)

```php
<?php
/**
 * @file mytheme.theme
 */
 
function mytheme_preprocess_field(&$variables) {
    $element = $variables['element'];
    
    if ($element['#field_name'] === 'field_social_link') {
        foreach ($variables['items'] as $key => $item) {
            // Add icon
            $icon  = '<i class="icon-'.strtolower($item['content']['#title']).'"></i>';
            $title = \Drupal\Core\Render\Markup::create($icon);
            $variables['items'][$key]['content']['#title'] = $title;
    
            // Add title attribute
            $variables['items'][$key]['content']['#options']['attributes'] = ['title' => $item['content']['#title']];
        }
    }
}

```
