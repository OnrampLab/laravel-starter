<?php

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/tests',
        __DIR__ . '/packages',
        __DIR__ . '/resources',
    ])
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$config = new PhpCsFixer\Config();

return $config->setRules([
        '@PhpCsFixer' => true,
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        'single_space_after_construct' => true,
        'array_syntax' => ['syntax' => 'short'],
        'concat_space' => ['spacing' => 'one'],
        'header_comment' => ['header' => ''],
        'ordered_imports' => ['imports_order' => ['class', 'function', 'const'], 'sort_algorithm' => 'none'],
        'yoda_style' => ['equal' => false, 'identical' => false, 'less_and_greater' => false],
        'trailing_comma_in_multiline' => ['elements' => ['arguments'], 'after_heredoc' => true],
        'phpdoc_align' => ['align' => 'left'],
    ])
    ->setFinder($finder);
