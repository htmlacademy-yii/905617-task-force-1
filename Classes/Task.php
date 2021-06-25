<?php


class Task
{

	const STATUS_NEW = 'new';
	const STATUS_CANCEL = 'action_cancel';
	const STATUS_PROGRERESS = 'action_progress';
	const STATUS_DONE = 'action_done';
	const STATUS_FAIL = 'action_fail';

	private $map_task = [
        'new' => 'Задание опубликовано, исполнитель ещё не найден',
        'action_cancel' => 'Заказчик отменил задание',
        'action_progress' => 'Заказчик выбрал исполнителя для задания',
        'action_done' => 'Заказчик отметил задание как выполненное',
        'action_fail' => 'Исполнитель отказался от выполнения задания',
	];

	public $id_customer;
	public $id_executor;

    public function __construct($id_customer, $id_executor)
    {
       $this->id_customer = $id_customer;
       $this->id_executor = $id_executor;
    }

    private function getNextStatus($action) {
        return $key_action = array_search($action, $this->map_task);
    }

    private function availableActions($status) {
        foreach ($this->map_task as $key=>$value) {
            if ($key == self::STATUS_NEW) {
                return ['action_cancel', 'action_progress'];
            } elseif ($key == self::STATUS_PROGRERESS) {
                return ['action_done', 'action_fail'];
            } else {
                return null;
            }
        }
    }
    
}
