<?php
require_once "vendor/autoload.php";

$customer_id = 1;
$executor_id = 2;
$user_id = 1;
$actual_status = taskforce\models\Task::STATUS_NEW;

$task = new taskforce\models\Task($customer_id, $executor_id, $user_id, $actual_status);

assert($task->availableActions() == new taskforce\classes\CancelAction());

$task = new taskforce\models\Task($customer_id, $executor_id, $user_id, taskforce\models\Task::STATUS_FAILED);

assert($task->availableActions() === false);

$task = new taskforce\models\Task($customer_id, $executor_id, 2, $actual_status);

assert($task->availableActions() == new taskforce\classes\ResponseAction());

$task = new taskforce\models\Task($customer_id, $executor_id, $user_id, taskforce\models\Task::STATUS_PROCESSING);

assert($task->availableActions() == new taskforce\classes\CompleteAction());

$task = new taskforce\models\Task($customer_id, $executor_id, 2, taskforce\models\Task::STATUS_PROCESSING);

assert($task->availableActions() == new taskforce\classes\FailAction());

$task = new taskforce\models\Task($customer_id, $executor_id, 2, taskforce\models\Task::STATUS_FAILED);

assert($task->availableActions() === false);

echo 'Все проверки прошли успешно!';
