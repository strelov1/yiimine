<?php
$images = new CActiveDataProvider('IssueFile', array(
    'criteria' => array(
        'condition' => 'issue_id=' . $model->id,
    ),
    'pagination' => array(
        'pageSize' => 20,
    ),
));

$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'image-grid',
    'dataProvider' => $images,
    'template' => "{items}",
    'columns' => array(
        array(
            'header' => 'Название',
            'filter' => false,
            'type' => 'raw',
            'value' => function($data) use($model) {
                return l(
                    img($model->getThumbFilePath() . $data->filename, '', 80, 80),
                    $model->getOrigFilePath() . $data->filename,
                    array(
                        'class' => 'fancybox',
                        'rel' => 'gallery'.$model->id,
                    )
                );
            }
        ),
        array(
            'header' => 'Путь до файла',
            'value' => function($data) use($model) {
                return $model->getOrigFilePath() . $data->filename;
            }
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{delete}',
            'deleteButtonUrl' => 'Yii::app()->createUrl("issue/deleteFile", array("id" => $data->id))',
        ),
    ),
));