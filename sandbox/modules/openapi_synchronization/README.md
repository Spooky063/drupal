# OpenAPI Specification

## Drupal module

This module is designed to download an openapi specification file for a specific field.  
By sending a file (validate by the field itself) via the `POST` request `/openapi-specification/{productName}`, you can update the corresponding product entity.

### How to fit it with my custom field

There are many files to override before install the module.

1. src/Access/OpenAPIAccessCheck.php

```php
if ($entity instanceof NodeInterface && $entity->access('update', $account)) {
  return AccessResult::allowed();
}
```

<ins>Method</ins> : access

<ins>Usage</ins>: Check if the user can access and edit the entity.

<ins>Override</ins>: You need to check if the permission `update` is the right permission you need to use.
Maybe in your case, you need to replace it by `edit`.

2. src/Routing/OpenAPIParamConverter.php

```php
$entities = $this->entityManager->getStorage('node')->loadByProperties(
  [
    'type' => 'product',
    'field_documentation.entity:paragraph.field_apidoc_synchronization' => $value,
  ]
);
```

<ins>Method</ins>: convert

<ins>Usage</ins>: This method is used to retrieve the Drupal node related to the value put in the URL.

<ins>Override</ins>:
- The **type** argument must be replaced by your `content_type`.
- The **field** relating the Apigee product name to Drupal must also be modified.

3. OpenAPISpecificationFileManager.php

```php
return 'public://apidoc_specs' . \DIRECTORY_SEPARATOR . $filename;
```

<ins>Method</ins>: getFilename

<ins>Usage</ins>: Return the full path of the specification file.

<ins>Override</ins>: The destination directory of the openAPI file must be modified to match the expectations of the Drupal file field. In our case, a directory `apidoc_specs` was used to store all the specification file.

4.	OpenAPISpecificationProductManager.php

```php
public function updateOpenAPIFileFromEntity(
  NodeInterface $entity,
  FileInterface $file,
): array {
  /** @var EntityReferenceRevisionsFieldItemList $fieldSpecification */
  $fieldSpecification = $entity->get('field_documentation');
  /** @var ParagraphInterface[] $fieldSpecificationItems */
  $fieldSpecificationItems = $fieldSpecification->referencedEntities();
  foreach ($fieldSpecificationItems as $fieldSpecification) {
    $this->setFile($fieldSpecification, $file);
  }

  return $this->errors;
}
```

<ins>Method</ins>: updateOpenAPIFileFromEntity

<ins>Usage</ins>: Update the field related to the file.

<ins>Override</ins>: The signature of this function must not be changed.

If you doesn’t use a paragraph for the file field, all the content of this method can be replace by the content of the method `setFile()`.

If the file field is in a paragraph, you must only change the name of the field of type paragraph.

```php
private function setFile(
  ParagraphInterface $entity,
  FileInterface $file,
): void {
  $entity->set('field_apidoc_spec', ['target_id' => $file->id()]);

  $violations = $entity->get('field_apidoc_spec')->validate();
  if ($violations->count() > 0) {
    /** @var ConstraintViolation[] $violations */
    foreach ($violations as $violation) {
      $message = (string)$violation->getMessage();
      $this->logger->error($message);
      $this->errors[] = $message;
      return;
    }
  }

  $entity->save();
}
```

<ins>Method</ins>: setFile

<ins>Usage</ins>: This method allows to link the file into the field.

<ins>Override</ins>: You must change the name of the field that receive the file entity. If you don’t use a paragraph, the content of this method must be placed into the method `updateOpenAPIFileFromEntity`.

```php
public function getOpenAPIFileFromEntity(
  NodeInterface $entity,
): ?FileInterface {
  /** @var EntityReferenceRevisionsFieldItemList $fieldSpecification */
  $fieldSpecification = $entity->get('field_documentation');
  /** @var ParagraphInterface[] $fieldSpecificationItems */
  $fieldSpecificationItems = $fieldSpecification->referencedEntities();
  foreach ($fieldSpecificationItems as $fieldSpecification) {
    /** @var FileFieldItemList $fileField */
    $fileField = $fieldSpecification->get('field_apidoc_spec');
    /** @var FileInterface[] $file */
    $file = $fileField->referencedEntities();
    if (!empty($file)) {
      return reset($file);
    }
  }

  return null;
}
```

<ins>Method</ins>: getOpenAPIFileFromEntity

<ins>Usage</ins>: Retrieve the file entity linked to the field.

<ins>Override</ins>: We are using a paragraph named **field_documentation** with a field `field_apidoc_spec` that receive the file entity. If you don’t use a paragraph, you should only return the result of the field that have the specification file.
