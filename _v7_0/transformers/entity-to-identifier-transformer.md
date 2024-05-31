---
layout: default
title: EntityToIdentifierTransformer
parent: Data Transformers
redirect_from:
  - /docs/latest/transformers/entity-to-identifier-transformer
---

# EntityToIdentifierTransformer

This transformer is used to transform an identifier into a Doctrine entity and vice versa.

## Basic Usage

```php
$taskToIdentifierTransformer = new EntityToIdentifierTransformer($entityManager, Task::class);

// transform an entity to an identifier
$identifier = $taskToIdentifierTransformer->transform($task);

// transform an identifier to an entity
$task = $taskToIdentifierTransformer->reverseTransform($identifier);
```

## Configuring as a service

### YAML

```yml
task_to_identifier_transformer:
    class: DarkWebDesign\SymfonyAddonTransformers\EntityToIdentifierTransformer
    arguments: ['@doctrine.orm.entity_manager', 'AppBundle\Entity\Task']
```

### XML

```xml
<service id="task_to_identifier_transformer"
         class="DarkWebDesign\SymfonyAddonTransformers\EntityToIdentifierTransformer">
    <argument type="service" id="doctrine.orm.entity_manager" />
    <argument type="string">AppBundle\Entity\Task</argument>
</service>
```
