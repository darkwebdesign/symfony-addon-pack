---
layout: default
title: BirthdayType
parent: Form Field Types
redirect_from:
  - /docs/latest/forms/types/birthday-type
---

# BirthdayType

This form field type is used to handle birthday data.

{: .info }
In contradiction to the BirthdayType provided by Symfony, this form field type renders the year field
in descending order, as the birth year will most likely be closer to the current year, than to 120 years
ago.

Rendered as:

* select field
* single input text field
* three input text fields

Overridden options:

* [years](#years)

Parent type:

* [DateType](http://symfony.com/doc/6.0/reference/forms/types/choice.html)

## Basic Usage

```php
$builder->add('birthday', BirthdayType::class);
```

## Overridden Options

### years

**type**: `array` **default**: the current year to 120 years ago

List of years available to the year field type. This option is only relevant when the `widget` option is set to
`choice`.
