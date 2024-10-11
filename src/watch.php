<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Spatie\Watcher\Watch;

const DIRECTORY = 'C:\Users\maxsa\Documents\projects';

echo "WATCHING...", PHP_EOL;

Watch::path(DIRECTORY)
    ->onAnyChange(function (string $type, string $path) {

        if(shouldIgnorePath($path)) {
            return;
        }

        $path = str_replace(DIRECTORY, "", $path);
        echo $path . " - " . $type, PHP_EOL;
    })
    ->start();


/**
 * Checks if given path should be ignored
 * @param string $path
 * @return bool
 */
function shouldIgnorePath(string $path): bool
{
    $folders = ['.idea', '.git', '.vscode'];
    $pattern = '/[\/\\\\](' . implode('|', array_map('preg_quote', $folders)) . ')[\/\\\\]/';

    return preg_match($pattern, $path) === 1;
}