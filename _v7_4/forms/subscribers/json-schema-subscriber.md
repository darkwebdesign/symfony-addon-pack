---
layout: default
title: JsonSchemaSubscriber
parent: Form Field Event Subscribers
redirect_from:
  - /docs/latest/forms/subscribers/json-schema-subscriber
---

# JsonSchemaSubscriber

This form field event subscriber is used to rewrite the JSON Schema `$schema` keyword property, since the
dollar sign is not allowed to be used in form field names.

## Basic Usage

By default, the submitted `$schema` data is rewritten to map to the `schema` field:

```php
$builder
    ->add('schema', TextType::class)
    ->addEventSubscriber(new JsonSchemaSubscriber());
```

It is also possible to rewrite `$schema` to map it to any other field:

```php
$builder
    ->add('jsonSchema', TextType::class)
    ->addEventSubscriber(new JsonSchemaSubscriber('jsonSchema'));
```
