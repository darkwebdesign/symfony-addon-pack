[Home](../../index.md) /
[Reference Documents](../index.md) /
[Validation Constraints Reference](index.md) /
Collection

# Collection

This constraint is used when the underlying data is a collection (i.e. an array or an object that implements `Traversable`), but
you'd like to validate every item of that collection against one or more constraints. For example, you might validate a
collection of email addresses using the `Email` and `NotBlank` constraint.

```text
Note: In contradiction to the Collection constraint provided by Symfony, this constraint is used to validate every
      item in a collection against the same set of constraints.
```

Applies to:

* [properties](http://symfony.com/doc/2.7/book/validation.html#properties)
* [methods](http://symfony.com/doc/2.7/book/validation.html#getters)

Options:

* [constraints](#constraints)

## Basic Usage

### Annotations

```php
// src/AppBundle/Entity/Person.php
namespace AppBundle\Entity;

use DarkWebDesign\SymfonyAddon\Constraint as AddonAssert;

class Person
{
    /**
     * @AddonAssert\Collection(
     *     constraints = {
     *         @Assert\Email,
     *         @Assert\NotBlank
     *     }
     * )
     */
    protected $emails;
}
```

### YAML

```yaml
# src/AppBundle/Resources/config/validation.yml
AppBundle\Entity\Person:
    properties:
        emails:
            - DarkWebDesign\SymfonyAddon\Constraint\Collection:
                constraints:
                    - Email
                    - NotBlank
```

### XML

```xml
<!-- src/AppBundle/Resources/config/validation.xml -->
<?xml version="1.0" encoding="UTF-8" ?>
<constraint-mapping xmlns="http://symfony.com/schema/dic/constraint-mapping"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://symfony.com/schema/dic/constraint-mapping http://symfony.com/schema/dic/constraint-mapping/constraint-mapping-1.0.xsd">

    <class name="AppBundle\Entity\Person">
        <property name="emails">
            <constraint name="DarkWebDesign\SymfonyAddon\Constraint\Collection">
                <option name="constraints">
                    <constraint name="Email" />
                    <constraint name="NotBlank" />
                </option>
            </constraint>
        </property>
    </class>
</constraint-mapping>
```

### PHP

```php
// src/AppBundle/Entity/Person.php
namespace AppBundle\Entity;

use DarkWebDesign\SymfonyAddon\Validator\Constraints as AddonAssert;
use Symfony\Component\Validator\Mapping\ClassMetadata;

class Person
{
    protected $emails;

    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('emails', new AddonAssert\Collection(
            'constraints' => array(
                new Assert\Email(),
                new Assert\NotBlank(),
            ),
        ));
    }
}
```

## Available Options

### constraints

**type**: `array` [default option]

The constraints to validate every item in the collection against.
