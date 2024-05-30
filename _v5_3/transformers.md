---
layout: default
title: Data Transformers
has_children: true
redirect_from:
  - /docs/latest/transformers
---

# Data Transformers

You'll often find the need to transform the data the user entered in a form into something else for use in
your program. You could easily do this manually in your controller, but what if you want to use this
specific form in different places?

This is where Data Transformers come into play.

## Supported Transformers

The following transformers are available:

### Scalar Transformers

* [BooleanToValueTransformer](transformers/boolean-to-value-transformer.html)

### Other Transformers

* [EntityToIdentifierTransformer](transformers/entity-to-identifier-transformer.html)
