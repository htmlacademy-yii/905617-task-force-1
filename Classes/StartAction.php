<?php

namespace myorg;

class StartAction extends AbstractAction
{
    public function getName():string {
        return 'start';
    }

    public function getLabel():string {
        return 'Начало исполнения задачи';
    }

    public function VerificationRight($customer_id, $executor_id, $user_id):bool {
        if ($customer_id === $user_id) {
            return true;
        } else {
            return false;
        }
    }

}
