<?php
use yii\helpers\Html;

$this->title = \Yii::t('app', 'Milestones').' - '.$project->title.' - '.$this->params['appSettings']['app_name'];

echo $this->render('/project/_topMenu', ['model' => $project]);

echo Html::a('<i class="fa fa-plus"></i> '.\Yii::t('app', 'Add'), ['/milestone/create', 'id' => $project->id], ['class' => 'btn btn-primary pull-right']);
?>
<h1><?= \Yii::t('app', 'Milestones'); ?></h1>

<?= \yii\grid\GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'layout' => '{items} {pager}',
    'columns' => [
        'title', 
        [
            'attribute' => 'end_date',
            'header' => \Yii::t('app', 'Days Left'),
            'format' => 'raw',
            'value' => function ($data) {
                return $data->daysLeft;
            }
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{update} {delete}'
        ],
    ],
]);