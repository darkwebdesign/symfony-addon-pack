[Home](../../index.md) /
[Reference Documents](../index.md) /
[Data Transformer Reference](index.md) /
BooleanToValueTransformer

# BooleanToValueTransformer

This transformer is used to transform a boolean into a scalar value and vice versa.

## Configuring as a service

### YAML

```yml
boolean_to_yesno_transformer:
    class: DarkWebDesign\SymfonyAddon\Transformer\BooleanToValueTransformer
    arguments: ["yes", "no"]
```

### XML

```xml
<service id="boolean_to_yesno_transformer" class="DarkWebDesign\SymfonyAddon\Transformer\BooleanToValueTransformer">
    <argument type="string">yes</argument>
    <argument type="string">no</argument>
</service>
```
