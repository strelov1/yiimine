<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "note".
 *
 * @property integer $id
 * @property string $for_date
 * @property string $description
 * @property integer $user_id
 * @property string $created_date
 * @property string $updated_date
 */
class Note extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'note';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['for_date', 'created_date', 'updated_date'], 'safe'],
            [['description'], 'string'],
            [['user_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'for_date' => Yii::t('app', 'For Date'),
            'description' => Yii::t('app', 'Description'),
            'user_id' => Yii::t('app', 'User ID'),
            'created_date' => Yii::t('app', 'Created Date'),
            'updated_date' => Yii::t('app', 'Updated Date'),
        ];
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
}