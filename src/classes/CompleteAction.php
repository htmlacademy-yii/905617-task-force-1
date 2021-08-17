<?php

namespace taskforce\classes;

class CompleteAction extends AbstractAction
{
    public function getName():string {
        return 'complete';
    }

    public function getLabel():string {
        return 'Задача завершена';
    }

    public function verificationRight($customer_id, $executor_id, $user_id):bool {
        if ($customer_id === $user_id) {
            return true;
        } else {
            return false;
        }
    }

}

