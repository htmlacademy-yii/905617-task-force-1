<?php
$customer_id = 1;
$executor_id = 2;
$actual_status = Task::STATUS_NEW;
$task = new Task($customer_id, $executor_id, $actual_status);
$task->getLabel(Task::STATUS_NEW);
echo $task->getLabel(Task::STATUS_NEW);
