<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "issue_photo".
 *
 * @property integer $id
 * @property string $file
 * @property integer $issue_id
 */
class IssuePhoto extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'issue_photo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['file', 'issue_id'], 'required'],
            [['issue_id'], 'integer'],
            [['file'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'file' => Yii::t('app', 'File'),
            'issue_id' => Yii::t('app', 'Issue ID'),
        ];
    }
}