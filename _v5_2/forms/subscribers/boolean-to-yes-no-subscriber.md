---
layout: default
title: BooleanToYesNoSubscriber
parent: Form Field Event Subscribers
redirect_from:
  - /docs/latest/forms/subscribers/boolean-to-yes-no-subscriber
---

# BooleanToYesNoSubscriber

This form field event subscriber is used to rewrite boolean values to "yes" or "no", so that pure boolean
values can be processed and used in combination with the `BooleanType` field type.

## Basic Usage

```php
$builder
    ->add('isActive', BooleanType::class)
    ->addEventSubscriber(new BooleanToYesNoSubscriber(['isActive']));
```

Multiple form fields can be rewritten by specifying multiple field names:

```php
$builder
    ->add('isActive', BooleanType::class)
    ->add('isFeatured', BooleanType::class)
    ->addEventSubscriber(new BooleanToYesNoSubscriber('isActive', 'isFeatured'));
```
