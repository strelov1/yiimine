<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tag_model".
 *
 * @property string $model_name
 * @property integer $model_id
 * @property integer $tag_id
 */
class TagModel extends \yii\db\ActiveRecord
{
    const MODEL_WIKI = 'wiki';
    const MODEL_FILES = 'files';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag_model';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_name', 'model_id', 'tag_id'], 'required'],
            [['model_id', 'tag_id'], 'integer'],
            [['model_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'model_name' => Yii::t('app', 'Model Name'),
            'model_id' => Yii::t('app', 'Model ID'),
            'tag_id' => Yii::t('app', 'Tag ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTag()
    {
        return $this->hasOne(Tag::className(), ['id' => 'tag_id']);
    }
}