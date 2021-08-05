<?php
require_once "vendor/autoload.php";

$customer_id = 1;
$executor_id = 2;
$user_id = 1;
$actual_status = taskforce\models\Task::STATUS_NEW;

$task = new taskforce\models\Task($customer_id, $executor_id, $user_id, $actual_status);

assert($task->availableActions() === [true, false]);

$task = new taskforce\models\Task($customer_id, $executor_id, $user_id, taskforce\models\Task::STATUS_FAILED);

assert($task->availableActions() === []);

$task = new taskforce\models\Task($customer_id, $executor_id, 2, $actual_status);

assert($task->availableActions() === [false, true]);

$task = new taskforce\models\Task($customer_id, $executor_id, $user_id, taskforce\models\Task::STATUS_PROCESSING);

assert($task->availableActions() === [true, false]);

$task = new taskforce\models\Task($customer_id, $executor_id, 2, taskforce\models\Task::STATUS_PROCESSING);

assert($task->availableActions() === [false, true]);

$task = new taskforce\models\Task($customer_id, $executor_id, 2, taskforce\models\Task::STATUS_FAILED);

assert($task->availableActions() === []);

echo 'Все проверки прошли успешно!';
