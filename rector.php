<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/symfony-addon-constraints/src',
        __DIR__ . '/symfony-addon-constraints/tests',
        __DIR__ . '/symfony-addon-form-types/src',
        __DIR__ . '/symfony-addon-form-types/tests',
        __DIR__ . '/symfony-addon-transformers/src',
        __DIR__ . '/symfony-addon-transformers/tests',
    ])
    ->withSets([
        LevelSetList::UP_TO_PHP_82,
    ])
    ->withImportNames(
        importShortClasses: false,
    );
