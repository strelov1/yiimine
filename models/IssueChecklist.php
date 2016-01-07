<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "issue_checklist".
 *
 * @property integer $id
 * @property integer $issue_id
 * @property string $item
 * @property integer $status_id
 * @property string $created_date
 * @property string $updated_date
 *
 * @property Issue $issue
 */
class IssueChecklist extends \yii\db\ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_DONE = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'issue_checklist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['issue_id', 'item'], 'required'],
            [['issue_id', 'status_id'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['item'], 'string', 'max' => 255]
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
            'item' => Yii::t('app', 'Item'),
            'status_id' => Yii::t('app', 'Status ID'),
            'created_date' => Yii::t('app', 'Created Date'),
            'updated_date' => Yii::t('app', 'Updated Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIssue()
    {
        return $this->hasOne(Issue::className(), ['id' => 'issue_id']);
    }

    public static function toggleStatus($id)
    {
        \Yii::$app->db->createCommand('UPDATE issue_checklist SET status_id = IF(status_id=1, 0, 1) WHERE id=:id', [':id' => (int)$id])->execute();
    }
}