<?php
$this->breadcrumbs = array(
    $project->title => array('/project/view', 'url' => $project->identifier),
    'Задачи' => array('/issue'),
    'Создать задачу'
);

$this->menu = array(
    array('label' => $project->title, 'itemOptions' => array('class' => 'nav-header')),
    array('label' => 'Обзор', 'url' => $this->createUrl('/project/view', array('url' => $project->identifier))),
    array('label' => 'Задачи', 'url' => $this->createUrl('/issue')),
    array('label' => 'Wiki', 'url' => $this->createUrl('/wiki')),
    array('label' => 'Файлы', 'url' => $this->createUrl('/file')),
    '---',
    array('label' => 'Создать задачу', 'url' => $this->createUrl('create'), 'itemOptions' => array('class' => 'active')),
);

$this->pageTitle = 'Создать задачу';

$this->renderPartial('_form', array('model' => $model));