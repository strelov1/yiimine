<?php
namespace app\controllers;
use app\components\CommonController;
use app\components\enums\PriorityEnum;
use app\components\enums\ProjectStatusEnum;
use app\components\enums\StatusEnum;
use app\models\Issue;
use app\models\Project;
use app\models\search\IssueSearch;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class ProjectController extends CommonController
{
    private $project;

    public function init()
    {
        parent::init();

        if (\Yii::$app->request->get('id')) {
            $this->project = $this->loadModel('app\models\Project', \Yii::$app->request->get('id'));
            if (!$this->project) {
                throw new NotFoundHttpException('Запрашиваемая страница не найдена');
            }
            $this->view->params['appSettings'] = ['app_name' => $this->project->title];
        }
    }


    public function actionIndex()
    {
        $query = Project::find();
        $query->orderBy('id DESC');
        $query->andWhere([
            'status_id' => ProjectStatusEnum::OPEN,
        ]);

        if (\Yii::$app->user->isGuest) {
            $query->andWhere([
                'is_public' => 1
            ]);
        }

        $status = '';
        if ($status = \Yii::$app->request->get('status')) {
            switch ($status) {
                case 'public':
                    $query->andWhere(['is_public' => 1]);
                    break;
                case 'private':
                    $query->andWhere(['is_public' => 0]);
                    break;
            }
        }

        return $this->render('index', [
            'dataProvider' => new ActiveDataProvider([
                'query' => $query,
            ]),
            'status' => $status,
        ]);
    }

    public function actionCreate()
    {
        if (\Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Access denied');
        }
        $model = new Project();

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/project/view', 'id' => $model->getPrimaryKey()]);
        }

        return $this->render('create', ['model' => $model]);
    }

    public function actionView($id)
    {
        if (!\Yii::$app->user->can('viewProject', ['project' => $this->project])) {
            throw new ForbiddenHttpException('Access denied');
        }

        return $this->render('view', [
            'model' => $this->project,
        ]);
    }
}