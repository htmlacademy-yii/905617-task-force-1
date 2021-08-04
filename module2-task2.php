<?php

require_once 'Classes/Task.php';
require_once 'Classes/StartAction.php';
require_once 'Classes/ResponseAction.php';
require_once 'Classes/CompleteAction.php';
require_once 'Classes/CancelAction.php';
require_once 'Classes/FailAction.php';

$customer_id = 1;
$executor_id = 2;
$user_id = 1;
$actual_status = Task::STATUS_NEW;
$startAction = new StartAction();
$responseAction = new ResponseAction();
$completeAction = new CompleteAction();
$cancelAction = new CancelAction();
$failAction = new FailAction();

$task = new Task($customer_id, $executor_id, $user_id, $actual_status, $startAction, $responseAction, $completeAction, $cancelAction, $failAction);

assert($task->availableActions() === Task::STATUS_CANCELED);

$task = new Task($customer_id, $executor_id, 2, $actual_status, $startAction, $responseAction, $completeAction, $cancelAction, $failAction);

assert($task->availableActions() === Task::STATUS_PROCESSING);

$task = new Task($customer_id, $executor_id, $user_id, Task::STATUS_PROCESSING, $startAction, $responseAction, $completeAction, $cancelAction,$failAction);

assert($task->availableActions() === Task::STATUS_DONE);

$task = new Task($customer_id, $executor_id, 2, Task::STATUS_PROCESSING, $startAction, $responseAction, $completeAction, $cancelAction, $failAction);

assert($task->availableActions() === Task::STATUS_FAILED);

assert($task->getNextStatus($startAction->getName()) === Task::STATUS_PROCESSING);
assert($task->getNextStatus($responseAction->getName()) === '');
assert($task->getNextStatus($completeAction->getName()) === Task::STATUS_DONE);
assert($task->getNextStatus($cancelAction->getName()) === Task::STATUS_CANCELED);
assert($task->getNextStatus($failAction->getName()) === Task::STATUS_FAILED);

echo 'Все проверки прошли успешно!';
