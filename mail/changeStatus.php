<?php
use app\components\enums\StatusEnum;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Issue */
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/issue/view', 'id' => $model->id]);
?>

<?= \Yii::t('app', 'Status has been changed in Issue') . ' #' . $model->id . '(' . $model->subject . ') '
. \Yii::t('app', 'to') . ' "' . StatusEnum::i()->getMap()[$model->status_id].'"<br/>'; ?>

<?= Html::a(Html::encode($resetLink), $resetLink) ?>