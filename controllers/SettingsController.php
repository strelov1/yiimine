<?php
namespace app\controllers;
use app\components\CommonController;
use app\models\ProjectMember;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\web\ForbiddenHttpException;

class SettingsController extends CommonController
{

    public function actionIndex($id)
    {
        $project = $this->loadModel('app\models\Project', $id);
        $this->view->params['appSettings'] = ['app_name' => $project->title];

        if (!\Yii::$app->user->can('viewProject', ['project' => $project]) || \Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Access denied');
        }

        if ($project->load(\Yii::$app->request->post()) && $project->save()) {
            return $this->refresh();
        }

        return $this->render('index', ['project' => $project]);
    }

    public function actionMembers($id)
    {
        $project = $this->loadModel('app\models\Project', $id);
        $this->view->params['appSettings'] = ['app_name' => $project->title];

        if (!\Yii::$app->user->can('viewProject', ['project' => $project]) || \Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Access denied');
        }

        if (\Yii::$app->request->isPost && \Yii::$app->request->post('userId')) {
            foreach (\Yii::$app->request->post('userId') as $userId => $v) {
                $model = new ProjectMember();
                $model->user_id = $userId;
                $model->project_id = $project->id;
                $model->roles = serialize(array_keys(\Yii::$app->request->post('roleId')));
                $model->save();
            }
        }

        $dataProvider = new ActiveDataProvider([
            'query' => ProjectMember::find()->andWhere([
                'project_id' => $project->id,
            ]),
        ]);

        $users = User::find()
            ->where(['NOT IN', 'id', ArrayHelper::getColumn($dataProvider->getModels(), 'user_id')])
            ->andWhere(['status_id' => User::STATUS_ACTIVE])
            ->all();

        return $this->render('members', [
            'dataProvider' => $dataProvider,
            'project' => $project,
            'users' => $users,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->loadModel('app\models\ProjectMember', $id);

        if (!\Yii::$app->user->can('viewProject', ['project' => $model->project]) || \Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Access denied');
        }

        $model->delete();
        return $this->redirect(['/settings/members', 'id' => $model->project_id]);
    }
}