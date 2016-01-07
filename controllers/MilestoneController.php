<?php
namespace app\controllers;

use app\components\CommonController;
use app\models\search\MilestoneSearch;
use app\models\Milestone;
use yii\web\ForbiddenHttpException;

class MilestoneController extends CommonController
{

    public function actionIndex($id)
    {
        $project = $this->loadModel('app\models\Project', $id);
        $this->view->params['appSettings'] = ['app_name' => $project->title];

        if (!\Yii::$app->user->can('viewProject', ['project' => $project])) {
            throw new ForbiddenHttpException('Access denied');
        }

        $searchModel = new MilestoneSearch();
        $searchModel->project_id = (int)$project->id;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'project' => $project,
        ]);
    }

    public function actionCreate($id)
    {
        $project = $this->loadModel('app\models\Project', $id);
        $this->view->params['appSettings'] = ['app_name' => $project->title];

        if (!\Yii::$app->user->can('viewProject', ['project' => $project]) || \Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Access denied');
        }

        $model = new Milestone();
        $model->project_id = $project->id;

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', \Yii::t('app', 'New milestone successfully created.'));
            $this->redirect(['/milestone/index', 'id' => $project->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'project' => $project,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel('app\models\Milestone', $id);

        if (!\Yii::$app->user->can('viewProject', ['project' => $model->project]) || \Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Access denied');
        }

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', \Yii::t('app', 'Milestone successfully updated.'));
            $this->redirect(['/milestone/index', 'id' => $model->project->id]);
        }
        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = $this->loadModel('app\models\Milestone', $id);

        if (!\Yii::$app->user->can('viewProject', ['project' => $model->project]) || \Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Access denied');
        }

        $model->delete();
        return $this->redirect(['index', 'id' => $model->project_id]);
    }
}