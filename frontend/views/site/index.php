<?php

/* @var $this yii\web\View */

use frontend\models\User;
use frontend\models\Task;

$this->title = 'Taskforce';

$users = User::find()->one();

print_r('Пользователь с id: '.$users['id'].'<br> Id его задач: ');

$tasks = Task::find()->where(['author_id' => $users['id']])->all();

foreach ($tasks as $task) {
    $user_task[] = $task['id'];
}
print_r(implode(",", $user_task));

