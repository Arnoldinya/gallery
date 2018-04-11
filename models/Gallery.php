<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%gallery}}".
 *
 * @property int $id
 * @property int $userId
 * @property string $name
 * @property int $created
 * @property int $updated
 *
 * @property User $user
 * @property Photo[] $photos
 */
class Gallery extends ActiveRecord
{
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => 'updated',
            ],
        ];
    }

    public static function tableName()
    {
        return '{{%gallery}}';
    }

    public function rules()
    {
        return [
            [['userId', 'name'], 'required'],
            [['userId', 'created', 'updated'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['userId'], 'unique', 'message' => 'Максимальное кол-во галерей 1 шт.'],
            [['userId'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userId' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'      => 'ID',
            'userId'  => 'Пользователь',
            'name'    => 'Название',
            'created' => 'Дата создания',
            'updated' => 'Дата обновления',
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userId']);
    }

    public function getPhotos($limit = false)
    {
        $query = $this->hasMany(Photo::className(), ['galleryId' => 'id']);
        if($limit)
        {
            $query->limit($limit);
        }

        return $query->all();
    }
}
