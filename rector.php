<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/symfony-addon-constraints/src',
        __DIR__ . '/symfony-addon-constraints/tests',
        __DIR__ . '/symfony-addon-form-types/src',
        __DIR__ . '/symfony-addon-form-types/tests',
        __DIR__ . '/symfony-addon-transformers/src',
        __DIR__ . '/symfony-addon-transformers/tests',
    ])
    ->withPhpSets()
    ->withAttributesSets()
    ->withPreparedSets(phpunitCodeQuality: true, doctrineCodeQuality: true, symfonyCodeQuality: true, symfonyConfigs: true)
    ->withComposerBased(doctrine: true, phpunit: true, symfony: true)
    ->withImportNames(importShortClasses: false, removeUnusedImports: true)
    ->withTypeCoverageLevel(0)
    ->withDeadCodeLevel(0)
    ->withCodeQualityLevel(0);
