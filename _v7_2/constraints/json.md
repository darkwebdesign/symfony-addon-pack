---
layout: default
title: Json
parent: Validation Constraints
redirect_from:
  - /docs/latest/constraints/json
---

# Json

This constraint is used to ensure that a value has the proper format of a JSON-encoded string.

{: .warning }
This validation constraint is deprecated and will be removed in v8.0. Use Symfony's own [Json](https://symfony.com/doc/7.2/reference/constraints/Json.html) validation
constraint instead, which is introduced in Symfony 4.3.

Applies to:

* [properties](http://symfony.com/doc/7.2/validation.html#properties)
* [methods](http://symfony.com/doc/7.2/validation.html#getters)

Options:

* [message](#message)

## Basic Usage

### Attributes

```php
// src/AppBundle/Entity/Transaction.php
namespace AppBundle\Entity;

use DarkWebDesign\SymfonyAddonConstraints as AddonAssert;

class Transaction
{
    #[AddonAssert\Json]
    protected $data;
}
```

### YAML

```yaml
# src/AppBundle/Resources/config/validation.yml
AppBundle\Entity\Transaction:
    properties:
        data:
            - DarkWebDesign\SymfonyAddonConstraints\Json: ~
```

### XML

```xml
<!-- src/AppBundle/Resources/config/validation.xml -->
<?xml version="1.0" encoding="UTF-8" ?>
<constraint-mapping xmlns="http://symfony.com/schema/dic/constraint-mapping"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://symfony.com/schema/dic/constraint-mapping http://symfony.com/schema/dic/constraint-mapping/constraint-mapping-1.0.xsd">

    <class name="AppBundle\Entity\Transaction">
        <property name="data">
            <constraint name="DarkWebDesign\SymfonyAddonConstraints\Json" />
        </property>
    </class>
</constraint-mapping>
```

### PHP

```php
// src/AppBundle/Entity/Transaction.php
namespace AppBundle\Entity;

use DarkWebDesign\SymfonyAddonConstraints as AddonAssert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Transaction
{
    protected $data;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('data', new AddonAssert\Json());
    }
}
```

## Available Options

### message

**type**: `string` **default**: `This value is not valid JSON.`

The default message supplied when the value does not pass the JSON check.
