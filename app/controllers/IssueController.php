<?php

class IssueController extends CommonController
{
    public function actionIndex()
    {
        $this->render('index', array(
                'model' => $this->listing('Issue', array('project_id' => User::getLastProjectId())),
            )
        );
    }

    public function actionCreate()
    {
        $project = $this->loadModel('Project', User::getLastProjectId());
        $model = new Issue();
        $model->project_id = $project->id;
        $model->tracker_id = Issue::TRACKER_BUG;

        $this->_saveModel($model, 'добавлена');

        $this->render('create', array('model' => $model, 'project' => $project));
    }

    public function actionUpdate($id)
    {
        $project = $this->loadModel('Project', User::getLastProjectId());
        $model = $this->loadModel('Issue', $id);

        $this->_saveModel($model, 'обновлена');

        $this->render('update', array('model' => $model, 'project' => $project));
    }

    public function actionDelete($id)
    {
        $this->delete('Issue', $id);
    }

    public function actionView($id)
    {
        $model = $this->loadModel('Issue', $id);

        $comments = new CActiveDataProvider('IssueComment', array(
            'criteria'   => array(
                'condition' => 'issue_id = ' . (int)$id,
            ),
            'sort'       => array(
                'defaultOrder' => 'created_date DESC',
            ),
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));

        $this->render('view', array('model' => $model, 'comments' => $comments));
    }

    public function actionClose($id)
    {
        $issue = $this->loadModel('Issue', (int)$id);

        $comment = new IssueComment();
        $comment->issue_id = (int)$id;

        if (isset($_POST['IssueComment'])) {
            $issue->status_id = Issue::STATUS_CLOSED;
            $issue->update(array('status_id'));

            $comment->attributes = $_POST['IssueComment'];
            $comment->save();

            user()->setFlash('success', 'Задача закрыта - ' . $issue->subject);
            Yii::app()->end();
        }

        $this->renderPartial('close', array('model' => $comment, 'issue' => $issue));
    }

    private function _saveModel($model, $actionText)
    {
        if (isset($_POST['Issue'])) {
            $model->attributes = $_POST['Issue'];
            if ($model->save()) {
                $this->_saveFiles($model);
                user()->setFlash('success', "Задача #{$model->id} {$actionText}");
                $this->redirect(array('index'));
            }
        }
    }

    private function _saveFiles(Issue $model)
    {
        $files = CUploadedFile::getInstances($model, 'tmpFiles');
        if (isset($files) && count($files) > 0) {
            foreach ($files as $k => $file) {
                $ext = pathinfo($file->name, PATHINFO_EXTENSION);
                $filename = md5(rand(1000,4000)) . '.' . $ext;
                if ($file->saveAs($model->getFileFolder() . $filename)) {
                    Yii::app()->image->load($model->getFileFolder() . $filename)->
                        resize(300, 300, Image::WIDTH)->quality(80)->crop(300, 300)->
                        save($model->getFileFolder() . '/thumb_' . $filename);

                    $image = new IssueFile();
                    $image->issue_id = $model->getPrimaryKey();
                    $image->filename = $filename;
                    $image->save();
                }
            }
        }
    }

    public function actionChangeStatus($issueId)
    {
        $issue = $this->loadModel('Issue', (int)$issueId);

        $comment = new IssueComment();
        $comment->issue_id = (int)$issueId;

        if (isset($_POST['IssueComment'])) {
            $issue->status_id = (int)$_POST['Issue']['status_id'];
            $issue->update(array('status_id'));

            $comment->attributes = $_POST['IssueComment'];
            $comment->save();

            user()->setFlash('success', 'Статус задачи #' . $issue->id . ' изменен');
            Yii::app()->end();
        }

        $this->renderPartial('changeStatus', array('comment' => $comment, 'issue' => $issue));
    }

    public function actionChangeDoneRatio($issueId)
    {
        $issue = $this->loadModel('Issue', (int)$issueId);

        if (isset($_POST['Issue'])) {
            $issue->done_ratio = (int)$_POST['Issue']['done_ratio'];
            $issue->update(array('done_ratio'));

            user()->setFlash('success', 'Готовность задачи #' . $issue->id . ' изменена');
            Yii::app()->end();
        }

        $this->renderPartial('changeDoneRatio', array('issue' => $issue));
    }

    public function actionDeleteFile($id)
    {
        if(IssueFile::model()->deleteByPk($id)) {
            echo "Ajax Success";
            Yii::app()->end();
        }
    }
}