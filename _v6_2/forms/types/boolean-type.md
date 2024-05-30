---
layout: default
title: BooleanType
parent: Form Field Types
redirect_from:
  - /docs/latest/forms/types/birthday-type
---

# BooleanType

This form field type is used to transform user selected values to booleans.

{: .info }
In contradiction to the CheckboxType provided by Symfony, this form field type offers a tri-state
boolean (true/false/null), as well as a traditional boolean, supporting multiple rendering widgets.

Rendered as:

* select field
* input radio field

Options:

* [label_false](#label_false)
* [label_true](#label_true)
* [value_false](#value_false)
* [value_true](#value_true)
* [widget](#widget)

Overridden options:

* [choices](#choices)
* [expanded](#expanded)
* [multiple](#multiple)

Parent type:

* [ChoiceType](http://symfony.com/doc/6.1/reference/forms/types/choice.html)

## Basic Usage

```php
$builder->add('married', BooleanType::class);
```

## Field Options

### label_false

**type**: `string` **default**: `null`

The label that will be used for the `false` value.

The default value results in a "humanized" version of `value_false`.

### label_true

**type**: `string` **default**: `null`

The label that will be used for the `true` value.

The default value results in a "humanized" version of `value_true`.

### value_false

**type**: `string`, `integer` or `float` **default**: `no`

The value that is being transformed to a boolean `false`.

### value_true

**type**: `string`, `integer` or `float` **default**: `yes`

The value that is being transformed to a boolean `true`.

### widget

**type**: `string` **default**: `choice`

The basic way in which this field should be rendered. Can be one of the following:

* `choice`: renders a select field.
* `radio`: renders input radio buttons.

## Overridden Options

### choices

**type**: `array`

An array containing the `value_true` and `value_false` options.

### expanded

**type** `boolean`

The actual default value of this option depends on the `widget` option:

* If `widget` is `choice`, then `false`;
* Otherwise `true`.

### multiple

**type** `boolean` **default**: `false`

Boolean fields types cannot have multiple values.
