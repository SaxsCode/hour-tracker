<?php

// [REQUIRED] DIRECTORY: FOLDER TO BE TRACKED

// IGNORED_FOLDERS: FOLDERS TO IGNORE INSIDE DIRECTORY
// LOG_DIR: DIRECTORY TO STORE LOGS AND OVERVIEWS

return [
    'DIRECTORY' => 'C:\Users\maxsa\Documents\projects',
    'IGNORED_FOLDERS' => ['ht_logs', '.idea', '.git', '.vscode', 'vendor', 'node_modules'],
    'LOG_DIR' => realpath(__DIR__ . '\..\ht_logs'),
];