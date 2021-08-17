<?php

namespace taskforce\classes;

abstract class AbstractAction
{
    protected string $name;
    protected string $label;

    public function getName():string {
        return $this->name;
    }

    public function getLabel():string {
        return $this->label;
    }

    abstract protected function verificationRight($customer_id, $executor_id, $user_id);
}
