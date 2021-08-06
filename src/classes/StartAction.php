<?php

namespace taskforce\classes;

class StartAction extends AbstractAction
{
    protected string $name = 'start';
    protected string $label = 'Начало исполнения задачи';

    public function VerificationRight($customer_id, $executor_id, $user_id):bool {
        if ($customer_id === $user_id) {
            return true;
        } else {
            return false;
        }
    }

}
