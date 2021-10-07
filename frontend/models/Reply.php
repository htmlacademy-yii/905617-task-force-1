<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%replies}}".
 *
 * @property int $id
 * @property int $executor_id
 * @property int $task_id
 * @property int|null $rate
 * @property string|null $description
 * @property string $dt_add
 *
 * @property User $executor
 * @property Task $task
 */
class Reply extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%replies}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['executor_id', 'task_id'], 'required'],
            [['executor_id', 'task_id', 'rate'], 'integer'],
            [['dt_add'], 'safe'],
            [['description'], 'string', 'max' => 1000],
            [['executor_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['executor_id' => 'id']],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'executor_id' => 'Executor ID',
            'task_id' => 'Task ID',
            'rate' => 'Rate',
            'description' => 'Description',
            'dt_add' => 'Dt Add',
        ];
    }

    /**
     * Gets query for [[Executor]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getExecutor()
    {
        return $this->hasOne(User::className(), ['id' => 'executor_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery|TaskQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }

    /**
     * {@inheritdoc}
     * @return RepliesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RepliesQuery(get_called_class());
    }
}
