<?php
declare(strict_types=1);

ini_set('display_errors', 'On');
error_reporting(E_ALL);

use taskforce\loader\DbLoader;
use taskforce\exception\SourceFileException;

require_once 'vendor/autoload.php';

$tables = [
    'cities' => [],
    'users' => [],
    'profiles' => ['user_id'],
    'categories' => [],
    'tasks' => ['executor_id', 'author_id', 'city_id'],
    'replies' => ['executor_id', 'task_id'],
    'opinions' => ['executor_id', 'task_id'],
];

foreach ($tables as $table => $columns) {
    try {
        $loader = new DbLoader(__DIR__ .'/data/' . $table . '.csv', $table, $columns);
        $loader->import();
    } catch (SourceFileException $e) {
        echo $e->getMessage();
    }
}

