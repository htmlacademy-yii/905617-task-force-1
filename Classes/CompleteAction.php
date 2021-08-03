<?php

namespace actions;

class CompleteAction extends AbstractAction
{
    public function getName():string {
        return 'complete';
    }

    public function getLabel():string {
        return 'Задача завершена';
    }

    public function VerificationRight($customer_id, $executor_id, $user_id):bool {
        if ($customer_id === $user_id) {
            return true;
        } else {
            return false;
        }
    }

}

