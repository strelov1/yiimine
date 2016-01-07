<?php
namespace app\controllers;
use app\components\CommonController;
use app\models\Note;
use yii\data\ActiveDataProvider;

class NoteController extends CommonController
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Note::find()->where(['user_id' => \Yii::$app->user->id])->orderBy('id DESC'),
        ]);

        $model = new Note();

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->refresh();
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->loadModel('app\models\Note', $id);
        if ($model->user_id == \Yii::$app->user->id) {
            $model->delete();
        }
        return $this->redirect(['/note/index']);
    }
} 