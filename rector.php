<?php

declare(strict_types = 1);

use Rector\CodeQuality\Rector\Class_\InlineConstructorDefaultToPropertyRector;
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\{LevelSetList, SetList};
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictConstructorRector;
use RectorLaravel\Set\LaravelSetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/app',
        // __DIR__.'/bootstrap',
        // __DIR__.'/config',
        // __DIR__.'/lang',
        // __DIR__.'/public',
        __DIR__ . '/resources',
        // __DIR__ . '/routes',
        // __DIR__.'/tests',
    ])
    ->withSets([
        LevelSetList::UP_TO_PHP_83,
        LaravelSetList::LARAVEL_110,
        SetList::CODE_QUALITY,
        SetList::DEAD_CODE,
        SetList::EARLY_RETURN,
        SetList::TYPE_DECLARATION,
        SetList::PRIVATIZATION,
    ])
    ->withRules([
        AddVoidReturnTypeWhereNoReturnRector::class,
        InlineConstructorDefaultToPropertyRector::class,
        TypedPropertyFromStrictConstructorRector::class,
    ]);
