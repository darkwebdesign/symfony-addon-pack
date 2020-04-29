[Home](../../../index.md) /
[Reference Documents](../../index.md) /
[Form Field Types Reference](index.md) /
UnstructuredType

# UnstructuredType

This form field type is used to handle unstructured data.

```text
Note: Prior to Symfony Forms 3.4.21, it was possible to submit unstructured data to *any* form field type. This was
      considered a security hole and therefore patched, leaving a lot of people with no alternative to handle
      unstructured data in their forms. This form field type has been created to support unstructured data again.
```

Overridden options:

* [compound](#compound)
* [multiple](#multiple)

Parent type:

* [FormType](http://symfony.com/doc/4.4/reference/forms/types/form.html)

## Basic Usage

```php
$builder->add('data', UnstructuredType::class);
```

## Overridden Options

### compound

**type**: `boolean` **value**: `false`

This option is managed internally and can not be changed.

### multiple

**type**: `boolean` **value**: `true`

This option is managed internally and can not be changed.
