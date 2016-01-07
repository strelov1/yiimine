<?php
use yii\grid\GridView;

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'id',
        [
            'attribute' => 'status_id',
            'header' => 'Текст',
            'format' => 'raw',
            'value' => function($data) {
                return '<b>' . $data->user->getFullName() . ': </b>'
                    . 'Изменение статуса зачади на &laquo;' . \app\components\enums\StatusEnum::i()->getMap()[$data->status_id] . '&raquo;';
            }
        ],
    ],
]);