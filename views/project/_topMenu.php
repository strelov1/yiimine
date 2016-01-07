<?php
/**
 * @var $model app\models\Project;
 */

use yii\helpers\Url;
?>

<ul class="nav nav-tabs m-b-10">
    <li <?= ((\Yii::$app->controller->action->id == 'view' && \Yii::$app->controller->id == 'project') ? 'class="active"' : ''); ?>>
        <a href="<?= Url::toRoute(['/project/view', 'id' => $model->id]); ?>">
            <?= \Yii::t('app', 'Overview'); ?>
        </a>
    </li>
    <!--<li <?/*= (\Yii::$app->controller->action->id == 'activity' ? 'class="active"' : ''); */?>>
        <a href="<?/*= Url::toRoute(['/project/activity', 'id' => $model->id]); */?>">
            <?/*= \Yii::t('app', 'Activity'); */?>
        </a>
    </li>-->
    <li <?= ((\Yii::$app->controller->id == 'milestone') ? 'class="active"' : ''); ?>>
        <a href="<?= Url::toRoute(['/milestone/index', 'id' => $model->id]); ?>">
            <?= \Yii::t('app', 'Milestones'); ?>
        </a>
    </li>
    <li <?= ((\Yii::$app->controller->id == 'issue' && \Yii::$app->controller->action->id != 'create') ? 'class="active"' : ''); ?>>
        <a href="<?= Url::toRoute(['/issue/index', 'id' => $model->id]); ?>">
            <?= \Yii::t('app', 'Issues'); ?>
        </a>
    </li>
    <li <?= ((\Yii::$app->controller->id == 'issue' && \Yii::$app->controller->action->id == 'create') ? 'class="active"' : ''); ?>>
        <a href="<?= Url::toRoute(['/issue/create', 'id' => $model->id]); ?>">
            <?= \Yii::t('app', 'New Issue'); ?>
        </a>
    </li>
    <li <?= (\Yii::$app->controller->id == 'wiki' ? 'class="active"' : ''); ?>>
        <a href="<?= Url::toRoute(['/wiki/index', 'id' => $model->id]); ?>">
            <?= \Yii::t('app', 'Wiki'); ?>
        </a>
    </li>
    <li <?= (\Yii::$app->controller->id == 'files' ? 'class="active"' : ''); ?>>
        <a href="<?= Url::toRoute(['/files/index', 'id' => $model->id]); ?>">
            <?= \Yii::t('app', 'Files'); ?>
        </a>
    </li>
    <li <?= (\Yii::$app->controller->id == 'settings' ? 'class="active"' : ''); ?>>
        <a href="<?= Url::toRoute(['/settings/index', 'id' => $model->id]); ?>">
            <?= \Yii::t('app', 'Settings'); ?>
        </a>
    </li>
</ul>