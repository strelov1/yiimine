<?php
namespace app\controllers;

use app\components\CommonController;
use app\models\IssueChecklist;

class ChecklistController extends CommonController
{
    public $enableCsrfValidation = false;

    public function actionItemForm($index)
    {
        $model = new IssueChecklist();

        return $this->renderPartial('/issue/_listItem', [
            'model' => $model,
            'index' => $index,
        ]);
    }

    public function actionToggleStatus()
    {
        $id = \Yii::$app->request->post('id');
        IssueChecklist::toggleStatus($id);
        \Yii::$app->end();
    }
}