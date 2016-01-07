<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
?>
<h1><?= $data['h1']; ?></h1>
<p><?= $data['message']; ?></p>
<p><?= Html::a($data['link'], $data['link']); ?></p>