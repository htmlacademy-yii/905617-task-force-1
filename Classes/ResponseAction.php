<?php

namespace actions;

class ResponseAction extends AbstractAction
{
    public function getName():string {
        return 'response';
    }

    public function getLabel():string {
        return 'Отклик на задание';
    }

    public function VerificationRight($customer_id, $executor_id, $user_id):bool {
        if ($customer_id !== $user_id) {
            return true;
        } else {
            return false;
        }
    }

}
