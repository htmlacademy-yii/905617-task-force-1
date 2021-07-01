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
        self::STATUS_PROCESSING => 'Заказчик выбрал исполнителя для задания',
        self::STATUS_DONE => 'Заказчик отметил задание как выполненное',
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

    public function getNextStatus($action) {
        switch ($action) {
            case self::ACTION_START:
                return self::STATUS_PROCESSING;
                break;
            case self::ACTION_COMPLETE:
                return self::STATUS_DONE;
                break;
            case self::ACTION_CANCEL:
                return self::STATUS_CANCELED;
                break;
            case self::ACTION_FAIL:
                return self::STATUS_FAILED;
                break;
            default:
                return null;

        }
    }
    public function getLabel($code) {
        return self::MAP_LABELS[$code] ?? null;
    }

    public function availableActions() {

            switch ($this->actual_status) {
                case self::STATUS_NEW:
                    return [self::STATUS_CANCELED, self::STATUS_PROCESSING];
                    break;
                case self::STATUS_PROGRERESS:
                    return [self::STATUS_DONE, self::STATUS_FAILED];
                    break;
                default:
                    return [];
            }
    }

}
