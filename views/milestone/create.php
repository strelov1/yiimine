<?php
$this->title = \Yii::t('app', 'Add').' - '.\Yii::t('app', 'Milestones').' - '.$project->title.' - '.$this->params['appSettings']['app_name'];
echo $this->render('/project/_topMenu', ['model' => $project]);
?>
<h1><?= \Yii::t('app', 'New Milestone'); ?></h1>
<?= $this->render('_form', ['model' => $model]); ?>