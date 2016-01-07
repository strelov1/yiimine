<?php
use yii\helpers\Html;

$this->title = \Yii::t('app', 'Files').' - '.$project->title.' - '.$this->params['appSettings']['app_name'];
echo $this->render('/project/_topMenu', ['model' => $project]);
?>
<div class="row">
    <div class="col-sm-10">
        <h1>
            <?php
            echo \Yii::t('app', 'Files');
            if (isset($tagId)) {
                echo ' / <i>' . \app\models\Tag::findOne($tagId)->name . '</i>';
            }
            ?>
        </h1>

        <?php
        echo $this->render('_form', ['model' => $model, 'project' => $project]);

        echo \yii\grid\GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'layout' => '{items} {pager}',
            'columns' => [
                [
                    'attribute' => 'file',
                    'format' => 'raw',
                    'value' => function ($data) {
                        return Html::a($data->file, \Yii::$app->params['urlImg'].'uploads/files/'.$data->id.'/'.$data->file, ['target' => '_blank']);
                    }
                ], [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{delete}'
                ],
            ],
        ]);?>
    </div>
    <div class="col-sm-2">
        <?= \app\components\widgets\TagsPanelWidget::widget(['modelName' => \app\models\TagModel::MODEL_FILES, 'projectId' => $project->id]); ?>
    </div>
</div>