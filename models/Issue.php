<?php

namespace app\models;

use app\components\behaviors\MultiFileUploadBehavior;
use app\components\enums\StatusEnum;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\AfterSaveEvent;
use yii\db\BaseActiveRecord;
use yii\db\Expression;
use yii\helpers\Html;

/**
 * This is the model class for table "issue".
 *
 * @property integer $id
 * @property integer $tracker_id
 * @property string $subject
 * @property string $description
 * @property integer $status_id
 * @property integer $priority_id
 * @property integer $assignee_id
 * @property string $deadline
 * @property integer $readiness_id
 * @property string $image_array
 * @property integer $project_id
 * @property integer $creator_id
 * @property string $created_date
 * @property string $updated_date
 * @property integer $milestone_id
 *
 * @property User $performer
 * @property Project $project
 */
class Issue extends \yii\db\ActiveRecord
{
    public $image_array = [];
    private $old_status_id;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'issue';
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
            'multiFileUploader' => [
                'class' => MultiFileUploadBehavior::className(),
                'savePath' => 'uploads/issue',
                'fileField' => 'image_array',
                'relatedModel' => 'app\models\IssuePhoto',
                'relatedModelField' => 'file',
                'relatedOwnerField' => 'issue_id',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tracker_id', 'status_id', 'priority_id', 'assignee_id', 'readiness_id', 'project_id', 'creator_id', 'milestone_id'], 'integer'],
            [['subject', 'project_id'], 'required'],
            [['description'], 'string'],
            [['deadline', 'image_array'], 'safe'],
            [['subject'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tracker_id' => Yii::t('app', 'Tracker'),
            'subject' => Yii::t('app', 'Subject'),
            'description' => Yii::t('app', 'Description'),
            'status_id' => Yii::t('app', 'Status'),
            'priority_id' => Yii::t('app', 'Priority'),
            'assignee_id' => Yii::t('app', 'Assignee'),
            'deadline' => Yii::t('app', 'Deadline'),
            'readiness_id' => Yii::t('app', '% Done'),
            'image_array' => Yii::t('app', 'Images'),
            'project_id' => Yii::t('app', 'Project'),
            'created_date' => Yii::t('app', 'Created Date'),
            'updated_date' => Yii::t('app', 'Updated Date'),
            'creator_id' => Yii::t('app', 'Author'),
            'milestone_id' => Yii::t('app', 'Milestone'),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->creator_id = \Yii::$app->user->id;
            }
            return true;
        }

        return false;
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignee()
    {
        return $this->hasOne(User::className(), ['id' => 'assignee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPhotos() {
        return $this->hasMany(IssuePhoto::className(), ['issue_id' => 'id']);
    }
    
    public function getMilestone()
    {
        return $this->hasOne(Milestone::className(), ['id' => 'milestone_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments() {
        return $this->hasMany(IssueComment::className(), ['issue_id' => 'id']);
    }

    public function getCommentsCount()
    {
        return $this->hasMany(IssueComment::className(), ['issue_id' => 'id'])->count();
    }

    public function getCheckLists()
    {
        return $this->hasMany(IssueChecklist::className(), ['issue_id' => 'id']);
    }

    public function getCheckListsCount()
    {
        return $this->hasMany(IssueChecklist::className(), ['issue_id' => 'id'])->count();
    }

    public function getOnListItems()
    {
        return $this->hasMany(IssueChecklist::className(), ['issue_id' => 'id'])->andWhere(['status_id' => IssueChecklist::STATUS_NEW])->count();
    }

    public function getOffListItems()
    {
        return $this->hasMany(IssueChecklist::className(), ['issue_id' => 'id'])->andWhere(['status_id' => IssueChecklist::STATUS_DONE])->count();
    }

    public static function getReadinessOptions()
    {
        $arr = [];
        for ($i=0; $i<=100; $i+=10)
            $arr[$i] = $i.' %';
        return $arr;
    }

    public function getShortInfo()
    {
        $str = '<b>' . $this->project->title . '</b>: ' . Html::a($this->subject, ['/issue/view', 'id' => $this->id]);

        if (in_array($this->status_id, StatusEnum::getOpenStatuses())) {
            if ($this->commentsCount) {
                $str .= ' <sup class="text-muted">' . $this->commentsCount . '<i class="fa fa-comments" title="Комментарии"></i></sup>';
            }
            if ($this->assignee_id == \Yii::$app->user->id) {
                $str .= ' <sup><i class="fa fa-get-pocket text-success" title="назначена мне"></i></sup>';
            }
            $str .= '<span class="pull-right text-muted text-sm">' . $this->created_date . '</span>';
        }

        if ($this->status_id == StatusEnum::IN_WORK) {
            $str .= ' <i class="text-muted">(' . $this->assignee->getFullName() . ')</i>';
        }

        return $str;
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->old_status_id = $this->status_id;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($this->old_status_id != $this->status_id) {
            Log::add(Log::MODEL_ISSUE, $this->getPrimaryKey(), $this->status_id);
        }
    }

}