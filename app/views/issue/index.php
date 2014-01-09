<?php
$this->breadcrumbs = array(
    $model->project->title => array('/project/view', 'url' => $model->project->identifier),
    'Задачи',
);

$this->menu = array(
    array('label' => $model->project->title, 'itemOptions' => array('class' => 'nav-header')),
    array('label' => 'Обзор', 'url' => $this->createUrl('/project/view', array('url' => $model->project->identifier))),
    array('label' => 'Задачи', 'url' => $this->createUrl('/issue'), 'itemOptions' => array('class' => 'active')),
    array('label' => 'Wiki', 'url' => $this->createUrl('/wiki/default/pageIndex')),
    array('label' => 'Файлы', 'url' => $this->createUrl('/file')),
    '---',
    array('label' => 'Создать задачу', 'url' => $this->createUrl('create')),
);

$this->renderPartial('application.views.common._flashMessage');

echo "<h1 style='float: left;'>Все задачи проекта {$model->project->title}</h1>";
echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . l('Создать', array('/issue/create'), array('class' => 'btn', 'style' => 'margin-top: 15px;'));

$this->widget('bootstrap.widgets.TbGridView', array(
    'dataProvider' => $model->search(),
    'type' => 'striped bordered condensed',
    'filter' => $model,
    'columns' => array(
        'id',
        array(
            'name' => 'status_id',
            'type' => 'html',
            'filter' => Issue::getStatusOptions(),
            'value' => function ($data) {
                if ($data->status_id == Issue::STATUS_NEW)
                    return '<span class="badge badge-success">new</span>';
                elseif ($data->status_id == Issue::STATUS_CLOSED)
                    return '<span class="badge badge-inverse">closed</span>';
                elseif ($data->status_id == Issue::STATUS_CANT_REPRODUCE)
                    return '<span class="badge badge-warning">can\'t</span>';
                elseif ($data->status_id == Issue::STATUS_IN_WORK)
                    return '<span class="badge badge-info">work</span>';
                elseif ($data->status_id == Issue::STATUS_REVIEW)
                    return '<span class="badge">review</span>';
            }
        ),
        array(
            'name' => 'subject',
            'type' => 'html',
            'value' => function ($data) {
                return l($data->subject, array('/issue/view', 'id' => $data->id));
            }
        ),
        array(
            'name' => 'tracker_id',
            'type' => 'html',
            'filter' => Issue::getTrackerOptions(),
            'value' => function ($data) {
                if ($data->tracker_id == Issue::TRACKER_BUG)
                    return '<span class="label label-important">bug</span>';
                else
                    return '<span class="label label-info">feature</span>';
            }
        ),
        array(
            'name' => 'priority_id',
            'type' => 'html',
            'filter' => Issue::getPriorityOptions(),
            'value' => function ($data) {
                if ($data->priority_id == Issue::PRIORITY_HIGH)
                    return '<span class="label label-important">high</span>';
                elseif ($data->priority_id == Issue::PRIORITY_MEDIUM)
                    return '<span class="label label-warning">medium</span>';
                else
                    return '<span class="label label-label">low</span>';
            }
        ),
        array(
            'name' => 'created_date',
            'header' => 'Обновлено',
            'filter' => false,
            'value' => function ($data) {
                if (empty($data->updated_date))
                    return date('d/m/Y H:i', strtotime($data->created_date));
                else
                    return date('d/m/Y H:i', strtotime($data->updated_date));
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
    #yw0_c0 {
        width: 30px;
    }

    #yw0_c1 {
        width: 50px;
    }

    #yw0_c3 {
        width: 60px;
    }

    #yw0_c4 {
        width: 60px;
    }

    #yw0_c5 {
        width: 120px;
    }
</style>