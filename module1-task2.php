<?php
require_once 'Classes/Task.php';

$customer_id = 1;
$executor_id = 2;
$actual_status = Task::STATUS_NEW;
$task = new Task($customer_id, $executor_id, $actual_status);

assert($task->getNextStatus(Task::ACTION_START) === Task::STATUS_PROCESSING);
assert($task->getNextStatus(Task::ACTION_RESPONSE) === '');
assert($task->getNextStatus(Task::ACTION_COMPLETE) === Task::STATUS_DONE);
assert($task->getNextStatus(Task::ACTION_CANCEL) === Task::STATUS_CANCELED);
assert($task->getNextStatus(Task::ACTION_FAIL) === Task::STATUS_FAILED);

assert($task->getLabel(Task::STATUS_NEW) === Task::MAP_LABELS[Task::STATUS_NEW]);
assert($task->getLabel(Task::STATUS_CANCELED) === Task::MAP_LABELS[Task::STATUS_CANCELED]);
assert($task->getLabel(Task::STATUS_PROCESSING) === Task::MAP_LABELS[Task::STATUS_PROCESSING]);
assert($task->getLabel(Task::STATUS_DONE) === Task::MAP_LABELS[Task::STATUS_DONE]);
assert($task->getLabel(Task::STATUS_FAILED) === Task::MAP_LABELS[Task::STATUS_FAILED]);
assert($task->getLabel(Task::ACTION_START) === Task::MAP_LABELS[Task::ACTION_START]);
assert($task->getLabel(Task::ACTION_RESPONSE) === Task::MAP_LABELS[Task::ACTION_RESPONSE]);
assert($task->getLabel(Task::ACTION_COMPLETE) === Task::MAP_LABELS[Task::ACTION_COMPLETE]);
assert($task->getLabel(Task::ACTION_CANCEL) === Task::MAP_LABELS[Task::ACTION_CANCEL]);
assert($task->getLabel(Task::ACTION_FAIL) === Task::MAP_LABELS[Task::ACTION_FAIL]);
assert($task->getLabel('') === '');

assert($task->availableActions() === [Task::STATUS_CANCELED, Task::STATUS_PROCESSING]);

$task = new Task($customer_id, $executor_id, Task::STATUS_CANCELED);
assert($task->availableActions() === []);

$task = new Task($customer_id, $executor_id, Task::STATUS_PROCESSING);
assert($task->availableActions() === [Task::STATUS_DONE, Task::STATUS_FAILED]);

$task = new Task($customer_id, $executor_id, Task::STATUS_DONE);
assert($task->availableActions() === []);

$task = new Task($customer_id, $executor_id, Task::STATUS_FAILED);
assert($task->availableActions() === []);

echo 'Все проверки прошли успешно!';
