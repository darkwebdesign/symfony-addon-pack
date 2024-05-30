# Symfony Add-on Pack

[![Latest Stable Version](https://poser.pugx.org/darkwebdesign/symfony-addon-pack/v/stable?format=flat)](https://packagist.org/packages/darkwebdesign/symfony-addon-pack)
[![Total Downloads](https://poser.pugx.org/darkwebdesign/symfony-addon-pack/downloads?format=flat)](https://packagist.org/packages/darkwebdesign/symfony-addon-pack)
[![License](https://poser.pugx.org/darkwebdesign/symfony-addon-pack/license?format=flat)](https://packagist.org/packages/darkwebdesign/symfony-addon-pack)

[![Build Status](https://github.com/darkwebdesign/symfony-addon-pack/actions/workflows/build.yaml/badge.svg?branch=6.0)](https://github.com/darkwebdesign/symfony-addon-pack/actions/workflows/build.yaml)
[![Coverage Status](https://codecov.io/gh/darkwebdesign/symfony-addon-pack/branch/6.0/graph/badge.svg)](https://codecov.io/gh/darkwebdesign/symfony-addon-pack)
[![PHP Version](https://img.shields.io/badge/php-8.0%2B-777BB3.svg)](https://php.net/)
[![Symfony Version](https://img.shields.io/badge/symfony-6.0-93C74B.svg)](https://symfony.com/)

Symfony Add-on Pack is a collection of extra Symfony components that you can use in your Symfony applications.

Learn more about it in its [documentation](https://darkwebdesign.github.io/symfony-addon-pack/docs/6.0).

## Features

### Data Transformers

* BooleanToValueTransformer, transforms between a boolean and a scalar value.
* EntityToIdentifierTransformer, transforms between an identifier and a Doctrine entity.

### Form Field Types

* BirthdayType, handles birthday data.
* BooleanType, transforms a user selected value into a boolean.
* EntityType, transforms a user entered identifier into a Doctrine entity.
* UnstructuredType, handles unstructured data.

### Form Field Event Subscribers

* BooleanToYesNoSubscriber, rewrites boolean values to "yes" or "no", to be used with the `BooleanType`.
* JsonSchemaSubscriber, rewrites the JSON Schema `$schema` keyword property.

### Validation Constraints

* Bsn, validates that a value is a valid Dutch social security number (BSN).
* Collection, validates that every item in a collection validates against one or more constraints.
* Json, validates that a value is valid JSON.

## License

Symfony Add-on Pack is licensed under the MIT License - see the `LICENSE` file for details.
