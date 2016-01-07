<?php
$this->title = \Yii::t('app', 'Add').' - '.\Yii::t('app', 'Wiki').' - '.$project->title.' - '.$this->params['appSettings']['app_name'];
echo $this->render('/project/_topMenu', ['model' => $project]);
?>
<h1><?= \Yii::t('app', 'New Page'); ?></h1>
<?= $this->render('_form', ['model' => $model, 'project' => $project]); ?>