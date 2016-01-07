<?php
/* @var $this yii\web\View */
/* @var $model app\models\Issue */
$this->title = \Yii::t('app', 'New Issue').' - '.$this->params['appSettings']['app_name'];
echo $this->render('/project/_topMenu', ['model' => $project]);?>
    <h1><?= \Yii::t('app', 'New Issue'); ?></h1>
<?php
echo $this->render('_form', ['model' => $model, 'project' => $project, 'checklistItems' => $checklistItems]);