<?php

namespace taskforce\classes;

class CancelAction extends AbstractAction
{
    protected string $name = 'cancel';
    protected string $label = 'Отменено';

    public function VerificationRight($customer_id, $executor_id, $user_id):bool {
        if ($customer_id === $user_id) {
            return true;
        } else {
            return false;
        }
    }

}
