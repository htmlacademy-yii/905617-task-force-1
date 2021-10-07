<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%users}}".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $status
 * @property int|null $city_id
 * @property int|null $avatar_file_id
 * @property string|null $other_contact
 * @property string $dt_add
 * @property int|null $photo_id
 * @property int $new_message
 * @property int $action_task
 * @property int $new_review
 * @property int $show_contact
 * @property int $show_profile
 *
 * @property CategoryUser[] $categoryUsers
 * @property City $city
 * @property File[] $files
 * @property Message[] $messages
 * @property Message[] $messages0
 * @property Opinion[] $opinions
 * @property Profile[] $profiles
 * @property Reply[] $replies
 * @property Task[] $tasks
 * @property Task[] $tasks0
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password'], 'required'],
            [['status'], 'string'],
            [['city_id', 'avatar_file_id', 'photo_id', 'new_message', 'action_task', 'new_review', 'show_contact', 'show_profile'], 'integer'],
            [['dt_add'], 'safe'],
            [['name', 'email', 'password', 'other_contact'], 'string', 'max' => 255],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'status' => 'Status',
            'city_id' => 'City ID',
            'avatar_file_id' => 'Avatar File ID',
            'other_contact' => 'Other Contact',
            'dt_add' => 'Dt Add',
            'photo_id' => 'Photo ID',
            'new_message' => 'New Message',
            'action_task' => 'Action Task',
            'new_review' => 'New Review',
            'show_contact' => 'Show Contact',
            'show_profile' => 'Show Profile',
        ];
    }

    /**
     * Gets query for [[CategoryUsers]].
     *
     * @return \yii\db\ActiveQuery|CategoryUserQuery
     */
    public function getCategoryUsers()
    {
        return $this->hasMany(CategoryUser::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery|CityQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery|FilesQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Messages]].
     *
     * @return \yii\db\ActiveQuery|MessagesQuery
     */
    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['sender_id' => 'id']);
    }

    /**
     * Gets query for [[Messages0]].
     *
     * @return \yii\db\ActiveQuery|MessagesQuery
     */
    public function getMessages0()
    {
        return $this->hasMany(Message::className(), ['recipient_id' => 'id']);
    }

    /**
     * Gets query for [[Opinions]].
     *
     * @return \yii\db\ActiveQuery|OpinionsQuery
     */
    public function getOpinions()
    {
        return $this->hasMany(Opinion::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[Profiles]].
     *
     * @return \yii\db\ActiveQuery|ProfilesQuery
     */
    public function getProfiles()
    {
        return $this->hasMany(Profile::className(), ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Replies]].
     *
     * @return \yii\db\ActiveQuery|RepliesQuery
     */
    public function getReplies()
    {
        return $this->hasMany(Reply::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['executor_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks0]].
     *
     * @return \yii\db\ActiveQuery|TasksQuery
     */
    public function getTasks0()
    {
        return $this->hasMany(Task::className(), ['author_id' => 'id']);
    }

    /**
     * {@inheritdoc}
     * @return UsersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UsersQuery(get_called_class());
    }
}
