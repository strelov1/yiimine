<?php
/**
 * @var $this yii\web\View
 */

use app\components\enums\TrackerEnum;
use app\models\User;
use yii\helpers\Html;

$this->title = \Yii::t('app', 'Overview').' - '.$this->params['appSettings']['app_name'];

echo $this->render('_topMenu', ['model' => $model]);
?>

<div class="row">
    <div class="col-sm-6">
        <h1><?= \Yii::t('app', 'Overview'); ?></h1>
        <?= \yii\helpers\HtmlPurifier::process($model->description); ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-list text-success"></i> <?= \Yii::t('app', 'Milestones'); ?>
                </h3>
            </div>
            <div class="panel-body">
                <table class="table table-condensed">
                    <?php foreach ($model->milestones as $milestone): ?>
                        <tr>
                            <th>
                                <?= Html::encode($milestone->title); ?>
                                <sup class="text-muted "><?= $milestone->daysLeft; ?></sup>
                            </th>
                        </tr>
                        <?php foreach ($milestone->openedIssues as $issue): ?>
                            <tr>
                                <td>
                                    &nbsp;&mdash;&nbsp;<?= Html::a(Html::encode($issue->subject), ['/issue/view', 'id' => $issue->id]); ?>
                                    <?php if ($issue->tracker_id == TrackerEnum::BUG): ?>
                                        <span class="label label-danger pull-right"><?= \Yii::t('app', 'Bug'); ?></span>
                                    <?php else: ?>
                                        <span class="label label-info pull-right"><?= \Yii::t('app', 'Task'); ?></span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-inbox text-primary"></i> <?= \Yii::t('app', 'Issues'); ?>
                    <small><?= ' ('.\Yii::t('app', 'Open').' / '.\Yii::t('app', 'Closed').')'; ?></small>
                </h3>
            </div>
            <div class="panel-body">
                <dl class="dl-horizontal">
                    <dt><?= \Yii::t('app', 'Bugs'); ?></dt>
                    <dd><?= $model->openBugs; ?> / <?= $model->closedBugs; ?></dd>
                    <dt><?= \Yii::t('app', 'Tasks'); ?></dt>
                    <dd><?= $model->openTasks; ?> / <?= $model->closedTasks; ?></dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-code text-success"></i> <?= \Yii::t('app', 'Assigned To Me'); ?>
                </h3>
            </div>
            <div class="panel-body">
                <table class="table table-condensed">
                    <tr>
                        <th><?= \Yii::t('app', 'Issue'); ?></th>
                        <th><?= \Yii::t('app', 'Deadline'); ?></th>
                    </tr>
                    <?php foreach ($model->issuesToUser as $issue): ?>
                        <tr>
                            <td><?= Html::a(Html::encode($issue->subject), ['/issue/view', 'id' => $issue->id]); ?></td>
                            <td><?= Html::encode($issue->deadline); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-users text-info"></i> <?= \Yii::t('app', 'Members'); ?></h3>
            </div>
            <div class="panel-body">
                <dl class="dl-horizontal">
                    <?php foreach ($model->members as $member): ?>
                        <dt><?= $member->user->getFullName(); ?></dt>
                        <?php
                        $roles = [];
                        if ($member->roles) {
                            foreach ($member->roles as $k => $v) {
                                $roles[] = User::getProjectRoleArray()[$v];
                            }
                        }
                        ?>
                        <dd><?= implode(', ', $roles); ?></dd>
                    <?php endforeach; ?>
                </dl>
            </div>
        </div>
    </div>
</div>