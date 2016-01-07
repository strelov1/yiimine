<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "log".
 *
 * @property integer $id
 * @property string $model
 * @property integer $model_id
 * @property integer $status_id
 * @property integer $user_id
 * @property string $ts
 */
class Log extends \yii\db\ActiveRecord
{
    const MODEL_ISSUE = 'Issue';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'status_id', 'user_id'], 'integer'],
            [['ts'], 'safe'],
            [['model'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'model' => Yii::t('app', 'Model'),
            'model_id' => Yii::t('app', 'Model ID'),
            'status_id' => Yii::t('app', 'Status ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'ts' => Yii::t('app', 'Ts'),
        ];
    }

    public static function add($model, $model_id, $status_id)
    {
        $m = new self;
        $m->model = $model;
        $m->model_id = $model_id;
        $m->status_id = $status_id;
        $m->user_id = \Yii::$app->user->id;
        if (!$m->save()) {
            die(var_dump($m->getErrors()));
        }
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}