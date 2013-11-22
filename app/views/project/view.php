<?php $this->menu = array(
    array('label' => $model->title, 'itemOptions' => array('class' => 'nav-header')),
    array('label' => 'Обзор', 'url' => $this->createUrl('/project/view', array('url' => $model->identifier)), 'itemOptions' => array('class' => 'active')),
    array('label' => 'Задачи', 'url' => $this->createUrl('/issue')),
    array('label' => 'Wiki', 'url' => $this->createUrl('/wiki')),
    array('label' => 'Файлы', 'url' => $this->createUrl('/file')),
    '---',
    array('label' => 'Настройки', 'url' => $this->createUrl('create')),
);

$this->renderPartial('application.views.common._flashMessage');
?>

<h1>Обзор проекта <?= $model->title; ?></h1>

<p>Добавить на страницу:</p>
<ul>
    <li>Кнопку "Добавить задачу"</li>
    <li>Новые / В работе / Закрытые задачи</li>
    <li>Лог действий</li>
</ul>