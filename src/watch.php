<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Spatie\Watcher\Watch;

const DIRECTORY = 'C:/Users/maxsa/Documents/projects';

Watch::path(DIRECTORY)
    ->onAnyChange(function (string $type, string $path) {
       echo $type;
       echo $path;
    })
    ->start();