<?php
use yii\grid\GridView;
use yii\helpers\Html;

$images = new \yii\data\ActiveDataProvider([
    'query' => \app\models\IssuePhoto::find()->where(['issue_id' => $model->id]),
]);

\yii\widgets\Pjax::begin(['id' => 'image-grid']);
echo GridView::widget([
    'dataProvider' => $images,
    'layout' => '{items} {pager}',
    'columns' => [
        [
            'header' => 'Изображение',
            'format' => 'raw',
            'value' => function ($data) use($model) {
                return Html::img($model->getMultiFileUrl() . $data->file, ['class' => 'img-thumbnail', 'style' => 'height: 100px;']);
            }
        ],
        'file',
        [
            'class' => 'yii\grid\ActionColumn',
            'template' => '{delete}',
            'buttons' => [
                'delete' => function ($url, $model, $key) {
                    $url = \yii\helpers\Url::to(['delete-image', 'id' => $model->id]);
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, ['class' => 'confirmLink', 'data-grid' => 'image-grid']);
                },
            ],
        ],
    ],
]);
\yii\widgets\Pjax::end();