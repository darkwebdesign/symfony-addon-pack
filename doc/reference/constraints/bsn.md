[Home](../../index.md) /
[Reference Documents](../index.md) /
[Validation Constraints Reference](../constraints.md) /
Bsn

# Bsn

This constraint is used to ensure that a value has the proper format of a Dutch social security number.

Applies to:

* [properties](http://symfony.com/doc/2.3/book/validation.html#properties)
* [methods](http://symfony.com/doc/2.3/book/validation.html#getters)

Options:

* [message](#message)
* [payload](#payload)

## Basic Usage

### Annotations

```php
// src/AppBundle/Entity/Transaction.php
namespace AppBundle\Entity;

use DarkWebDesign\SymfonyAddon\Validator\Constraints as AddonAssert;

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
            - DarkWebDesign\SymfonyAddon\Validator\Constraints\Bsn: ~
```

### XML

```xml
<!-- src/AppBundle/Resources/config/validation.xml -->
<class name="AppBundle\Entity\Person">
    <property name="socialSecurityNumber">
        <constraint name="DarkWebDesign\SymfonyAddon\Validator\Constraints\Bsn" />
    </property>
</class>
```

### PHP

```php
// src/AppBundle/Entity/Person.php
namespace AppBundle\Entity;

use DarkWebDesign\SymfonyAddon\Validator\Constraints as AddonAssert;
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

**type**: `string` **default**: `This is not a valid Dutch social security number (BSN).`

The default message supplied when the value does not pass the BSN check.

---

### payload

**type**: `mixed` **default**: `null`

This option can be used to attach arbitrary domain-specific data to a constraint. The configured payload is not used by the
Validator component, but its processing is completely up to you.

For example, you may want to use several error levels to present failed constraints differently in the front-end depending on
the severity of the error.
