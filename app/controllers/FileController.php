<?php

class FileController extends CommonController
{
    public function actionIndex()
    {
        $model = Project::model()->findByPk(User::getLastProjectId());
        $this->pageTitle = 'Все файлы проекта ' . $model->title . ' - ' . Yii::app()->name;

        $this->render('index', array(
            'model' => $this->listing('File', array('project_id' => User::getLastProjectId())),
        ));
    }

    public function actionCreate()
    {
        $project = $this->loadModel('Project', User::getLastProjectId());
        $model = new File();

        $this->pageTitle = 'Добавить файл в ' . $project->title . ' - ' . Yii::app()->name;

        if (isset($_POST['File'])) {
            $model->attributes = $_POST['File'];
            if ($model->save()) {
                user()->setFlash('success', "Файл добавлен");
                $this->redirect(array('index'));
            }
        }

        $this->render('create', array('model' => $model, 'project' => $project));
    }

    public function actionDelete($id)
    {
        if(File::model()->deleteByPk($id)) {
            echo "Ajax Success";
            Yii::app()->end();
        }
    }
} 