<?php
$this->breadcrumbs = array(
    $project->title => array('/project/view', 'url' => $project->identifier),
    'Wiki',
);

$this->menu = array(
    array('label' => $project->title, 'itemOptions' => array('class' => 'nav-header')),
    array('label' => 'Обзор', 'url' => $this->createUrl('/project/view', array('url' => $project->identifier))),
    array('label' => 'Задачи', 'url' => $this->createUrl('/issue')),
    array('label' => 'Wiki', 'url' => $this->createUrl('/wiki'), 'itemOptions' => array('class' => 'active')),
    array('label' => 'Файлы', 'url' => $this->createUrl('/file')),
    '---',
    array('label' => 'Создать запись', 'url' => $this->createUrl('edit', array('uid' => 'index'))),
);
?>

<div>
    <div class="wiki-controls">
        <?php echo CHtml::link(Yii::t('wiki', 'Edit'), array('edit', 'uid' => $page->getWikiUid())) ?>
        <?php echo CHtml::link(Yii::t('wiki', 'History'), array('history', 'uid' => $page->getWikiUid())) ?>
    </div>
    <div class="wiki-text">
        <?php echo $text; ?>
    </div>
    <div class="wiki-controls">
        <?php echo CHtml::link(Yii::t('wiki', 'Edit'), array('edit', 'uid' => $page->getWikiUid())) ?>
        <?php echo CHtml::link(Yii::t('wiki', 'History'), array('history', 'uid' => $page->getWikiUid())) ?>

        <?php echo CHtml::link(Yii::t('wiki', 'Page Index'), array('pageIndex')) ?>
    </div>
</div>