<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Symfony\Set\SymfonyLevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);

    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_80,
        SymfonyLevelSetList::UP_TO_SYMFONY_60,
    ]);

    $rectorConfig->importNames(true, false);
    $rectorConfig->importShortClasses(false);
};
