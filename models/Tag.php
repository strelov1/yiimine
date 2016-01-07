<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $name
 * @property integer $project_id
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    private static $tagOptions = [];
    public static function getOptions($projectId)
    {
        if (empty(self::$tagOptions[$projectId])) {
            self::$tagOptions[$projectId] = ArrayHelper::map(self::find()->where(['project_id' => $projectId])->all(), 'id', 'name');
        }

        return self::$tagOptions[$projectId];
    }

    public static function getIdByName($name, $projectId)
    {
        $id = Yii::$app->db->createCommand('SELECT id FROM tag WHERE name=:name AND project_id=:pId', [
            ':name' => $name,
            ':pId' => $projectId,
        ])->queryScalar();

        if (!$id) {
            $tag = new self();
            $tag->name = $name;
            $tag->project_id = $projectId;
            $tag->save();
            $id = $tag->getPrimaryKey();
        }

        return $id;
    }

}