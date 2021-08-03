<?php

use actions\StartAction;
use actions\ResponseAction;
use actions\CompleteAction;
use actions\CancelAction;
use actions\FailAction;

class Task
{
	const STATUS_NEW = 'new';
	const STATUS_CANCELED = 'action_canceled';
	const STATUS_PROCESSING = 'action_processing';
	const STATUS_DONE = 'action_done';
	const STATUS_FAILED = 'action_failed';

    const ACTION_START = 'start';
    const ACTION_RESPONSE = 'response';
    const ACTION_COMPLETE = 'complete';
    const ACTION_CANCEL = 'cancel';
    const ACTION_FAIL = 'fail';

    const MAP_LABELS = [
        self::STATUS_NEW => 'Задание опубликовано, исполнитель ещё не найден',
        self::STATUS_CANCELED => 'Заказчик отменил задание',
        self::STATUS_PROCESSING => 'Задание в процессе исполнения',
        self::STATUS_DONE => 'Задание выполнено',
        self::STATUS_FAILED => 'Исполнитель отказался от выполнения задания',
        self::ACTION_START => 'Начало исполнения задачи',
        self::ACTION_RESPONSE => 'Отклик на задание',
        self::ACTION_COMPLETE => 'Задача завершена',
        self::ACTION_CANCEL => 'Отменено',
        self::ACTION_FAIL => 'Провалено',
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

    public function availableActions():object
    {
            switch ($this->actual_status) {
                case self::STATUS_NEW:
                    if ($this->cancelAction->VerificationRight($this->customer_id, $this->executor_id, $this->user_id)) {
                        return $this->cancelAction;
                    } else {
                        return $this->responseAction;
                    }
                case self::STATUS_PROCESSING:
                    if ($this->completeAction->VerificationRight($this->customer_id, $this->executor_id, $this->user_id)) {
                        return $this->completeAction;
                    } else {
                        return $this->failAction;
                    }
            }
    }

}
