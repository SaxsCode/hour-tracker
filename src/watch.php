<?php

require_once __DIR__ . '/../vendor/autoload.php';
const DIRECTORY = 'C:\Users\maxsa\Documents\projects';
define("FILE_NAME", realpath(__DIR__ . '/../log') . "/" . date('Y-m-d'));

use Spatie\Watcher\Watch;

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


/**
 * Get paths from pathSrtring and return as array
 * @param string $pathString
 * @param string $type
 * @return string[]
 */
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
 * Create log file to store all changes
 * @param string $path
 * @param string $type
 * @return void
 */
function writeLog(string $path, string $type): void
{
    $log = fopen(FILE_NAME . "_log.txt", "a");
    fwrite($log, date('H:i:s') . ": {$path} - {$type}\n");
    fclose($log);

    echo date('H:i:s') . " - Logged activity", PHP_EOL;
}

/**
 * Create overview file to store changed projects with timestamps
 * @param string $path
 * @return void
 */
function writeOverview(string $path): void
{
    $filename = FILE_NAME . "_overview.txt";
    $project = explode("\\", $path)[0];
    $currentTime = date('H:i:s');

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
    fwrite($overview, $currentTime . " - {$project}\n");
    fclose($overview);

    echo $currentTime . " - Written in overview", PHP_EOL;
}