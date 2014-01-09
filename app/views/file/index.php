<?php
$this->breadcrumbs = array(
    $model->project->title => array('/project/view', 'url' => $model->project->identifier),
    'Файлы',
);

$this->menu = array(
    array('label' => $model->project->title, 'itemOptions' => array('class' => 'nav-header')),
    array('label' => 'Обзор', 'url' => $this->createUrl('/project/view', array('url' => $model->project->identifier))),
    array('label' => 'Задачи', 'url' => $this->createUrl('/issue')),
    array('label' => 'Wiki', 'url' => $this->createUrl('/wiki/default/pageIndex')),
    array('label' => 'Файлы', 'url' => $this->createUrl('/file'), 'itemOptions' => array('class' => 'active')),
    '---',
    array('label' => 'Добавить файл', 'url' => $this->createUrl('create')),
);

$this->renderPartial('application.views.common._flashMessage');

echo "<h1 style='float: left;'>Все файлы проекта {$model->project->title}</h1>";
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . l('Добавить', array('/file/create'), array('class' => 'btn', 'style' => 'margin-top: 15px;'));

$this->widget('bootstrap.widgets.TbGridView', array(
    'dataProvider' => $model->search(),
    'type' => 'striped bordered condensed',
    'columns' => array(
        array(
            'name' => 'name',
            'type' => 'html',
            'value' => function ($data) {
                return l($data->name, $data->getImageUrl()) . ' (' . $data->user->username . ')';
            }
        ),
        'description',
        'created_date',
        array(
            'class' => 'CButtonColumn',
            'template' => '{delete}'
        ),
    ),
)); ?>
<style type="text/css">
    #yw0_c0 {width: 370px;}
    #yw0_c1 {width: 350px;}
</style>