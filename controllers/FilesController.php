<?php
namespace app\controllers;
use app\components\CommonController;
use app\models\Files;
use app\models\search\FilesSearch;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;

class FilesController extends CommonController
{

    public function actionIndex($id, $tagId = null)
    {
        $project = $this->loadModel('app\models\Project', $id);
        $this->view->params['appSettings'] = ['app_name' => $project->title];

        if (!\Yii::$app->user->can('viewProject', ['project' => $project])) {
            throw new ForbiddenHttpException('Access denied');
        }

        $model = new Files();

        if (($files = UploadedFile::getInstances($model, 'file')) && !\Yii::$app->user->isGuest) {
            foreach ($files as $file) {
                $model = new Files();
                $model->file = $file->name;
                $model->project_id = $project->id;
                $model->tags = $_POST['Files']['tags'];
                if ($model->save()) {
                    $file->saveAs($this->_getFolder($model) . $file->name);
                } else {
                    die(var_dump($file->getErrors()));
                }
            }
        }

        $searchModel = new FilesSearch();
        $searchModel->project_id = (int)$project->id;
        if (isset($tagId)) {
            $searchModel->tagId = $tagId;
        }
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        $model->tags = null;

        return $this->render('index', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'project' => $project,
            'tagId' => $tagId,
        ]);
    }

    protected function _getFolder($model)
    {
        $folder = \Yii::getAlias('@webroot') . '/uploads/files/' . $model->getPrimaryKey() . '/';
        if (is_dir($folder) == false)
            mkdir($folder, 0755, true);
        return $folder;
    }

    public function actionDelete($id)
    {
        $model = $this->loadModel('app\models\Files', $id);

        if (!\Yii::$app->user->can('viewProject', ['project' => $model->project]) || \Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Access denied');
        }

        $model->delete();
        return $this->redirect(['index', 'id' => $model->project_id]);
    }
}