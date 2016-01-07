<?php
namespace app\controllers;
use app\components\CommonController;
use app\components\enums\PriorityEnum;
use app\components\enums\StatusEnum;
use app\components\enums\TrackerEnum;
use app\models\Issue;
use app\models\IssueChecklist;
use app\models\IssueComment;
use app\models\Project;
use app\models\search\IssueSearch;
use app\models\User;
use yii\helpers\Json;
use yii\web\ForbiddenHttpException;

class IssueController extends CommonController
{

    public function actionIndex($id)
    {
        $project = $this->loadModel('app\models\Project', $id);
        if (!\Yii::$app->user->can('viewProject', ['project' => $project])) {
            throw new ForbiddenHttpException('Access denied');
        }

        $this->view->params['appSettings'] = ['app_name' => $project->title];

        $searchModel = new IssueSearch();
        $searchModel->project_id = $project->id;
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);

        if (\Yii::$app->request->post('hasEditable') && !\Yii::$app->user->isGuest) {
            $model = Issue::findOne([
                'id' => (int)\Yii::$app->request->post('editableKey')
            ]);
            $out = Json::encode(['output'=>'', 'message'=>'']);
            $post = current(\Yii::$app->request->post('Issue'));

            if (isset($post['status_id'])) {
                $model->status_id = (int) $post['status_id'];
                $output = StatusEnum::i()->getMap()[$post['status_id']];
                $this->sendMessage($model, [
                    'subject' => \Yii::t('app', 'Issue Status Changed'),
                    'view' => 'changeStatus',
                ]);
            }

            if (isset($post['priority_id'])) {
                $model->priority_id = (int) $post['priority_id'];
                $output = PriorityEnum::i()->getMap()[$post['priority_id']];
            }

            if (isset($post['assignee_id'])) {
                if ($post['assignee_id']) {
                    $model->assignee_id = (int) $post['assignee_id'];
                    $output = \app\models\Project::getAssigneeOptions($project->id)[$post['assignee_id']];
                    $this->sendMessage($model);
                } else {
                    $model->assignee_id = null;
                    $output = '<i>('.\Yii::t('app', 'not set').')</i>';
                }
            }

            if ($model->save()) {
                $out = Json::encode(['output' => $output, 'message' => '']);
            }
            echo $out;
            return;
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'project' => $project,
        ]);
    }

    public function actionView($id)
    {
        $model = $this->loadModel('app\models\Issue', $id);
        $this->view->params['appSettings'] = ['app_name' => $model->project->title];

        if (!\Yii::$app->user->can('viewProject', ['project' => $model->project]) || \Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Access denied');
        }

        if (\Yii::$app->request->post('hasEditable') && !\Yii::$app->user->isGuest) {
            $post = \Yii::$app->request->post('Issue');
            if (isset($post['status_id'])) {
                $model->status_id = $post['status_id'];
                $output = StatusEnum::i()->getMap()[$post['status_id']];
                $this->sendMessage($model, [
                    'subject' => \Yii::t('app', 'Issue Status Changed'),
                    'view' => 'changeStatus',
                ]);
            }

            if (isset($post['priority_id'])) {
                $model->priority_id = (int) $post['priority_id'];
                $output = PriorityEnum::i()->getMap()[$post['priority_id']];
            }

            if (isset($post['tracker_id'])) {
                $model->tracker_id = (int) $post['tracker_id'];
                $output = TrackerEnum::i()->getMap()[$post['tracker_id']];
            }

            if (isset($post['assignee_id'])) {
                if ($post['assignee_id']) {
                    $model->assignee_id = (int) $post['assignee_id'];
                    $output = \app\models\Project::getAssigneeOptions($model->project_id)[$post['assignee_id']];
                    $this->sendMessage($model);
                } else {
                    $model->assignee_id = null;
                    $output = '<i>('.\Yii::t('app', 'not set').')</i>';
                }
            }

            if (isset($post['readiness_id'])) {
                $model->readiness_id = (int) $post['readiness_id'];
                $output = Issue::getReadinessOptions()[$post['readiness_id']];
            }

            if (isset($post['deadline'])) {
                $model->deadline = $post['deadline'];
                $output = $post['deadline'];
            }

            if ($model->save()) {
                $out = Json::encode(['output' => $output, 'message' => '']);
                echo $out;
                return;
            }
        }

        if ($post = \Yii::$app->request->post('IssueComment')) {
            $comment = new IssueComment();
            $comment->text = $post['text'];
            $comment->issue_id = $id;
            if ($comment->save()) {
                \Yii::$app->session->setFlash('success', \Yii::t('app', 'Comment successfully added.'));
            }
        }

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel('app\models\Issue', $id);

        if (!\Yii::$app->user->can('viewProject', ['project' => $model->project]) || \Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Access denied');
        }

        $checklistItems = [];

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            $this->saveChecklist($model);
            return $this->redirect(['/issue/index', 'id' => $model->project_id]);
        }

        if ($model->checkLists) {
            $checklistItems = $model->checkLists;
        }else {
            $checklistItems[] = new IssueChecklist();
        }

        return $this->render('update', [
            'model' => $model,
            'checklistItems' => $checklistItems,
        ]);
    }

    private function saveChecklist($model)
    {
        IssueChecklist::deleteAll(['issue_id' => $model->id]);
        if ($items = \Yii::$app->request->post('IssueChecklist')) {
            foreach ($items as $item) {
                if (!empty($item['item'])) {
                    $chlm = new IssueChecklist();
                    $chlm->issue_id = $model->id;
                    $chlm->item = $item['item'];
                    $chlm->status_id = !empty($item['status_id']) ? isset($item['status_id']) : IssueChecklist::STATUS_NEW;
                    if (!$chlm->save()) {
                        die(var_dump($chlm->getErrors()));
                    }
                }
            }

        }
    }

    public function actionDeleteImage($id)
    {
        if (\Yii::$app->request->isAjax) {
            $this->loadModel('app\models\IssuePhoto', $id)->delete();
        }
        \Yii::$app->end();
    }

    public function actionDeleteComment($id)
    {
        if (\Yii::$app->request->isAjax) {
            $this->loadModel('app\models\IssueComment', $id)->delete();
        }
        \Yii::$app->end();
    }

    public function actionCreate($id)
    {
        $project = $this->loadModel('app\models\Project', $id);
        $this->view->params['appSettings'] = ['app_name' => $project->title];

        if (!\Yii::$app->user->can('viewProject', ['project' => $project]) || \Yii::$app->user->isGuest) {
            throw new ForbiddenHttpException('Access denied');
        }

        $model = new Issue();
        $model->project_id = $project->id;

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            $this->saveChecklist($model);
            $this->sendMessage($model);
            return $this->redirect(['/issue/index', 'id' => $model->project_id]);
        }

        $checklistItems[] = new IssueChecklist();

        return $this->render('create', [
            'model' => $model,
            'project' => $project,
            'checklistItems' => $checklistItems,
        ]);
    }

    public function actionCreateEmpty()
    {
        $model = new Issue();

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            $this->saveChecklist($model);
            $this->sendMessage($model);
            return $this->redirect(['/issue/index', 'id' => $model->project_id]);
        }

        $checklistItems[] = new IssueChecklist();

        return $this->render('createEmpty', [
            'model' => $model,
            'checklistItems' => $checklistItems,
        ]);
    }

    private function sendMessage($model, $params = null) {
        if (!$model->assignee_id) {
            return;
        }

        // TODO: отрефакторить к хренам
        $email = '';

        if (is_null($params)) {
            $params = [
                'subject' => \Yii::t('app', 'New Issue'),
                'view' => 'newIssue'
            ];
        }

        if ($params['view'] == 'changeStatus') {
            if ($model->creator_id != \Yii::$app->user->id && $model->assignee_id != \Yii::$app->user->id) {
                // Если статус поменял пользователь не создатель и не исполнитель
                if ($model->assignee->email) {
                    $email = $model->assignee->email;
                }
            } elseif ($model->assignee_id == \Yii::$app->user->id && $model->assignee_id != $model->creator_id) {
                // Если статус поменял исполнитель, НО не создатель
                if ($model->author->email) {
                    $email = $model->author->email;
                }
            } elseif ($model->creator_id != \Yii::$app->user->id) {
                // Если меняет кто угодно не создатель и не исполнитель
                $email = $model->author->email;
            }
        }

        if ($params['view'] == 'newIssue') {
            $user = User::findOne(['id' => $model->assignee_id]);
            $email = $user->email;
        }

        if ($email) {
            \Yii::$app->mailer->compose($params['view'], ['model' => $model])
                ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
                ->setTo($email)
                ->setSubject($params['subject'])
                ->send();
        }
    }

    public function actionDelete($id)
    {
        if (\Yii::$app->request->isAjax) {
            $this->loadModel('app\models\Issue', $id)->delete();
        }
        \Yii::$app->end();
    }
}