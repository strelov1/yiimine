<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "project_member".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $user_id
 * @property string $roles
 */
class ProjectMember extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'user_id'], 'required'],
            [['project_id', 'user_id'], 'integer'],
            [['roles'], 'string']
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
            'user_id' => Yii::t('app', 'User'),
            'roles' => Yii::t('app', 'Roles'),
        ];
    }

    public function afterFind()
    {
        parent::afterFind();
        $this->roles = unserialize($this->roles);
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
}