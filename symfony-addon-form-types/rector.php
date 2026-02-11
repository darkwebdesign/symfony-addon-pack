<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withPhpSets()
    ->withAttributesSets()
    ->withPreparedSets(phpunitCodeQuality: true, doctrineCodeQuality: true, symfonyCodeQuality: true, symfonyConfigs: true)
    ->withComposerBased(doctrine: true, phpunit: true, symfony: true)
    ->withImportNames(importShortClasses: false, removeUnusedImports: true)
    ->withTypeCoverageLevel(0)
    ->withDeadCodeLevel(0)
    ->withCodeQualityLevel(0);
