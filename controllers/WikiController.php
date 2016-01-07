<?php
namespace app\controllers;
use app\components\CommonController;
use app\models\search\WikiSearch;
use app\models\Wiki;
use yii\web\ForbiddenHttpException;

class WikiController extends CommonController
{

    public function actionIndex($id, $tagId = null)
    {
        $project = $this->loadModel('app\models\Project', $id);
        $this->view->params['appSettings'] = ['app_name' => $project->title];

        if (!\Yii::$app->user->can('viewProject', ['project' => $project])) {
            throw new ForbiddenHttpException('Access denied');
        }

        $searchModel = new WikiSearch();
        $searchModel->project_id = (int)$project->id;
        if (isset($tagId)) {
            $searchModel->tagId = $tagId;
        }
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'project' => $project,
            'tagId' => $tagId,
        ]);
    }

    public function actionCreate($id)
    {
        $project = $this->loadModel('app\models\Project', $id);
        $this->view->params['appSettings'] = ['app_name' => $project->title];

        if (!\Yii::$app->user->can('viewProject', ['project' => $project]) || \Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Access denied');
        }

        $model = new Wiki();
        $model->project_id = $project->id;

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', \Yii::t('app', 'New page successfully created.'));
            $this->redirect(['/wiki/index', 'id' => $project->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'project' => $project,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->loadModel('app\models\Wiki', $id);
        if (!\Yii::$app->user->can('viewProject', ['project' => $model->project])) {
            throw new ForbiddenHttpException('Access denied');
        }

        return $this->render('view', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel('app\models\Wiki', $id);

        if (!\Yii::$app->user->can('viewProject', ['project' => $model->project]) || \Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Access denied');
        }

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', \Yii::t('app', 'Page successfully updated.'));
            $this->redirect(['/wiki/index', 'id' => $model->project->id]);
        }
        $model->getTagIds();
        return $this->render('update', ['model' => $model]);
    }

    public function actionDelete($id)
    {
        $model = $this->loadModel('app\models\Wiki', $id);

        if (!\Yii::$app->user->can('viewProject', ['project' => $model->project]) || \Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Access denied');
        }

        $model->delete();
        return $this->redirect(['index', 'id' => $model->project_id]);
    }
}