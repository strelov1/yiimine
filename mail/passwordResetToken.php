<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $user app\models\User */
$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['user/reset-password', 'token' => $user->password_reset_token]);
?>

    <?= \Yii::t('app', 'Hello') .' '. Html::encode($user->username); ?>,

    <?= \Yii::t('app', 'Follow the link below to reset your password:'); ?>

    <?= Html::a(Html::encode($resetLink), $resetLink) ?>