<?php
$this->title = \yii\helpers\Html::encode($model->title).' - '.\Yii::t('app', 'Wiki').' - '.$model->project->title.' - '.$this->params['appSettings']['app_name'];
echo $this->render('/project/_topMenu', ['model' => $model->project]);
?>
    <h1><?= \yii\helpers\Html::encode($model->title); ?></h1>
<?= \yii\helpers\HtmlPurifier::process($model->text); ?>