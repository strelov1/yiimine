<?php
/**
 * @var $model app\models\Project
 */
use yii\helpers\Html;
?>
<div class='row'>
    <div class="col-sm-9">
        <?= Html::a(Html::encode($model->title), ['/project/view', 'id' => $model->id]); ?>
        <br/>
        <?= \yii\helpers\HtmlPurifier::process($model->description); ?>
    </div>
    <div class="col-sm-3 text-right">
        <?php
        if ($model->is_public) {
            echo '<span class="label label-info">'.\Yii::t('app', 'Public').'</span>';
        } else {
            echo '<span class="label label-danger">'.\Yii::t('app', 'Private').'</span>';
        }
        ?>
        <br/>
        <p><?= \Yii::t('app', 'Start Date') . ': ' . Yii::$app->formatter->asDate($model->created_date); ?></p>
    </div>
</div>
<hr/>