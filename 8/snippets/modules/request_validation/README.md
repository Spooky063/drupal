# Request Validation

> Validate a request object, validate it by multiple way and convert it to object/entity/...

## How it works

### Request validation with Entity API

I create a Drupal Entity from request data and I validate the data with Entity Validation API.

### Request validation with Form API

I create an object from request data and I validate the data with a Form hook_validate().

### Request validation with Json Schema

I only validate the data send from the request with an external library called justinrainbow/json-schema.

### Request validation with Typed Data API

I create a Drupal object from request data and I validate the data with Entity Validation API.

## Want to try

Launch your best tool to test request and put some informations.

Here is some examples for **entity**:

### Bad request

```
Path: /validation/with-entityapi

Body:
{
  "name": ["bad"],
  "status": ["1"],
  "slug": ["create-entity"],
  "content": ["lorem ipsum"]
}

Response:
{
  "message": "validation_failed",
  "errors": [
    {
      "property": "name",
      "message": "name must be greater than 5 characters"
    }
  ]
}
```

### Good request

```
Path: /validation/with-entityapi

Body:
{
  "name": ["Create an entity"],
  "status": ["1"],
  "slug": ["create-entity"],
  "content": ["lorem ipsum"]
}

Response:
{
  "message": "ok"
}
```

Here is some examples for **other type**:

```
Paths:
  Via Form API: /validation/with-formapi
  Via Json Schema: /validation/with-jsonschema
  Via Typed Data API: /validation/with-typeddataapi

Body:
{
  "name": "bad",
  "status": 1,
  "slug": "create-object",
  "content": "lorem ipsum"
}

Response:
{
  "message": "validation_failed",
  "errors": [
    {
      "property": "name",
      "message": "Cette valeur est trop courte. Elle doit au moins contenir 5 caractères."
    }
  ]
}
```
