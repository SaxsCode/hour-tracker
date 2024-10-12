# Hour Tracker Application - by Sax

## Overview

This Hour Tracker Application is a PHP script that monitors a specified directory for file changes. It logs these changes and provides an overview of which projects have been modified. This tool is particularly useful for developers who want to track their work across multiple projects.

## Features

- Monitors a specified directory for file changes
- Logs all file activities with timestamps
- Creates an overview of changed projects
- Ignores specified folders to reduce noise
- Configurable settings via a separate file

## Requirements

- PHP 7.4 or higher
- Composer
- [spatie/file-system-watcher](https://github.com/spatie/file-system-watcher) package

## Installation

1. Clone this repository:
   ```
   git clone https://github.com/SaxsCode/hour-tracker.git
   cd hour-tracker
   ```

2. Install dependencies using Composer:
   ```
   composer install
   ```
3. Edit `settings.php` to configure your watched directory and other settings.

## Configuration

Open `settings.php` and modify the following settings:

- `DIRECTORY`: The full path to the directory you want to watch
- `IGNORED_FOLDERS`: An array of folder names to ignore
- `LOG_DIR`: The directory where log files will be stored

Example:
```php
return [
    'DIRECTORY' => 'C:\Users\YourUsername\Documents\Projects',
    'IGNORED_FOLDERS' => ['.idea', '.git', '.vscode', 'log'],
    'LOG_DIR' => realpath(__DIR__ . '/../log'),
];
```

## Usage

To start the File Watcher, run:

```
php path/hourtracker/src/watch.php
```

The script will start monitoring the specified directory and output messages to the console when changes are detected and logged.

## Log Files

The application generates two types of log files in the specified `LOG_DIR`:

1. `YYYY-MM-DD_log.txt`: Detailed log of all file activities
2. `YYYY-MM-DD_overview.txt`: Overview of changed projects with timestamps

