# Pense-tête

## Twig

### Global
```twig
{{ page.region_name }}
{{ page.region_name.block_name }}
{{ content|without('body') }}
```

```twig
{# Pour node.html.twig #}
{{ label }}
{{ node.label }}

{{ url }}
{{ path('entity.node.canonical', {'node': node.nid.value}) }}
{# Path without "/" at begining #}
{{ path('entity.node.canonical', {'node': node.nid.value})[1:] }} 
```

```twig
{% set image = '/' ~ directory ~ '/images/monimage.jpg' %}
<div style="background-image:url({{ image }});" title=""></div>
```

```twig
<a href="{{ url('<front>') }}"
```

```twig
{# Pour enlever le html du debug Twig #}
{# La variable content donne le rendu de l'élément donc le debug Twig est pris en compte. 
Pour éviter cela, soit on passe par la variable node (node.field_title), soit on utilise
cette solution pas très propre.
#}
{{ content.field_title | render | striptags | trim }}
```

### Bloc
```twig
{# Render field by default #}
{{ content.field_text }}

{# Render raw text field #}
{{ content['#block_content'].body.value }}
{{ content['#block_content'].field_text.value }}

{# Render raw link field #}
{{ content['#block_content'].field_link.0.url }}
{{ content['#block_content'].field_link.0.title }}

{# Render raw media field #}
{{ file_url(content['#block_content'].field_media_image.entity.field_media_image.entity.fileuri) }}
```

```twig
{# Showing background image on block #}
{% set attributes = attributes.addClass('section--background') %}
{% if content.field_media_image is not empty %}
  {% set imageFile = file_url(content['#block_content'].field_media_image.entity.field_media_image.entity.fileuri) %}
  {% set attributes = attributes.setAttribute('style', '--background:url( ' ~ imageFile ~ ')') %}
{% endif %}

<section{{attributes}}>
  {{ title_prefix }}
  {% if label %}
    <h2 class="block-heading">{{ label }}</h2>
  {% endif %}
  {{ title_suffix }}
  {% block content %}
    {{ content }}
  {% endblock %}
</section>

{# CSS part #}
.section--background {
  background-image: var(--background);
  background-repeat: no-repeat;
  background-size: cover;
}
{# End CSS part #}
```

### Texte
```twig
{% if node.field_text.value %}
  {{ node.field_text.value }}
{% endif %}
```

```twig
{% if node.body.value %}
  {{ content.body }}
{% endif %}
```

```twig
{% if node.body.value %}
  {{ node.body.value | raw }}
  {{ node.body.value | slice(0, 100) | striptags('<br><strong><b><i><u>') }}
  {{ node.body.summary }}
{% endif %}
```

```twig
{% if node.body.value|length > 75 %}
    <p>{% autoescape false %}{{ node.body.value | striptags | slice(0, 75) ~ '...' }}{% endautoescape %}</p>
{% else %}
    <p>{% autoescape false %}{{ node.body.value | striptags }}{% endautoescape %}</p>
{% endif %}
```

### Lien
```twig
{% if node.field_link.uri %}
  {{ link(node.field_link.title, node.field_link.uri, {'class': ['btn', 'btn-primary']}) }}
{% endif %}
```

```twig
{% if node.field_link.uri %}
  {{ link(node.field_link.title, node.field_link.uri, {'class': ['btn', 'btn-primary'], 'target': '_blank', 'rel': 'noopener'}) }}
{% endif %}
```

```twig
{% if node.field_link.uri %}
  <a class="btn btn-primary" href="{{ node.field_link.0.url }}" title="{{ node.field_link.title }}"><h2>{{ node.field_link.title }}</h2></a>
  
  <a class="btn btn-primary" href="{{ node.field_link[0]['#url'] }}" title="{{ node.field_link.title }}"><h2>{{ node.field_link.title }}</h2></a>
{% endif %}
```

```twig
{% if node.field_link.uri %}
  {# !! Extension link_attributes must be installed #}
   <a{{ create_attribute({
    'id': node.field_link.options.attributes.id, 
    'name': node.field_link.options.attributes.name,
    'target': node.field_link.options.attributes.target, 
    'rel': node.field_link.options.attributes.rel,
    'class': [node.field_link.options.attributes.class, 'c-button--main']
    }) }} href="{{ node.field_link.0.url }}" title="{{ node.field_link.title }}">{{ node.field_link.title }}</a>
{% endif %}
```

