<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude([
        'config',
        'public',
        'var',
        'node_modules'
    ])
    ->notPath([
        'tests/bootstrap.php',
    ])
    ->name('*.php')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@Symfony' => true,
        'declare_strict_types' => true,
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder)
;
