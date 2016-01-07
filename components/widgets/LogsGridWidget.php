<?php
namespace app\components\widgets;
use yii\base\Widget;
use yii\data\ActiveDataProvider;
use app\models\Log;

class LogsGridWidget extends Widget
{
    public $model;
    public $model_id;

    public function run() {
        $dataProvider = new ActiveDataProvider([
            'query' => Log::find()->where(['model' => $this->model, 'model_id' => $this->model_id])->orderBy('id DESC'),
        ]);

        return $this->render('logsGridWidget', [
            'dataProvider' => $dataProvider,
        ]);
    }
} 