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
{{ content.field_title | render | striptags | trim }}
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
{% endif %}
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

### Date
```twig
{{ node.getCreatedTime() | date("Y-m-d") }}
```

```twig
{{ node.field_date.value | date("d/m/Y") }}
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

### Entity Reference (Node, Taxonomy, Paragraph, ...)
```twig
{{ content.field_paragraph }}
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
