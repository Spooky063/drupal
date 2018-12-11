# Pense-tête

## Twig

### Global
```twig
{{ content|without('body') }}
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

### Taxonomy
```twig
{% set lists = node.field_related_taxonomy %}
{% for list in lists %}
  {% set term = list.entity.translation('fr') %}
  {{ term.name.value }}
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

### Container
```twig
<div{{ create_attribute({'class': ['region', 'region--header']}) }}>
  {{ content }}
</div>
```

