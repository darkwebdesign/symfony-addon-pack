# Symfony Add-on Form Types

[![Latest Stable Version](https://poser.pugx.org/darkwebdesign/symfony-addon-form-types/v/stable?format=flat)](https://packagist.org/packages/darkwebdesign/symfony-addon-form-types)
[![Total Downloads](https://poser.pugx.org/darkwebdesign/symfony-addon-form-types/downloads?format=flat)](https://packagist.org/packages/darkwebdesign/symfony-addon-form-types)
[![License](https://poser.pugx.org/darkwebdesign/symfony-addon-form-types/license?format=flat)](https://packagist.org/packages/darkwebdesign/symfony-addon-form-types)

[![Build Status](https://app.travis-ci.com/darkwebdesign/symfony-addon-form-types.svg?branch=5.4)](https://app.travis-ci.com/darkwebdesign/symfony-addon-form-types)
[![Coverage Status](https://codecov.io/gh/darkwebdesign/symfony-addon-form-types/branch/5.4/graph/badge.svg)](https://codecov.io/gh/darkwebdesign/symfony-addon-form-types)
[![PHP Version](https://img.shields.io/badge/php-7.2%2B-777BB3.svg)](https://php.net/)
[![Symfony Version](https://img.shields.io/badge/symfony-5.4-93C74B.svg)](https://symfony.com/)

Symfony Add-on Form Types is a collection of extra Symfony form field types that you can use in your Symfony applications.

Learn more about it in its [documentation](https://darkwebdesign.github.io/symfony-addon-pack/docs/5.4).

## Features

### Form Field Types

* BirthdayType, handles birthday data.
* BooleanType, transforms a user selected value into a boolean.
* EntityType, transforms a user entered identifier into a Doctrine entity.
* UnstructuredType, handles unstructured data.

### Form Field Event Subscribers

* BooleanToYesNoSubscriber, rewrites boolean values to "yes" or "no", to be used with the `BooleanType`.
* JsonSchemaSubscriber, rewrites the JSON Schema `$schema` keyword property.

## License

Symfony Add-on Form Types is licensed under the MIT License - see the `LICENSE` file for details.
