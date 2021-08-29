<?php
declare(strict_types=1);

ini_set('display_errors', 'On');
error_reporting(E_ALL);

use taskforce\loader\DbLoader;

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

    $loader = new DbLoader('/domains/task-force/data/' . $table . '.csv', $table, $columns);

    $loader->import();
}

