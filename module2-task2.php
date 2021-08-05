<?php
require_once "vendor/autoload.php";

$customer_id = 1;
$executor_id = 2;
$user_id = 1;
$actual_status = myorg\Task::STATUS_NEW;
$startAction = new myorg\StartAction();
$responseAction = new myorg\ResponseAction();
$completeAction = new myorg\CompleteAction();
$cancelAction = new myorg\CancelAction();
$failAction = new myorg\FailAction();

$task = new myorg\Task($customer_id, $executor_id, $user_id, $actual_status, $startAction, $responseAction, $completeAction, $cancelAction, $failAction);

assert($task->availableActions() === myorg\Task::STATUS_CANCELED);

$task = new myorg\Task($customer_id, $executor_id, 2, $actual_status, $startAction, $responseAction, $completeAction, $cancelAction, $failAction);

assert($task->availableActions() === myorg\Task::STATUS_PROCESSING);

$task = new myorg\Task($customer_id, $executor_id, $user_id, myorg\Task::STATUS_PROCESSING, $startAction, $responseAction, $completeAction, $cancelAction,$failAction);

assert($task->availableActions() === myorg\Task::STATUS_DONE);

$task = new myorg\Task($customer_id, $executor_id, 2, myorg\Task::STATUS_PROCESSING, $startAction, $responseAction, $completeAction, $cancelAction, $failAction);

assert($task->availableActions() === myorg\Task::STATUS_FAILED);

assert($task->getNextStatus($startAction->getName()) === myorg\Task::STATUS_PROCESSING);
assert($task->getNextStatus($responseAction->getName()) === '');
assert($task->getNextStatus($completeAction->getName()) === myorg\Task::STATUS_DONE);
assert($task->getNextStatus($cancelAction->getName()) === myorg\Task::STATUS_CANCELED);
assert($task->getNextStatus($failAction->getName()) === myorg\Task::STATUS_FAILED);

echo 'Все проверки прошли успешно!';
