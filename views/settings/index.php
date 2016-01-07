<?php
/**
 * @var $project app\models\Project;
 */
$this->title = \Yii::t('app', 'Project Settings') . ' - ' . $this->params['appSettings']['app_name'];

echo $this->render('/project/_topMenu', ['model' => $project]);
echo $this->render('_secondMenu', ['project' => $project]);
echo $this->render('/project/_form', ['model' => $project]);