```twig
{# Concernant les menus #}
{# !! Extension link_attributes must be installed #}
<a{{ create_attribute({
    'target': item.url.options.attributes.target, 
    'rel': item.url.options.attributes.rel,
    'class': item.url.options.attributes.class
    }) }} href="{{ item.url }}">{{ item.title }}</a>

=== OR ===

{{ link(item.title, item.url, item.url.options.attributes) }}
```

```twig
{# <div class="btn"><a href="" ....>....</a></div> #}
{{ content.field_link|merge({'#attributes': {'class': ['btn']}}) }}

<a href="{{ content.field_link.0['#url'] }}" class="btn">{{ content.field_button.0['#title'] }}</a>
```

### Image
```twig
{% if node.field_img.uri %}
  <img src="{{ file_url(node.field_img.entity.uri.value }}" alt="{{ node.field_img.alt }}" title="{{ node.field_img.title }}">
{% endif %}
```

```twig
{% if node.field_img.uri %}
  <img src="{{ file_url(node.field_img.entity.uri.value | image_style('homepage') }}" alt="{{ node.field_img.alt }}" title="{{ node.field_img.title }}">
{% endif %}
```

```twig
{% if node.field_img.uri %}
  <img src="{{ file_url(node.field_img.entity.fileuri | image_style('homepage') }}" alt="{{ node.field_img.alt }}" title="{{ node.field_img.title }}">
{% endif %}
```

```twig
{# !! Extension imagecache_external must be installed #}
{% set image = 'https://via.placeholder.com/150' %}
<img src="{{ image | imagecache_external | image_style('homepage') }}">
```

```twig
{% if node.field_img.uri %}
  <img{{ create_attribute()
    .setAttribute('src', node.field_img.entity.fileuri | image_style('homepage'))
    .setAttribute('alt', node.field_img.alt)
    .setAttribute('title', node.field_img.title) }}>
{% endif %}
```

```twig
# Pour un term par exemple
{% set image = {
    '#theme':      'image_style',
    '#style_name': 'picto',
    '#uri':        term.field_picto.entity.uri.value,
    '#alt':        term.name.value,
    '#title':      term.name.value,
    '#width':      term.field_picto.width,
    '#height':     term.field_picto.height
  } %}

{{ image }}
```

### Media
```twig
{% if node.field_img %}
    {% set image = {
        '#theme':      'image_style',
        '#style_name': 'slider',
        '#uri':        node.field_img.entity.field_media_image.entity.fileuri,
        '#alt':        node.field_img.entity.field_media_image.entity.alt,
        '#title':      node.field_img.entity.field_media_image.entity.title,
        '#width':      node.field_img.entity.field_media_image.entity.width,
        '#height':     node.field_img.entity.field_media_image.entity.height
    } %}
    {{ image }}
{% endif %}
```

```twig
{# If you are node #}
<div style="background-image:url({{ file_url(node.field_img.entity.field_media_image.entity.fileuri) }})></div>
```

```twig
{# If you are content #}
<div style="background-image:url({{ file_url(content.field_img['#items'].entity.field_media_image.entity.fileuri) }})></div>
```

### Date
```twig
{{ node.getCreatedTime() | date("Y-m-d") }}
```

```twig
{{ node.field_date.value | date("d/m/Y") }}
{{ node.field_date.value | date("U") | format_date("short") }}
```

### Booléen
```twig
{% if node.field_bool.value %}
  Field checked
{% endif %}
```

### Taxonomy
```twig
{% set lists = node.field_related_taxonomy %}
{% for list in lists %}
  {% set term = list.entity.translation('fr') %}
  {{ term.field_name.value }}
  <a href="{{ path('entity.taxonomy_term.canonical', {'taxonomy_term': term.id}) }}">{{ term.title }}</a>
  {% if not loop.last %},{% endif %}
{% endfor %}
```

