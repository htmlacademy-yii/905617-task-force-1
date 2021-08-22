<?php

namespace taskforce\models;

use taskforce\classes\StartAction;
use taskforce\classes\ResponseAction;
use taskforce\classes\CompleteAction;
use taskforce\classes\CancelAction;
use taskforce\classes\FailAction;

use taskforce\exception\ActionException;
use taskforce\exception\StatusException;
use taskforce\exception\UserException;

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

    /**
     * Task constructor.
     * @param int $customer_id
     * @param int|null $executor_id
     * @param int $user_id
     * @param string $actual_status
     * @throws StatusException
     * @throws UserException
     */
    public function __construct(int $customer_id, int $user_id, string $actual_status, ?int $executor_id = null)
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

        if (!$this->actual_status) {
            throw new StatusException("Статус задачи не передан");
        }

        if (!$this->customer_id) {
            throw new UserException("Не передано id заказчика");
        }

        if (!$this->user_id) {
            throw new UserException("Не передано id пользователя");
        }
    }

    /**
     * @param string $action
     * @return string
     * @throws ActionException
     */
    public function getNextStatus(string $action): string
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
                throw new ActionException($action . ' - это имя для действия некорректно');;

        }
    }

    /**
     * @param string $code
     * @return string
     */
    public function getLabel(string $code): string
    {
        return self::MAP_LABELS[$code] ?? '';
    }

    /**
     * @return array
     */
    public function availableActions(): array
    {
        if ($this->customer_id === $this->executor_id) {
            throw new UserException("Пользователь не может быть одновременно и заказчиком и исполнителем");
        }

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
