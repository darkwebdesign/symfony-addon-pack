<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = (new Finder())
    ->in(__DIR__);

return (new Config())
    ->setRules([
        '@PhpCsFixer' => true,
        '@PSR1' => true,
        '@PSR2' => true,
        '@PSR12' => true,
        '@Symfony' => true,
        'concat_space' => ['spacing' => 'one'], // overrules @Symfony
        'global_namespace_import' => ['import_classes' => false],
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'], // overrules @PhpCsFixer
        'no_superfluous_elseif' => false, // overrules @PhpCsFixer
        'phpdoc_align' => ['tags' => ['method', 'param', 'property', 'return', 'throws', 'type', 'var'], 'align' => 'left'], // overrules @Symfony
        'yoda_style' => false, // overrules @Symfony
    ])
    ->setFinder($finder);