```twig
{# taxonomy-term.html.twig #}
{# ADD CLASS FROM FIELD `field_class` ON TAXONOMY DIV OR FIELD ITEM `name` (title of taxonomy term) #}
{%
  set classes = [
    'taxonomy-term',
    'vocabulary-' ~ term.bundle|clean_class,
  ]
%}

{% set icon_class = [] %}
{% for item in content.field_class['#items'] %}
  {% set icon_class = item.value|split(' ') %}
{% endfor %}

<div{{ attributes.setAttribute('id', 'taxonomy-term-' ~ term.id).addClass(classes).addClass(icon_class) }}>
  {{ title_prefix }}
  {% if name and not page %}
    <h2><a href="{{ url }}">{{ name }}</a></h2>
  {% endif %}
  {{ title_suffix }}
  <div class="content">
    {{ content.name|merge({'#attributes': {'class': icon_class}}) }}
    
    {{ content|without('name', 'field_class')}}
  </div>
</div>
```

### Entity Reference (Node, Taxonomy, Paragraph, ...)
```twig
{{ content.field_paragraph }}
```

```twig
{# If entity length is set to 1 item in BO #}
{{ node.field_entity.entity.field_*.value }}
```

```twig
{% for p, paragraph in node.field_paragraph %}
  {{ paragraph.entity.field_title.value }}
{% endfor %}
```

```twig
{% if content.field_entity['#items']|length %}
  {{ content.field_entity }}
{% endif %}
```

```twig
{% set length = content.field_paragraph['#items']|length -1 %}
{% for i in 0..length %}
  {{ content.field_paragraph[i] }}
{% endfor %}
```

```twig
{% set length = content.field_entity['#items']|length -1 %}
{% for i in 0..length %}
  {% set entity = content.field_entity['#items'][i].entity %}
  {{ entity.field_title.value }}
{% endfor %}
```

```twig
{% set multiple = node.field_taxonomy_1|merge(node.field_taxonomy_2) %}
```

### Container
```twig
<div{{ create_attribute({'class': ['region', 'region--header']}) }}>
  {{ content }}
</div>
```

### Render multiple item
```twig
<div{{ create_attribute({'class': ['news']}) }}>
  {% for item in news %}
    {# item must be full node #}
    {% include 'news-item.html.twig' with { 'item': item } %}
  {% endfor %}
</div>
```

```twig
{# !! Extension twig_tweak must be installed #}
<div{{ create_attribute({'class': ['news']}) }}>
  {% for item in news %}
    {# item must be nid #}
    {{ drupal_entity('node', item, 'teaser') }}
  {% endfor %}
</div>
```

### Trans
```twig
{% trans %}Mon texte traductible{% endtrans %}
```

```twig
{% set count = 2 %}
{% trans %}
  {{ count }} item
{% plural count %}
  {{ count }} items
{% endtrans %}
```

### Menu
```twig
{# !! Extension link_attributes must be installed #}
{% import _self as menus %}

{{ menus.menu_links(items, attributes, 0, parent) }}

{% macro menu_links(items, attributes, menu_level, parent) %}
  {% import _self as menus %}

  {% if items %}
    <ul{{ attributes.addClass("c-nav__level"~menu_level) }}>
    {% if menu_level > 0 %}
      <li class="nav__hide"><span class="icon--arrowLeft"></span><span>{{ parent }}</span></li>
    {% endif %}

    {% for item in items %}
      {%
        set itemClasses = [
          'menu-item',
          item.is_expanded ? 'menu-item--expanded',
          item.is_collapsed ? 'menu-item--collapsed',
          item.in_active_trail ? 'menu-item--active-trail',
        ]
      %}
      <li{{ item.attributes.addClass(itemClasses) }}>
        {% if item.below %}
          {% if item.url.routeName in ['<none>', '<nolink>', 'route:<none>', 'route:<nolink>'] %}
            <a aria-haspopup="true" class="url-none">{{ item.title }}</a>
          {%- else -%}
            <a aria-haspopup="true" href="{{ item.url }}">{{ item.title }}</a>
          {%- endif -%}
          <div class="nav__show"><span class="icon--arrowRight"></span></div>
          {{ menus.menu_links(item.below, attributes, menu_level + 1, item.title) }}
        {% else %}
          {{ link(item.title, item.url, item.url.options.attributes) }}
        {% endif %}
      </li>
    {% endfor %}
    </ul>
  {% endif %}
{% endmacro %}
```

