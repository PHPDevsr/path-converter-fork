<?php

$finder = PhpCsFixer\Finder::create()
    ->exclude('vendor')
    ->in(__DIR__);

$config = new PhpCsFixer\Config();

return $config
    ->setRules([
        '@Symfony' => true,
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'single_line_throw' => false,
        'yoda_style' => ['equal' => false, 'identical' => false, 'less_and_greater' => false],
        'class_definition' => false, // @see https://github.com/FriendsOfPHP/PHP-CS-Fixer/issues/5463
        'visibility_required' => ['elements' => ['property', 'method']],
    ])
    ->setFinder($finder)
    ->setUsingCache(false);
