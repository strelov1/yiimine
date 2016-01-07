<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

use kartik\grid\GridView;
use app\components\enums\StatusEnum;
use app\components\enums\PriorityEnum;
use app\models\Project;
use app\models\User;

$this->title = $this->params['appSettings']['app_name'];
?>
<div class="site-index" ng-controller="SiteIndexCtrl" ng-init="setModel()">
    <div class="jumbotron">

        <?php if(Yii::$app->user->isGuest): ?>
            <?= Html::img('/uploads/settings/app_logo/'.$this->params['appSettings']['app_logo'], ['class' => 'img-thumbnail', 'width' => 300]); ?>
            <br/>
            <?= HtmlPurifier::process($this->params['appSettings']['app_description']); ?>
        <?php else: ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'layout' => '{items} {pager}',
                'columns' => [
                    [
                        'attribute' => 'project_id',
                        'filter' => Project::getOptions(),
                        'value' => function ($data) {
                            return $data->project->title;
                        },
                    ], [
                        'attribute' => 'status_id',
                        'filter' => StatusEnum::i()->getMap(),
                        'value' => function ($data) {
                            return StatusEnum::i()->getMap()[$data->status_id];
                        },
                    ], [
                        'attribute' => 'priority_id',
                        'filter' => PriorityEnum::i()->getMap(),
                        'value' => function ($data) {
                            return PriorityEnum::i()->getMap()[$data->priority_id];
                        },
                    ], [
                        'attribute' => 'subject',
                        'format' => 'raw',
                        'value' => function ($data) {
                            $additionalLinks = '';
                            $checkList = '';
                            if ($data->creator_id == \Yii::$app->user->id || \Yii::$app->user->can('adminDashboard')) {
                                $additionalLinks = '<span class="pull-right">'.Html::a('<i class="fa fa-edit"></i>', ['/issue/update', 'id' => $data->id]).' ';
                                $additionalLinks .= Html::a('<i class="fa fa-trash"></i>', ['/issue/delete', 'id' => $data->id], ['class' => 'confirmLink']).'</span>';
                            }
                            if ($data->checkLists) {
                                $checkList = '<span class="label label-success" data-toggle="tooltip" title="'.\Yii::t('app', 'Checklist').'">
                            <i class="fa fa-th-list"></i> '.$data->offListItems.'/'.$data->checkListsCount.'</span>';
                            }
                            return Html::a($data->subject, ['/issue/view', 'id' => $data->id]) . ' ' .$checkList . $additionalLinks;
                        }
                    ], [
                        'attribute' => 'assignee_id',
                        'filter' => User::getOptions(),
                        'value' => function ($data) {
                            return ($data->assignee) ? $data->assignee->getFullName() : '';
                        },
                    ], [
                        'attribute' => 'creator_id',
                        'filter' => User::getOptions(),
                        'value' => function ($data) {
                            return ($data->author) ? $data->author->getFullName() : '';
                        }
                    ], [
                        'attribute' => 'created_date',
                        'filter' => false,
                    ],
                ],
            ]); ?>
        <?php endif; ?>
    </div>
</div>