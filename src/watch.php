<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Spatie\Watcher\Watch;

const DIRECTORY = 'C:\Users\maxsa\Documents\projects';

echo "WATCHING...", PHP_EOL;

Watch::path(DIRECTORY)
    ->onAnyChange(function (string $type, string $pathString) {

        $paths = getPaths($pathString, $type);

        foreach ($paths as $path) {
            if(shouldIgnorePath($path, $type)) {
                return;
            }

            $path = str_replace(DIRECTORY . '\\', '', $path);
            $path = str_replace(["\n", "\r"], '', $path);

            writeLog($path, $type);
            writeOverview($path);
        }
    })
    ->start();


function getPaths(string $pathString, string $type): array {
    $paths = [$pathString];

    if (str_contains($pathString, $type)) {
        $paths = explode($type . " - ", $pathString);
    }

    return $paths;
}

/**
 * Checks if given path should be ignored
 * @param string $path
 * @return bool
 */
function shouldIgnorePath(string $path, string $type): bool
{
    $folders = ['.idea', '.git', '.vscode', 'log'];
    $pattern = '/[\/\\\\](' . implode('|', array_map('preg_quote', $folders)) . ')[\/\\\\]/';

    return preg_match($pattern, $path) === 1;
}

/**
 * Create log file to store changes
 * @param string $path
 * @param string $type
 * @return void
 */
function writeLog(string $path, string $type): void
{
    $log = fopen(realpath(__DIR__ . '/../log') . "/" .  date('Y-m-d') . "_log.txt", "a");
    fwrite($log, date('H:i:s') . ": {$path} - {$type}\n");
    fclose($log);

    echo date('H:i:s') . " - Logged activity", PHP_EOL;
}

function writeOverview(string $path): void
{
    $filename = realpath(__DIR__ . '/../log') . "/" .  date('Y-m-d') . "_overview.txt";
    $project = explode("\\", $path)[0];

    if (file_exists($filename)) {
        $lines = file($filename);
        $last_line = $lines[count($lines)-1];

        if(!empty($last_line))
        {
            $currentProject = explode("- ", $last_line)[1];
            $currentProject = str_replace(["\n", "\r"], '', $currentProject);

            if ($project === $currentProject)
            {
                return;
            }
        }
    }

    $overview = fopen($filename, "a");
    fwrite($overview, date('H:i:s') . " - {$project}\n");
    fclose($overview);

    echo $overview;

    echo date('H:i:s') . " - Written in overview", PHP_EOL;
}