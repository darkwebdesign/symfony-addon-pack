[Home](../../../index.md) /
[Reference Documents](../../index.md) /
[Form Field Types Reference](index.md) /
BooleanType

# BooleanType

This form field type is used to transform user selected values to booleans.

```text
Note: In contradiction to the CheckboxType provided by Symfony, this form field type offers a tri-state boolean
      (true/false/null), as well as a traditional boolean, using multiple widgets.
```

Rendered as:

* select field
* input radio field

Options:

* [widget](#widget)
* [trueValue](#trueValue)
* [falseValue](#falseValue)

Overridden options:

* [choices](#choices)
* [expanded](#expanded)
* [multiple](#multiple)

Parent type:

* [ChoiceType](http://symfony.com/doc/2.3/reference/forms/types/choice.html)

## Configuring as a form field type

### YAML

```yml
boolean_type:
    class: DarkWebDesign\SymfonyAddon\FormType\BooleanType
    tags: [{ name: form.type }]
```

### XML

```xml
<service id="boolean_type" class="DarkWebDesign\SymfonyAddon\FormType\BooleanType">
    <tag name="form.type" />
</service>
```

## Field Options

### widget

**type**: `string` **default**: `choice`

The basic way in which this field should be rendered. Can be one of the following:

* `choice`: renders a select field.
* `radio`: renders input radio buttons.

### trueValue

**type**: `string` **default**: `Yes`

The string value that is being transformed to a boolean `true`.

### falseValue

**type**: `string` **default**: `No`

The string value that is being transformed to a boolean `false`.

## Overridden Options

### choices

**type**: `array`

An array containing the `trueValue` and `falseValue` options.

### expanded

**type** `boolean`

The actual default value of this option depends on the `widget` option:

* If `widget` is `choice`, then `false`;
* Otherwise `true`.

### multiple

**type** `boolean` **default**: `false`

Boolean fields types cannot have multiple values.
