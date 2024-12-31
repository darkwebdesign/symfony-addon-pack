---
layout: default
title: BooleanToValueTransformer
parent: Data Transformers
redirect_from:
  - /docs/latest/transformers/boolean-to-value-transformer
---

# BooleanToValueTransformer

This transformer is used to transform a boolean into a scalar value and vice versa.

## Basic Usage

```php
$booleanToYesnoTransformer = new BooleanToValueTransformer('yes', 'no');

// transform a boolean to a value
$yesno = $booleanToYesnoTransformer->transform($boolean);

// transform a value to a boolean
$boolean = $booleanToYesnoTransformer->reverseTransform($yesno);
```

## Configuring as a service

### YAML

```yml
boolean_to_yesno_transformer:
    class: DarkWebDesign\SymfonyAddonTransformers\BooleanToValueTransformer
    arguments: ['yes', 'no']
```

### XML

```xml
<service id="boolean_to_yesno_transformer"
         class="DarkWebDesign\SymfonyAddonTransformers\BooleanToValueTransformer">
    <argument type="string">yes</argument>
    <argument type="string">no</argument>
</service>
```
