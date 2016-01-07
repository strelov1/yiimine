<?php

namespace app\models;

use Yii;
use app\components\helpers\CommonHelper;

/**
 * This is the model class for table "files".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $user_id
 * @property string $file
 * @property string $created_date
 *
 * @property User $user
 * @property Project $project
 */
class Files extends \yii\db\ActiveRecord
{
    public $tags;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'file'], 'required'],
            [['project_id', 'user_id'], 'integer'],
            [['file'], 'string', 'max' => 255],
            [['tags'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'project_id' => Yii::t('app', 'Project ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'file' => Yii::t('app', 'File'),
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
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        CommonHelper::saveTags($this->tags, $this->getPrimaryKey(), TagModel::MODEL_FILES, $this->project_id);
    }

    public function afterDelete()
    {
        parent::afterDelete();
        Yii::$app->db->createCommand('DELETE FROM tag_model WHERE model_name=:mName AND model_id=:mId', [
            ':mName' => TagModel::MODEL_FILES,
            ':mId' => $this->getPrimaryKey(),
        ])->execute();
    }


}