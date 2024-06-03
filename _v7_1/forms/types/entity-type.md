---
layout: default
title: EntityType
parent: Form Field Types
redirect_from:
  - /docs/latest/forms/types/birthday-type
---

# EntityType

This form field type is used to transform user entered identifiers to Doctrine entities.

{: .info }
In contradiction to the EntityType provided by `symfony/doctrine-bridge`, this form field type does ***not***
retrieve all entities in order to display them in your forms, which is particularly useful when you are
working with large data sets, or if you are using a custom search/select field that retrieves the data
via an API.

Rendered as:

* input text field

Options:

* [class](#class)
* [entity_manager](#entity_manager)

Overridden options:

* [compound](#compound)

Parent type:

* [FormType](http://symfony.com/doc/7.1/reference/forms/types/form.html)

## Basic Usage

```php
$builder->add('task', EntityType::class, [
    'class' => Task::class,
]);
```

## Configuring as a form field type

### YAML

```yml
DarkWebDesign\SymfonyAddonFormTypes\EntityType:
    arguments: ['@doctrine']
    tags: [{ name: 'form.type' }]
```

### XML

```xml
<service id="DarkWebDesign\SymfonyAddonFormTypes\EntityType">
    <argument type="service" id="doctrine" />
    <tag name="form.type" />
</service>
```

## Field Options

### class

**type**: `string` **required**

The class of your entity (e.g. `AppBundle:Category`). This can be a fully-qualified class name (e.g.
`AppBundle\Entity\Category`) or the short alias name (as shown prior).

### entity_manager

**type**: `string` or `Doctrine\Common\Persistence\ObjectManager` **default**: the default entity manager

If specified, this entity manager will be used to load the entity instead of the `default` entity manager.

## Overridden Options

### compound

**type**: `boolean` **default**: `false`

This option specifies whether the type contains child types or not. This option is managed internally for
built-in types, so there is no need to configure it explicitly.
