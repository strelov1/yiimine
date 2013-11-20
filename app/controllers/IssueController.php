<?php
class IssueController extends CommonController {
    public function actionIndex() {
        $this->render('index', array(
            'model' => $this->listing('Issue', array('project_id' => user()->getState('projectId'))),
        ));
    }

    public function actionCreate() {
        $project = $this->loadModel('Project', user()->getState('projectId'));
        $model = new Issue();
        $model->project_id = $project->id;
        $model->tracker_id = Issue::TRACKER_BUG;

        if(isset($_POST['Issue'])) {
            $model->attributes = $_POST['Issue'];
            if($model->save()) {
                user()->setFlash('success', "Задача #{$model->id} добавлена");
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array('model' => $model, 'project' => $project));
    }
}