<?php

namespace app\models;

use Yii;
use yii\imagine\Image;
use yii\web\UploadedFile;

/**
 * This is the model class for table "settings".
 *
 * @property integer $id
 * @property string $key
 * @property string $value
 * @property integer $user_id
 *
 * @property User $user
 */
class Settings extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['key', 'value'], 'required'],
            [['value'], 'safe'],
            [['user_id'], 'integer'],
            [['key'], 'string', 'max' => 255],
            [
                ['key', 'user_id'],
                'unique',
                'targetAttribute' => ['key', 'user_id'],
                'message' => 'The combination of Key and User ID has already been taken.'
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Key',
            'value' => 'Value',
            'user_id' => 'User ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->user_id = \Yii::$app->user->id;
            }

            return true;
        }

        return false;
    }

    /**
     * @param UploadedFile $file
     */
    public function saveFile(UploadedFile $file)
    {
        if ($file) {
            $folder = \Yii::getAlias('@webroot').'/uploads/settings/'. $this->key.'/';
            if (is_dir($folder) == false) {
                mkdir($folder, 0755, true);
            }
            $file->saveAs($folder . $file->name);
            Image::thumbnail($folder . $file->name, 160, 90)
                ->save($folder . 'thumb_' . $file->name, ['quality' => 90]);
        }
    }


    public static function getAppSettings()
    {
        if (self::getDb()->schema->getTableSchema('settings') === null) {
            return \Yii::$app->response->redirect(['install/index']);
        }

        return self::find()
            ->where(['key' => ['app_name', 'app_description', 'app_logo']])->all();
    }

}