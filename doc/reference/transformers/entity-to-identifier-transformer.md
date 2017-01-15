[Home](../../index.md) /
[Reference Documents](../index.md) /
[Data Transformer Reference](index.md) /
EntityToIdentifierTransformer

# EntityToIdentifierTransformer

This transformer is used to transform an identifier into a Doctrine entity and vice versa.

## Configuring as a service

### YAML

```yml
task_to_identifier_transformer:
    class: DarkWebDesign\SymfonyAddon\Transformer\EntityToIdentifierTransformer
    arguments: ["@doctrine.orm.entity_manager", "AppBundle\Entity\Task"]
```

### XML

```xml
<service id="task_to_identifier_transformer" class="DarkWebDesign\SymfonyAddon\Transformer\EntityToIdentifierTransformer">
    <argument type="service" id="doctrine.orm.entity_manager" />
    <argument type="string">AppBundle\Entity\Task</argument>
</service>
```