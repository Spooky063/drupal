# Create custom theme

When you create your theme, you must configure some information.

## Config

For set automatically data like logo and favicon, you can create a file into `config/install/THEME.settings.yml`.

**This file must be create before installation of the theme**, otherwise information don't be set and theme will be reinstall.

```yml
logo:
  use_default: false
  path: "themes/custom/THEME/logo.svg"
favicon:
  use_default: false
  path: "themes/custom/THEME/favicon.png"
```

For more data on these information, you can use the module [Metatag](https://www.drupal.org/project/metatag).

## Translation

For set translation folder, you must fill information into `THEME.info.yml`

```yml
[...]

interface translation project: THEME
interface translation server pattern: themes/custom/%project/translations/%project-%language.po
```

## CkEditor CSS

If you want to retrieve CSS on your front and on your code editor wysiwyg on administration page, you must set CSS file on `THEME.info.yml`

```yml
[...]

ckeditor_stylesheets:
  - dist/ckeditor.css
```

## Color theme

If you want to change color palette for your theme, you can [follow my docs](https://github.com/Spooky063/drupal/tree/master/8/color-theme)
