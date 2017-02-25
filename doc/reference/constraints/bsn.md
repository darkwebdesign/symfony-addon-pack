[Home](../../index.md) /
[Reference Documents](../index.md) /
[Validation Constraints Reference](index.md) /
Bsn

# Bsn

This constraint is used to ensure that a value has the proper format of a Dutch social security number.

Applies to:

* [properties](http://symfony.com/doc/2.8/book/validation.html#properties)
* [methods](http://symfony.com/doc/2.8/book/validation.html#getters)

Options:

* [message](#message)

## Basic Usage

### Annotations

```php
// src/AppBundle/Entity/Person.php
namespace AppBundle\Entity;

use DarkWebDesign\SymfonyAddon\Constraint as AddonAssert;

class Person
{
    /**
     * @AddonAssert\Bsn()
     */
    protected $socialSecurityNumber;
}
```

### YAML

```yaml
# src/AppBundle/Resources/config/validation.yml
AppBundle\Entity\Person:
    properties:
        socialSecurityNumber:
            - DarkWebDesign\SymfonyAddon\Constraint\Bsn: ~
```

### XML

```xml
<!-- src/AppBundle/Resources/config/validation.xml -->
<?xml version="1.0" encoding="UTF-8" ?>
<constraint-mapping xmlns="http://symfony.com/schema/dic/constraint-mapping"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://symfony.com/schema/dic/constraint-mapping http://symfony.com/schema/dic/constraint-mapping/constraint-mapping-1.0.xsd">

    <class name="AppBundle\Entity\Person">
        <property name="socialSecurityNumber">
            <constraint name="DarkWebDesign\SymfonyAddon\Constraint\Bsn" />
        </property>
    </class>
</constraint-mapping>
```

### PHP

```php
// src/AppBundle/Entity/Person.php
namespace AppBundle\Entity;

use DarkWebDesign\SymfonyAddon\Constraint as AddonAssert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Person
{
    protected $socialSecurityNumber;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('socialSecurityNumber', new AddonAssert\Bsn());
    }
}
```

## Available Options

### message

**type**: `string` **default**: `This value is not a valid Dutch social security number (BSN).`

The default message supplied when the value does not pass the BSN check.
