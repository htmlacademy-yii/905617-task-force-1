<?php

namespace taskforce\models;

use taskforce\classes\StartAction;
use taskforce\classes\ResponseAction;
use taskforce\classes\CompleteAction;
use taskforce\classes\CancelAction;
use taskforce\classes\FailAction;

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
    private $cancelAction ;

    /**
     * @var FailAction
     */
    private $failAction;

	public $customer_id;
	public $executor_id;
  public $user_id;
	public $actual_status;

    public function __construct($customer_id, $executor_id, $user_id, $actual_status)
    {
       $this->customer_id = $customer_id;
       $this->executor_id = $executor_id;
       $this->user_id = $user_id;
       $this->actual_status = $actual_status;
       $this->startAction = new StartAction();
       $this->responseAction = new ResponseAction();
       $this->completeAction = new CompleteAction();
       $this->cancelAction = new CancelAction();
       $this->failAction = new FailAction();
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

    public function availableActions():array
    {
        $possible_actions = [];

        switch ($this->actual_status) {
            case self::STATUS_NEW:
                if ($this->cancelAction->verificationRight($this->customer_id, $this->executor_id, $this->user_id)) {
                    $possible_actions[] = $this->startAction;
                    $possible_actions[] = $this->cancelAction;
                } else {
                    $possible_actions[] = $this->responseAction;
                }
                break;
            case self::STATUS_PROCESSING:
                if ($this->completeAction->verificationRight($this->customer_id, $this->executor_id, $this->user_id)) {
                    $possible_actions[] = $this->completeAction;
                } else {
                    $possible_actions[] = $this->failAction;
                }
                break;
        }

        return $possible_actions;
    }

}