## PHP

### Url

```php
//Current route in absolute
$url = \Drupal\Core\Url::fromRoute('<current>', [], ['absolute' => 'true'])->toString();

//Current route not absolute
$url = \Drupal\Core\Url::fromRoute('<current>')->toString();
$url = \Drupal::request()->getRequestUri();


//Front page absolute
$homepage = \Drupal\Core\Url::fromRoute('<front>', [], ['absolute' => 'true'])->toString();
$homepage = \Drupal\Core\Url::fromUri('internal:/')->setAbsolute()->toString();

//Front page
$homepage = \Drupal\Core\Url::fromRoute('<front>')->toString();
$homepage = \Drupal\Core\Url::fromUri('internal:/')->toString();
$ishomepage = \Drupal::service('path.matcher')->isFrontPage();

//Entities
$node = \Drupal\Core\Url::fromRoute('entity.node.canonical', ['node' => 526], ['absolute' => 'true'])->toString();
$taxonomy = \Drupal\Core\Url::fromRoute('entity.taxonomy_term.canonical', ['taxonomy_term' => 526], ['absolute' => 'true'])->toString();
```

### Entity

```php
// Get String
$node->get('fieldname')->get(0)->getString();
$node->get('fieldname')->get(0)->get('value')->getValue();

// Get Entité Reference Item List
$fieldName = 'uid';

/// Solution 1
/** @var NodeStorage $entityManager */
$entityFieldManager = \Drupal::service('entity_field.manager');
$fieldDefinitions = $entityFieldManager->getFieldStorageDefinitions('node');

$fieldDefinition = $fieldDefinitions[$fieldName] ?? null;
if (null === $fieldDefinition) {
  throw new RuntimeException('This field does not exist');
}
$type = $fieldDefinition->getSetting('target_type');
$fieldValues = $node->get($fieldName);

$values = [];
$entityTypeManager = \Drupal::service('entity_type.manager');
foreach ($fieldValues as $delta => $value) {
  $values[$delta] = $entityTypeManager->getStorage($type)->load($value->get('target_id')->getValue());
}
if (1 === $fieldDefinition->getCardinality()) {
  $values = reset($values);
}

/// Solution 2
$node->get($fieldName)->referencedEntities();

// Filter Entité Reference Item List by bundle
array_filter($node->get('fieldname')->referencedEntities(), fn($v) => $v->bundle() === 'bundlename');

// Set Entité Reference Item List
$referenceEntity = Node::create(['type' => 'page']);
$node->set($fieldName, $referenceEntity);

// Add Entité Reference Item List
$referenceEntity1 = Node::create(['type' => 'page']); // nid=10
$referenceEntity2 = Node::create(['type' => 'page']); // nid=11
$node->get($fieldName)->appendItem($referenceEntity1);
$node->get($fieldName)->appendItem($referenceEntity2);

// Remove Entité Reference Item List
$id = (int)array_search((int)$referenceEntity1->id(), array_map(fn($v) => 10, $node->get('fieldname')->referencedEntities(), true);
$node->get($fieldName)->removeItem($id);
```

### Public

```php
// Public directory path
$public_path = Drupal\Core\StreamWrapper\PublicStream::basePath();
$public_path = \Drupal::service('file_system')->realpath("public://");
```

### Theme

```php
// Active current theme (Default theme or Admin theme)
$activeTheme = \Drupal::theme()->getActiveTheme()->getName();

$defaultTheme = \Drupal::service('theme_handler')->getDefault();
$adminTheme = \Drupal::service('theme_handler')->getAdmin();

if (\Drupal::service('router.admin_context')->isAdminRoute() && $activeTheme === $adminTheme) {
  // ADMIN ROUTE ON ADMIN PAGE
}
```

### Image

```php
$user = Drupal\user\Entity\User::load(1);
$user_picture = $user->get('user_picture')->first();
if ($user_picture !== null) {
  $image_uri = Drupal\file\Entity\File::load($user_picture->get('target_id')->getValue())->getFileUri();
  $url = Drupal\image\Entity\ImageStyle::load('thumbnail')->buildUrl($image_uri);
}
```
