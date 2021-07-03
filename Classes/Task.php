<?php


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

	public $customer_id;
	public $executor_id;
	public $actual_status;

    public function __construct($customer_id, $executor_id, $actual_status)
    {
       $this->customer_id = $customer_id;
       $this->executor_id = $executor_id;
       $this->actual_status = $actual_status;
    }

    public function getNextStatus(string $action):string
    {
        switch ($action) {
            case self::ACTION_START:
                return self::STATUS_PROCESSING;
            case self::ACTION_COMPLETE:
                return self::STATUS_DONE;
            case self::ACTION_CANCEL:
                return self::STATUS_CANCELED;
            case self::ACTION_FAIL:
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
            switch ($this->actual_status) {
                case self::STATUS_NEW:
                    return [self::STATUS_CANCELED, self::STATUS_PROCESSING];
                case self::STATUS_PROCESSING:
                    return [self::STATUS_DONE, self::STATUS_FAILED];
                default:
                    return [];
            }
    }

}
