<?php

namespace taskforce\classes;

class ResponseAction extends AbstractAction
{
    protected string $name = 'response';
    protected string $label = 'Отклик на задание';

    public function verificationRight($customer_id, $executor_id, $user_id):bool {
        if ($customer_id !== $user_id) {
            return true;
        } else {
            return false;
        }
    }

}
