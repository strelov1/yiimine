<?php
$this->breadcrumbs = array(
    $project->title => array('/project/view', 'url' => $project->identifier),
    'Wiki' => array('/wiki/default/pageIndex'),
    'Изменения'
);

$this->menu = array(
    array('label' => $project->title, 'itemOptions' => array('class' => 'nav-header')),
    array('label' => 'Обзор', 'url' => $this->createUrl('/project/view', array('url' => $project->identifier))),
    array('label' => 'Задачи', 'url' => $this->createUrl('/issue')),
    array('label' => 'Wiki', 'url' => $this->createUrl('/wiki/default/pageIndex')),
    array('label' => 'Файлы', 'url' => $this->createUrl('/file')),
    '---',
    array('label' => 'Создать запись', 'url' => $this->createUrl('create')),
);
?>


<h1>
    <?php echo CHtml::link(CHtml::encode($uid), array('view', 'uid' => $uid)) ?>
    &nbsp;diff for&nbsp;
    <?php echo CHtml::link('r' . $r1->id, array('view', 'uid' => $uid, 'rev' => $r1->id)) ?>
    →
    <?php echo CHtml::link('r' . $r2->id, array('view', 'uid' => $uid, 'rev' => $r2->id)) ?>
</h1>

<div class="wiki-diff"><?php echo $diff ?></div>