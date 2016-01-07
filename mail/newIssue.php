<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model app\models\Issue */
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/issue/view', 'id' => $model->id]);
?>

<?= \Yii::t('app', 'New Issue') .': '. $model->subject; ?>,

<?= \Yii::t('app', 'Follow the link below to view it:'); ?>

<?= Html::a(Html::encode($resetLink), $resetLink) ?>