<?php

namespace app\models;

use app\components\enums\StatusEnum;
use DateTime;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "milestone".
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $title
 * @property string $start_date
 * @property string $end_date
 * @property integer $user_id
 * @property string $created_date
 * @property string $updated_date
 * 
 * @property Issue[] $issues
 */
class Milestone extends \yii\db\ActiveRecord
{

    public $daysLeft;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'milestone';
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
            [['project_id', 'title'], 'required'],
            [['project_id', 'user_id'], 'integer'],
            [['created_date', 'updated_date', 'start_date', 'end_date'], 'safe'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'project_id' => Yii::t('app', 'Project'),
            'title' => Yii::t('app', 'Title'),
            'user_id' => Yii::t('app', 'User'),
            'created_date' => Yii::t('app', 'Created Date'),
            'updated_date' => Yii::t('app', 'Updated Date'),
            'start_date' => Yii::t('app', 'Start Date'),
            'end_date' => Yii::t('app', 'End Date'),
        ];
    }
    
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
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
    
    public function getIssues()
    {
        return $this->hasMany(Issue::className(), ['milestone_id' => 'id']);
    }

    public function getOpenedIssues()
    {
        return $this->hasMany(Issue::className(), ['milestone_id' => 'id'])->andWhere('status_id<:closed', [':closed' => StatusEnum::CLOSED]);
    }
    
    public static function getOptions($projectId)
    {
        return \yii\helpers\ArrayHelper::map(self::find()->andWhere(['project_id' => $projectId])->all(), 'id', 'title');
    }

    public function afterFind()
    {
        if ($this->end_date) {
            $rDate1 = new DateTime($this->end_date);
            $rDate2 = new DateTime(date('Y-m-d'));
            $this->daysLeft = $rDate1->diff($rDate2)->days.' '.\Yii::t('app', 'day(s)');
        } else {
            $this->daysLeft = \Yii::t('app', 'not set');
        }

        parent::afterFind();
    }

}