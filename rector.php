<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Symfony\Set\SymfonyLevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/symfony-addon-constraints/src',
        __DIR__ . '/symfony-addon-constraints/tests',
        __DIR__ . '/symfony-addon-form-types/src',
        __DIR__ . '/symfony-addon-form-types/tests',
        __DIR__ . '/symfony-addon-transformers/src',
        __DIR__ . '/symfony-addon-transformers/tests',
    ]);

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_80,
        SymfonyLevelSetList::UP_TO_SYMFONY_60,
    ]);

    $rectorConfig->importNames(true, false);
    $rectorConfig->importShortClasses(false);
};
