<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "{{%photo}}".
 *
 * @property int $id
 * @property int $galleryId
 * @property string $name
 * @property string $description
 * @property string $filePath
 * @property int $created
 * @property int $updated
 *
 * @property Gallery $gallery
 */
class Photo extends ActiveRecord
{
    public $file;

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
        return '{{%photo}}';
    }

    public function rules()
    {
        return [
            [['galleryId', 'name'], 'required'],
            [['galleryId', 'created', 'updated'], 'integer'],
            [['description'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['filePath'], 'string', 'max' => 400],
            [['galleryId'], 'exist', 'skipOnError' => true, 'targetClass' => Gallery::className(), 'targetAttribute' => ['galleryId' => 'id']],
            [['file'], 'file', 'skipOnEmpty' => true, 'when' => function($model) {
                return $model->filePath  != '';
            }, 'whenClient' => "function (attribute, value) {
                return !$('#photo-filepath').val() != '';
            }"],
            [['file'], 'file', 'skipOnEmpty' => false, 'when' => function($model) {
                return $model->filePath == '';
            }, 'whenClient' => "function (attribute, value) {
                return $('#photo-filepath').val() == '';
            }"],
            [['file'], 'file', 'extensions' => 'png, jpg'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'galleryId'   => 'Галерея',
            'name'        => 'Название',
            'description' => 'Описание',
            'file'        => 'Файл',
            'filePath'    => 'Файл',
            'created'     => 'Дата создания',
            'updated'     => 'Дата обновления',
        ];
    }

    public function upload()
    {
        $filePath = Yii::getAlias('@webroot').'/upload/'.$this->galleryId.'/';
        if ($this->validate() && FileHelper::createDirectory($filePath) && $this->file->saveAs($filePath.$this->file->baseName.'.'.$this->file->extension))
        {
            $this->filePath = '/upload/'.$this->galleryId.'/'.$this->file->baseName.'.'.$this->file->extension;
            return true;
        }
        else
        {
            return false;
        }
    }

    public function getGallery()
    {
        return $this->hasOne(Gallery::className(), ['id' => 'galleryId']);
    }
}
