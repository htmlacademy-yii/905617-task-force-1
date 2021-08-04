<?php

require_once 'Classes/AbstractAction.php';

class FailAction extends AbstractAction
{
    public function getName():string {
        return 'fail';
    }

    public function getLabel():string {
        return 'Провалено';
    }

    public function VerificationRight($customer_id, $executor_id, $user_id):bool {
        if ($executor_id === $user_id) {
            return true;
        } else {
            return false;
        }
    }

}
