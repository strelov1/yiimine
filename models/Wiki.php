<?php

namespace app\models;

use app\components\helpers\CommonHelper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "wiki".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $user_id
 * @property string $title
 * @property string $text
 * @property string $created_date
 * @property string $updated_date
 *
 * @property User $user
 * @property Project $project
 */
class Wiki extends \yii\db\ActiveRecord
{
    public $tags;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wiki';
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
            [['project_id', 'title', 'text'], 'required'],
            [['project_id', 'user_id'], 'integer'],
            [['text'], 'string'],
            [['created_date', 'updated_date', 'tags'], 'safe'],
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
            'project_id' => Yii::t('app', 'Project ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'title' => Yii::t('app', 'Title'),
            'text' => Yii::t('app', 'Text'),
            'tags' => Yii::t('app', 'Tags'),
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

    public function getTagModel()
    {
        return $this->hasMany(TagModel::className(), ['model_id' => 'id'])->andWhere(['model_name' => TagModel::MODEL_WIKI]);
    }

    public function getTagIds()
    {
        $this->tags = Yii::$app->db->createCommand('SELECT tag_id FROM tag_model WHERE model_name=:mName AND model_id=:mId', [
            ':mName' => TagModel::MODEL_WIKI,
            ':mId' => $this->getPrimaryKey(),
        ])->queryColumn();
    }


    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        CommonHelper::saveTags($this->tags, $this->getPrimaryKey(), TagModel::MODEL_WIKI, $this->project_id);
    }

    public function getLinkTags()
    {
        $tagArr = [];
        foreach ($this->tagModel as $tm) {
            $tagArr[] = $tm->tag->name;
        }

        return $tagArr;
    }

    public function afterDelete()
    {
        parent::afterDelete();
        Yii::$app->db->createCommand('DELETE FROM tag_model WHERE model_name=:mName AND model_id=:mId', [
            ':mName' => TagModel::MODEL_WIKI,
            ':mId' => $this->getPrimaryKey(),
        ])->execute();
    }
}