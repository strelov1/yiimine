<?php
use kartik\editable\Editable;
use kartik\grid\GridView;
use app\components\enums\StatusEnum;
use app\components\enums\PriorityEnum;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\search\IssueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Issues') .' - '. $this->params['appSettings']['app_name'];
echo $this->render('/project/_topMenu', ['model' => $project]);
?>
<div class="issue-index">
    <div class="row">
        <div class="col-sm-6">
            <h1><?= Yii::t('app', 'Issues') ?></h1>
        </div>
        <div class="col-sm-6">
            <?= Html::a('<i class="fa fa-plus"></i> ' . Yii::t('app', 'New Issue'), ['/issue/create', 'id' => $project->id], ['class' => 'btn btn-primary pull-right']); ?>
        </div>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '{items} {pager}',
        'columns' => [
            [
                'class' => 'yii\grid\CheckboxColumn',
                'name' => 'massIssueDelete',
            ],
            'id',
            [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'status_id',
                'filter' => StatusEnum::i()->getMap(),
                'value' => function ($data) {
                    return StatusEnum::i()->getMap()[$data->status_id];
                },
                'editableOptions' => [
                    'header' => \Yii::t('app', 'Status'),
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'data' => StatusEnum::i()->getMap(),
                ],
            ], [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'priority_id',
                'filter' => PriorityEnum::i()->getMap(),
                'value' => function ($data) {
                    return PriorityEnum::i()->getMap()[$data->priority_id];
                },
                'editableOptions' => [
                    'header' => \Yii::t('app', 'Priority'),
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'data' => PriorityEnum::i()->getMap(),
                ],
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
                'attribute' => 'creator_id',
                'filter' => \app\models\Project::getAssigneeOptions($project->id),
                'value' => function ($data) {
                    return ($data->author) ? $data->author->getFullName() : '';
                }
            ], [
                'class' => 'kartik\grid\EditableColumn',
                'attribute' => 'assignee_id',
                'filter' => \app\models\Project::getAssigneeOptions($project->id),
                'value' => function ($data) {
                    return ($data->assignee) ? $data->assignee->getFullName() : '';
                },
                'editableOptions' => [
                    'header' => \Yii::t('app', 'Assignee'),
                    'inputType' => Editable::INPUT_DROPDOWN_LIST,
                    'data' => \app\models\Project::getAssigneeOptions($project->id),
                    'options' => ['prompt' => ' - ']
                ],
            ], [
                'attribute' => 'created_date',
                'filter' => false,
            ],
        ],
    ]); ?>

</div>

<style>
    #w0-container > table > thead > tr:nth-child(1) > th:nth-child(2) {
        width: 50px;
    }
    #w0-container > table > thead > tr:nth-child(1) > th:nth-child(5) {
        width: 40%;
    }
</style>