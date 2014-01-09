<?php $this->menu = array(
    array('label' => $model->title, 'itemOptions' => array('class' => 'nav-header')),
    array('label' => 'Обзор', 'url' => $this->createUrl('/project/view', array('url' => $model->identifier)), 'itemOptions' => array('class' => 'active')),
    array('label' => 'Задачи', 'url' => $this->createUrl('/issue')),
    array('label' => 'Wiki', 'url' => $this->createUrl('/wiki/default/pageIndex')),
    array('label' => 'Файлы', 'url' => $this->createUrl('/file')),
    '---',
    array('label' => 'Настройки', 'url' => $this->createUrl('update', array('id' => $model->id))),
);

$this->renderPartial('application.views.common._flashMessage');
?>

<h1>Обзор проекта <?= $model->title; ?></h1>

<a href="<?php echo url('issue/create'); ?>" class="btn"><i class="icon-plus"></i> Добавить задачу</a>
<br/><br/>
<?php $this->widget('IssueTableWidget', array('projectId' => $model->id)); ?>

<p>Добавить на страницу:</p>
<ul>
    <li>Кнопку "Добавить задачу"</li>
    <li>Новые / В работе / Закрытые задачи</li>
    <li>Лог действий</li>
</ul>