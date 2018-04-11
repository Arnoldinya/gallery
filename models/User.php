<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $authKey
 * @property string $password
 * @property int $created
 * @property int $updated
 *
 * @property Gallery $gallery
 */
class User extends ActiveRecord implements IdentityInterface
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
        return '{{%user}}';
    }

    public function rules()
    {
        return [
            [['email', 'name', 'password'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['created', 'updated'], 'integer'],
            [['email', 'name', 'password'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'       => 'ID',
            'email'    => 'Email',
            'password' => 'Пароль',
            'name'     => 'ФИО',
            'created'  => 'Дата создания',
            'updated'  => 'ДАта обновления',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['name' => $username]);
    }

    /**
     * Finds user by email
     *
     * @param string $email
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->authKey = Yii::$app->security->generateRandomString();
    }

    public function generatePassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    public function getGallery()
    {
        return $this->hasOne(Gallery::className(), ['userId' => 'id']);
    }
}
