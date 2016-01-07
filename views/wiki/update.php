<?php
use yii\helpers\Html;

$this->title = \Yii::t('app', 'Edit').': '.Html::encode($model->title).' - '.\Yii::t('app', 'Wiki').' - '.$model->project->title.' - '.$this->params['appSettings']['app_name'];
echo $this->render('/project/_topMenu', ['model' => $model->project]);
?>
    <h1><?= \Yii::t('app', 'Edit').': '.Html::encode($model->title); ?></h1>
<?= $this->render('_form', ['model' => $model, 'project' => $model->project]); ?>