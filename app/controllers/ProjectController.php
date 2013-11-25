<?php
class ProjectController extends CommonController {
    public function actionIndex() {
        $this->render('index', array(
            'model' => $this->listing('Project'),
        ));
    }

    public function actionCreate() {
        $model = new Project();
        $this->_saveModel($model, 'создан');
        $this->render('create', array('model' => $model));
    }

    public function actionUpdate($id) {
        $model = $this->loadModel('Project', $id);
        $this->_saveModel($model, 'обновлен');
        $this->render('update', array('model' => $model));
    }

    public function actionDelete($id) {
        $this->delete('Project', $id);
    }

    public function actionView($url) {
        $model = Project::model()->findByAttributes(array('identifier' => $url));
        if(!$model)
            throw new CHttpException(404, 'Такой страницы не существует');

        User::setLastProjectId($model->id);

        $this->render('view', array('model' => $model));
    }

    /**
     * @param $model
     */
    private function _saveModel($model, $actionText) {
        if (isset($_POST['Project'])) {
            $model->attributes = $_POST['Project'];
            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Проект {$model->title} успешно {$actionText}");
                $this->redirect(array('index'));
            }
        }
    }
}