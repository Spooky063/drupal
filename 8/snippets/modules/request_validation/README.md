# Request Validation

> Validate an entity and create it by request object.

## How it works

Launch your best tool to test request and put some informations.

Here is some examples for entity:

```
Path: /request/create-entity

Body:
{
  "name": ["bad"],
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


```
Path: /request/create-entity

Body:
{
  "name": ["Create an entity"],
  "slug": ["create-entity"],
  "content": ["lorem ipsum"]
}

Response:
{
  "message": "ok"
}
```

Here is some examples for object:

```
Path: /request/create-object

Body:
{
  "name": "bad",
  "slug": "create-object",
  "content": "lorem ipsum"
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

```
Path: /request/create-object

Body:
{
  "name": "Create an objecet",
  "slug": "create-object",
  "content": "lorem ipsum"
}

Response:
{
  "message": "ok"
}
```
