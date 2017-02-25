[Home](../../../index.md) /
[Reference Documents](../../index.md) /
[Form Field Types Reference](index.md) /
BirthdayType

# BirthdayType

This form field type is used to handle birthday data.

```text
Note: In contradiction to the BirthdayType provided by Symfony, this form field type renders the year field in
      descending order, as the birth year will most likely be closer to the current year, than to 120 years ago.
```

Rendered as:

* select field
* single input text field
* three input text fields

Overridden options:

* [years](#years)

Parent type:

* [DateType](http://symfony.com/doc/2.7/reference/forms/types/choice.html)

## Configuring as a form field type

### YAML

```yml
birthday_type:
    class: DarkWebDesign\SymfonyAddon\FormType\BirthdayType
    tags: [{ name: form.type }]
```

### XML

```xml
<service id="birthday_type" class="DarkWebDesign\SymfonyAddon\FormType\BirthdayType">
    <tag name="form.type" />
</service>
```

## Overridden Options

### years

**type**: `array` **default**: the current year to 120 years ago

List of years available to the year field type. This option is only relevant when the `widget` option is set to `choice`.
