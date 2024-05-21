# Module Field formats extended

## Types to extend

- Text (formatted)
- Text (formatted, long)
- Text (formatted, long with summary)
- Text (plain)
- Text (plain, long)
- Link

### Existing Formats

- Text (formatted) (set length == varchar)
- Text (formatted, long) (not set length == text)
  - Default => no options
  - Summary or trimmed => trimmed limit
  - Trimmed => trimmed limit

- Text (formatted, long with summary) (not set length == text)
  - Default => no options
  - Summary or trimmed => trimmed limit
  - Trimmed => trimmed limit

- Text (plain)
- Text (plain, long)
  - Plain text => link to the content

- Link
  - Link => trim link text length, URL only, Add rel="nofollow" to links, Open link in new window
  - Separate link text and URL => trim link text length, Add rel="nofollow" to links, Open link in new window

### Added Formats

### Heading

Options

- [level] Level (h1, h2, h3, h4, h5, h6) 
- [level_classes] Classes
- [link] Link to the content
- [link_classes] Classes

Render

```
# Link to the content === false
<{level} class="{level_classes}">{{ content }}</{level}>

# Link to the content === true
<{level} class="{level_classes}"><a href="{link}" class="{link_classes}">{{ content }}</a></{level}>
```

Field Types

- Text (formatted)
- Text (plain)

### Paragraph

Options

- [tag] Tag to wrap
- [tag_classes] Classes
- [link] Link to the content
- [link_classes] Classes

Render

```
# Link to the content === false
<{tag} class="{tag_classes}">{{ content }}</{tag}>

# Link to the content === true
<{tag} class="{tag_classes}"><a href="{link}" class="{link_classes}">{{ content }}</a></{tag}>
```

Field Types

- Text (formatted)
- Text (plain)

### Trimmed
### Summary or trimmed

Options

- [type] Type to trimmed (characters|words)
- [limit] Limit to trimmed
- [force_words] Force trimmed to the end of word (if trimmed on characters)
- [suffix] Text if trimmed
- [force_paragraph] Force text wrap with paragraph (&lt;p&gt; tag) (because on summary there is no tag)
- [classes] Classes can be add if force_paragraph === true

Render

```
# Force text wrap === false
{{ content }}{suffix}

# Force text wrap === true
<{force_paragraph} class="{classes}">{{ content }}{suffix}</{force_paragraph}>
```

Field Types

- Text (formatted, long)
- Text (formatted, long with summary)
- Text (plain, long)

### Link

Options

- [rel] Rel
- [target] Target
- [classes] Classes

Render

```
<a href="#" rel="{rel}" target="{target}" class="{classes}">{{ content }}</a>
```

Field Types

- Link
