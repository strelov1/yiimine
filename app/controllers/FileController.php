<?php

class FileController extends CommonController
{
    public function actionIndex()
    {
        $this->render('index', array(
            'model' => $this->listing('File', array('project_id' => User::getLastProjectId())),
        ));
    }

    public function actionCreate()
    {
        $project = $this->loadModel('Project', User::getLastProjectId());
        $model = new File();

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