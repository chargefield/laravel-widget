<?php

require __DIR__.'/vendor/autoload.php';

return (new MattAllan\LaravelCodeStyle\Config())
    ->setFinder(
        PhpCsFixer\Finder::create()
            ->in(__DIR__.'/src')
            ->in(__DIR__.'/tests')
    )
    ->setRules([
        '@Laravel' => true,
    ]);
