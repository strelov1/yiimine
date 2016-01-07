<?php

namespace app\models;

use app\components\enums\StatusEnum;
use app\components\enums\TrackerEnum;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "project".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $is_public
 * @property integer $status_id
 * @property integer $creator_id
 * @property string $created_date
 * @property string $updated_date
 *
 * @property User $creator
 */
class Project extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
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
            [['title'], 'required'],
            [['is_public', 'status_id', 'creator_id'], 'integer'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => \Yii::t('app', 'Title'),
            'description' => \Yii::t('app', 'Description'),
            'is_public' => \Yii::t('app', 'Public'),
            'status_id' => \Yii::t('app', 'Status'),
            'creator_id' => \Yii::t('app', 'Creator'),
            'created_date' => \Yii::t('app', 'Created Date'),
            'updated_date' => \Yii::t('app', 'Updated Date'),
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
    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'creator_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssues()
    {
        return $this->hasMany(Issue::className(), ['project_id' => 'id']);
    }

    public function getIssuesToUser()
    {
        return $this->hasMany(Issue::className(), ['project_id' => 'id'])
            ->andWhere(['issue.assignee_id' => \Yii::$app->user->id])
            ->orderBy('id DESC');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMembers()
    {
        return $this->hasMany(ProjectMember::className(), ['project_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpenBugs()
    {
        return $this->hasMany(Issue::className(), ['project_id' => 'id'])
            ->where('tracker_id=:bug AND status_id<:closed', [':bug' => TrackerEnum::BUG, ':closed' => StatusEnum::CLOSED])
            ->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClosedBugs()
    {
        return $this->hasMany(Issue::className(), ['project_id' => 'id'])
            ->where('tracker_id=:bug AND status_id=:closed', [':bug' => TrackerEnum::BUG, ':closed' => StatusEnum::CLOSED])
            ->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOpenTasks()
    {
        return $this->hasMany(Issue::className(), ['project_id' => 'id'])
            ->where('tracker_id=:task AND status_id<:closed', [':task' => TrackerEnum::TASK, ':closed' => StatusEnum::CLOSED])
            ->count();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClosedTasks()
    {
        return $this->hasMany(Issue::className(), ['project_id' => 'id'])
            ->where('tracker_id=:task AND status_id=:closed', [':task' => TrackerEnum::TASK, ':closed' => StatusEnum::CLOSED])
            ->count();
    }

    public static function getAssigneeOptions($projId)
    {
        $q = 'SELECT project_member.user_id AS id, CONCAT(user.first_name, " ", user.last_name) AS name FROM project_member
            JOIN user ON project_member.user_id=user.id
            WHERE project_member.project_id=:projId';
        return ArrayHelper::map(\Yii::$app->db->createCommand($q, [':projId' => $projId])->queryAll(), 'id', 'name');
    }

    public static function getMyProjects()
    {
        $q = 'SELECT project_id FROM project_member WHERE user_id=:userId GROUP BY project_id';
        return \Yii::$app->db->createCommand($q, [':userId' => \Yii::$app->user->id])->queryColumn();
    }

    public function getMilestones()
    {
        return $this->hasMany(Milestone::className(), ['project_id' => 'id'])->orderBy('id DESC');
    }

    public static function getOptions()
    {
        return ArrayHelper::map(self::find()->all(), 'id', 'title');
    }
}