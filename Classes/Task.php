<?php

require_once 'Classes/StartAction.php';
require_once 'Classes/ResponseAction.php';
require_once 'Classes/CompleteAction.php';
require_once 'Classes/CancelAction.php';
require_once 'Classes/FailAction.php';


class Task
{
	const STATUS_NEW = 'new';
	const STATUS_CANCELED = 'action_canceled';
	const STATUS_PROCESSING = 'action_processing';
	const STATUS_DONE = 'action_done';
	const STATUS_FAILED = 'action_failed';

    const MAP_LABELS = [
        self::STATUS_NEW => 'Задание опубликовано, исполнитель ещё не найден',
        self::STATUS_CANCELED => 'Заказчик отменил задание',
        self::STATUS_PROCESSING => 'Задание в процессе исполнения',
        self::STATUS_DONE => 'Задание выполнено',
	];

    /**
     * @var StartAction
     */
    private $startAction;

    /**
     * @var ResponseAction
     */
    private $responseAction;

    /**
     * @var CompleteAction
     */
    private $completeAction;

    /**
     * @var CancelAction
     */
    private $cancelAction;

    /**
     * @var FailAction
     */
    private $failAction;

	public $customer_id;
	public $executor_id;
    public $user_id;
	public $actual_status;

    public function __construct($customer_id, $executor_id, $user_id, $actual_status, StartAction $startAction, ResponseAction $responseAction, CompleteAction $completeAction, CancelAction $cancelAction, FailAction $failAction)
    {
       $this->customer_id = $customer_id;
       $this->executor_id = $executor_id;
       $this->user_id = $user_id;
       $this->actual_status = $actual_status;
       $this->startAction = $startAction;
       $this->responseAction = $responseAction;
       $this->completeAction = $completeAction;
       $this->cancelAction = $cancelAction;
       $this->failAction = $failAction;
    }

    public function getNextStatus(string $action):string
    {
        switch ($action) {
            case $this->startAction->getName():
                return self::STATUS_PROCESSING;
            case $this->completeAction->getName():
                return self::STATUS_DONE;
            case $this->cancelAction->getName():
                return self::STATUS_CANCELED;
            case $this->failAction->getName():
                return self::STATUS_FAILED;
            default:
                return '';

        }
    }
    public function getLabel($code):string
    {
        return self::MAP_LABELS[$code] ?? '';
    }

    public function availableActions():string
    {
            switch ($this->actual_status) {
                case self::STATUS_NEW:
                    if ($this->cancelAction->VerificationRight($this->customer_id, $this->executor_id, $this->user_id)) {
                        return self::STATUS_CANCELED;
                    } else {
                        return self::STATUS_PROCESSING;
                    }
                case self::STATUS_PROCESSING:
                    if ($this->completeAction->VerificationRight($this->customer_id, $this->executor_id, $this->user_id)) {
                        return self::STATUS_DONE;
                    } else {
                        return self::STATUS_FAILED;
                    }
            }
    }

}
