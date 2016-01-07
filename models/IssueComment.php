<?php

namespace app\models;

use app\components\helpers\MailHelper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\AfterSaveEvent;
use yii\db\BaseActiveRecord;
use yii\db\Expression;

/**
 * This is the model class for table "issue_comment".
 *
 * @property integer $id
 * @property integer $issue_id
 * @property integer $user_id
 * @property string $text
 * @property integer $status_id
 * @property string $created_date
 * @property string $updated_date
 *
 * @property User $user
 * @property Issue $issue
 */
class IssueComment extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'issue_comment';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_date',
                'updatedAtAttribute' => 'updated_date',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['issue_id', 'text'], 'required'],
            [['issue_id', 'user_id', 'status_id'], 'integer'],
            [['text'], 'string'],
            [['created_date', 'updated_date'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'issue_id' => Yii::t('app', 'Issue ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'text' => Yii::t('app', 'Comment'),
            'created_date' => Yii::t('app', 'Created Date'),
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


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssue()
    {
        return $this->hasOne(Issue::className(), ['id' => 'issue_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        MailHelper::newComment($this);
    }

}