<?php

namespace actions;

class CancelAction extends AbstractAction
{
    public function getName():string {
        return 'cancel';
    }

    public function getLabel():string {
        return 'Отменено';
    }

    public function VerificationRight($customer_id, $executor_id, $user_id):bool {
        if ($customer_id === $user_id) {
            return true;
        } else {
            return false;
        }
    }

}
