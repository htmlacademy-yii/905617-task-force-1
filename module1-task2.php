<?php
require_once 'Classes/Task.php';

$customer_id = 1;
$executor_id = 2;
$actual_status = Task::STATUS_NEW;
$strategy = new Task($customer_id, $executor_id, $actual_status);

assert($strategy->getNextStatus('start') == Task::STATUS_PROCESSING);
assert($strategy->getNextStatus('response') == '');
assert($strategy->getNextStatus('complete') == Task::STATUS_DONE);
assert($strategy->getNextStatus('cancel') == Task::STATUS_CANCELED);
assert($strategy->getNextStatus('fail') == Task::STATUS_FAILED);

assert($strategy->getLabel('new') == Task::MAP_LABELS[Task::STATUS_NEW]);
assert($strategy->getLabel('action_canceled') == Task::MAP_LABELS[Task::STATUS_CANCELED]);
assert($strategy->getLabel('action_processing') == Task::MAP_LABELS[Task::STATUS_PROCESSING]);
assert($strategy->getLabel('action_done') == Task::MAP_LABELS[Task::STATUS_DONE]);
assert($strategy->getLabel('action_failed') == Task::MAP_LABELS[Task::STATUS_FAILED]);
assert($strategy->getLabel('start') == Task::MAP_LABELS[Task::ACTION_START]);
assert($strategy->getLabel('response') == Task::MAP_LABELS[Task::ACTION_RESPONSE]);
assert($strategy->getLabel('complete') == Task::MAP_LABELS[Task::ACTION_COMPLETE]);
assert($strategy->getLabel('cancel') == Task::MAP_LABELS[Task::ACTION_CANCEL]);
assert($strategy->getLabel('fail') == Task::MAP_LABELS[Task::ACTION_FAIL]);
assert($strategy->getLabel('') == '');

assert($strategy->availableActions() == [Task::STATUS_CANCELED, Task::STATUS_PROCESSING]);
assert($strategy->availableActions() !== [Task::STATUS_DONE, Task::STATUS_FAILED]);
assert($strategy->availableActions() !== []);

echo 'Все проверки прошли успешно!';
