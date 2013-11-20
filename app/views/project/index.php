<?php
$this->menu = array(
    array('label' => 'Управление', 'itemOptions' => array('class' => 'nav-header')),
    array('label' => 'Список проектов', 'url' => $this->createUrl('index'), 'itemOptions' => array('class' => 'active')),
    array('label' => 'Создать', 'url' => $this->createUrl('create')),
);

$this->renderPartial('application.views.common._flashMessage');

$this->widget('bootstrap.widgets.TbGridView', array(
    'dataProvider'=>$model->search(),
    'type'=>'striped bordered condensed',
    'filter'=>$model,
    'columns'=>array(
        'id',
        array(
            'name' => 'title',
            'type' => 'raw',
            'value' => function($data) {
                $str = ($data->description) ? ' (<i>' . $data->description . '</i>)' : '';
                return l($data->title, array('/project/view', 'url' => $data->identifier)) . $str;
            }
        ),
        array(
            'name' => 'is_public',
            'header' => 'Доступ',
            'type' => 'html',
            'filter' => false,
            'value' => function($data) {
                if($data->is_public == 1)
                    return '<span class="label label-success">public</span>';
                else
                    return '<span class="label label-important">private</span>';
            }
        ),
        array(
            'class' => 'CButtonColumn',
            'template' => '{update} {delete}'
        ),
    ),
));
?>

<style type="text/css">
    #yw0_c0 { width: 30px; }
    #yw0_c2 { width: 50px; }
</style>