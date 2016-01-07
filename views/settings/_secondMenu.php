<?php
use yii\helpers\Url;
?>

<ul class="nav nav-pills m-b-10">
    <li role="presentation" <?= (\Yii::$app->controller->action->id == 'index' ? 'class="active"' : ''); ?>>
        <a href="<?= Url::toRoute(['/settings/index', 'id' => $project->id]);?>">
            <?= \Yii::t('app', 'Project'); ?>
        </a>
    </li>
    <li role="presentation" <?= (\Yii::$app->controller->action->id == 'members' ? 'class="active"' : ''); ?>>
        <a href="<?= Url::toRoute(['/settings/members', 'id' => $project->id]);?>"><?= \Yii::t('app', 'Members'); ?></a>
    </li>
</ul>