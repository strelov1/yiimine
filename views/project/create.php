<?php
/**
 * @var $model app\models\Project
 * @var $this yii\web\View
 */
use yii\helpers\Html;

$this->title = \Yii::t('app', 'New Project') . ' - ' . $this->params['appSettings']['app_name'];
?>

<h1><?= \Yii::t('app', 'New Project') ?></h1>

<?= $this->render('_form', [
    'model' => $model,
]); ?>