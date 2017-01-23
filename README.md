# Symfony Add-on Pack

[![Latest Stable Version](https://poser.pugx.org/darkwebdesign/symfony-addon-pack/v/stable?format=flat)](https://packagist.org/packages/darkwebdesign/symfony-addon-pack)
[![Total Downloads](https://poser.pugx.org/darkwebdesign/symfony-addon-pack/downloads?format=flat)](https://packagist.org/packages/darkwebdesign/symfony-addon-pack)
[![License](https://poser.pugx.org/darkwebdesign/symfony-addon-pack/license?format=flat)](https://packagist.org/packages/darkwebdesign/symfony-addon-pack)

[![Build Status](https://travis-ci.org/darkwebdesign/symfony-addon-pack.svg?branch=2.3)](https://travis-ci.org/darkwebdesign/symfony-addon-pack?branch=2.3)
[![Coverage Status](https://codecov.io/gh/darkwebdesign/symfony-addon-pack/branch/2.3/graph/badge.svg)](https://codecov.io/gh/darkwebdesign/symfony-addon-pack)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.3-blue.svg)](https://php.net/)
[![Minimum Symfony Version](https://img.shields.io/badge/symfony-%3E%3D%202.3-green.svg)](https://symfony.com/)

Symfony Add-on Pack is a collection of extra Symfony components that you can use in your Symfony applications.

Learn more about it in its [documentation](https://github.com/darkwebdesign/symfony-addon-pack/blob/2.3/doc/index.md).

## Features

### Data Transformers

* BooleanToValueTransformer, transforms between a boolean and a scalar value.
* EntityToIdentifierTransformer, transforms between an identifier and a Doctrine entity.

### Form Field Types

* BooleanType, transforms an user selected value into a boolean.
* EntityType, transforms an user entered identifier into a Doctrine entity.

### Validation Constraints

* Bsn, validates that a value is a valid Dutch social security number (BSN).
* Json, validates that a value is valid JSON.

## Installing via Composer

```bash
composer require darkwebdesign/symfony-addon-pack
```

```bash
composer install
```

## License

Symfony Add-on Pack is licensed under the MIT License - see the `LICENSE` file for details.
