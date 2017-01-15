[Home](../../../index.md) /
[Reference Documents](../../index.md) /
[Form Field Types Reference](index.md) /
EntityType

# EntityType

This form field type is used to transform user entered data to Doctrine entities.

Rendered as:

* input text field

Options:

* [class](#class)

Overridden options:

* [compound](#compound)

Parent type:

* [FormType](http://symfony.com/doc/2.3/reference/forms/types/form.html)

## Configuring as a form field type

### YAML

```yml
entity_type:
    class: DarkWebDesign\SymfonyAddon\FormType\EntityType
    arguments: ["@doctrine.orm.entity_manager"]
    tags: [{ name: form.type }]
```

### XML

```xml
<service id="entity_type" class="DarkWebDesign\SymfonyAddon\FormType\EntityType">
    <argument type="service" id="doctrine.orm.entity_manager" />
    <tag name="form.type" />
</service>
```

## Field Options

### class

**type**: `string` **required**

The class of your entity (e.g. `AppBundle:Category`). This can be a fully-qualified class name (e.g. `AppBundle\Entity\Category`)
or the short alias name (as shown prior).

## Overridden Options

### compound

**type**: `boolean` **default**: `false`

This option specifies whether the type contains child types or not. This option is managed internally for built-in types, so there
is no need to configure it explicitly.
