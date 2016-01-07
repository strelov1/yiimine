<?php
use yii\helpers\Html;
$this->title = \Yii::t('app', 'Wiki').' - '.$project->title.' - '.$this->params['appSettings']['app_name'];
echo $this->render('/project/_topMenu', ['model' => $project]);
?>

<div class="row">
    <div class="col-sm-10">
        <?= Html::a('<i class="fa fa-plus"></i> '.\Yii::t('app', 'Add'), ['/wiki/create', 'id' => $project->id], ['class' => 'btn btn-primary pull-right']); ?>
        <h1>
            <?php
            echo \Yii::t('app', 'Wiki');
            if (isset($tagId)) {
                echo ' / <i>' . \app\models\Tag::findOne($tagId)->name . '</i>';
            }
            ?>
        </h1>

        <?= \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => '{items} {pager}',
            'columns' => [
                [
                    'attribute' => 'title',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return Html::a($data->title, ['/wiki/view', 'id' => $data->id]);
                    }
                ], [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{update} {delete}'
                ],
            ],
        ]);?>
    </div>
    <div class="col-sm-2">
        <?= \app\components\widgets\TagsPanelWidget::widget(['modelName' => \app\models\TagModel::MODEL_WIKI, 'projectId' => $project->id]); ?>
    </div>
</div>
