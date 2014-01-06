<?php
class AddCommentWidget extends CWidget {
    public $issueId;

    public function init() {
        $model = new IssueComment();
        $model->issue_id = $this->issueId;

        if(isset($_POST['IssueComment'])) {
            $model->attributes = $_POST['IssueComment'];
            if($model->save()) {
                Yii::app()->user->setFlash('success', 'Комментарий добавлен');
                $this->controller->redirect(array('/issue/view', 'id' => $this->issueId));
            }
        }

        $this->render('addCommentWidget', array('model' => $model));
    }
} 