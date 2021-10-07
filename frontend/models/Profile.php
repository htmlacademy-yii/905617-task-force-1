<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%profiles}}".
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $phone
 * @property string|null $address
 * @property string|null $bd
 * @property string|null $about
 * @property string|null $skype
 *
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%profiles}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['bd'], 'safe'],
            [['about'], 'string'],
            [['phone'], 'string', 'max' => 15],
            [['address', 'skype'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'phone' => 'Phone',
            'address' => 'Address',
            'bd' => 'Bd',
            'about' => 'About',
            'skype' => 'Skype',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery|UserQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     * @return ProfilesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ProfilesQuery(get_called_class());
    }
}
