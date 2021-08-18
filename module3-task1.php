<?php

use taskforce\classes\CancelAction;
use taskforce\classes\CompleteAction;
use taskforce\classes\FailAction;
use taskforce\classes\ResponseAction;
use taskforce\classes\StartAction;

require_once "vendor/autoload.php";

$customer_id = 1;
$executor_id = 2;
$user_id = 1;
$actual_status = taskforce\models\Task::STATUS_NEW;

$task = new taskforce\models\Task($customer_id, $user_id, $actual_status, $executor_id);

$startAction = new StartAction();
$responseAction = new ResponseAction();
$completeAction = new CompleteAction();
$cancelAction = new CancelAction();
$failAction = new FailAction();

assert($task->availableActions() == [new taskforce\classes\StartAction(), new taskforce\classes\CancelAction()]);

$task = new taskforce\models\Task($customer_id, $user_id, taskforce\models\Task::STATUS_FAILED, $executor_id);

assert($task->availableActions() === []);

$task = new taskforce\models\Task($customer_id, 2, $actual_status, $executor_id);

assert($task->availableActions() == [new taskforce\classes\ResponseAction()]);

$task = new taskforce\models\Task($customer_id, $user_id, taskforce\models\Task::STATUS_PROCESSING, $executor_id);

assert($task->availableActions() == [new taskforce\classes\CompleteAction()]);

$task = new taskforce\models\Task($customer_id, 2, taskforce\models\Task::STATUS_PROCESSING, $executor_id);

assert($task->availableActions() == [new taskforce\classes\FailAction()]);

$task = new taskforce\models\Task($customer_id, 2, taskforce\models\Task::STATUS_FAILED, $executor_id);

assert($task->availableActions() === []);

$task = new taskforce\models\Task($customer_id, $user_id, $actual_status, $executor_id);

assert($task->getNextStatus($startAction->getName()) === $task::STATUS_PROCESSING);
assert($task->getNextStatus($completeAction->getName()) === $task::STATUS_DONE);
assert($task->getNextStatus($cancelAction->getName()) === $task::STATUS_CANCELED);
assert($task->getNextStatus($failAction->getName()) === $task::STATUS_FAILED);

echo 'Все проверки прошли успешно!';

assert($task->getNextStatus($responseAction->getName()) === '');
