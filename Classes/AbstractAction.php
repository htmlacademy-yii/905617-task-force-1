<?php

namespace myorg;

abstract class AbstractAction
{
    abstract protected function getName();
    abstract protected function getLabel();
    abstract protected function VerificationRight($customer_id, $executor_id, $user_id);
}
