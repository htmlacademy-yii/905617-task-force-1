<?php

namespace taskforce\classes;

class FailAction extends AbstractAction
{
    protected string $name = 'fail';
    protected string $label = 'Провалено';

    public function verificationRight($customer_id, $executor_id, $user_id):bool {
        if ($executor_id === $user_id) {
            return true;
        } else {
            return false;
        }
    }

}
