[Home](../../index.md) /
[Reference Documents](../index.md) /
[Validation Constraints Reference](index.md) /
Json

# Json

This constraint is used to ensure that a value has the proper format of a JSON-encoded string.

Applies to:

* [properties](http://symfony.com/doc/2.8/book/validation.html#properties)
* [methods](http://symfony.com/doc/2.8/book/validation.html#getters)

Options:

* [message](#message)

## Basic Usage

### Annotations

```php
// src/AppBundle/Entity/Transaction.php
namespace AppBundle\Entity;

use DarkWebDesign\SymfonyAddon\Constraint as AddonAssert;

class Transaction
{
    /**
     * @AddonAssert\Json()
     */
    protected $data;
}
```

### YAML

```yaml
# src/AppBundle/Resources/config/validation.yml
AppBundle\Entity\Transaction:
    properties:
        data:
            - DarkWebDesign\SymfonyAddon\Constraint\Json: ~
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
            <constraint name="DarkWebDesign\SymfonyAddon\Constraint\Json" />
        </property>
    </class>
</constraint-mapping>
```

### PHP

```php
// src/AppBundle/Entity/Transaction.php
namespace AppBundle\Entity;

use DarkWebDesign\SymfonyAddon\Constraint as AddonAssert;
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
