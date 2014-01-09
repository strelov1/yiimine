<?php
$this->breadcrumbs = array(
    $project->title => array('/project/view', 'url' => $project->identifier),
    'Wiki' => array('/wiki'),
    'Редактирование записи'
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

<h1><?php echo CHtml::encode($page->getWikiUid())?></h1>

<?php echo CHtml::beginForm('', 'post', array('id' => 'edit-page-form'))?>
<div>
<?php echo CHtml::activeTextArea($page, 'content')?>
</div>
<div>
	<?php echo CHtml::label(Yii::t('wiki', 'Change summary'), CHtml::getIdByName('comment'))?>: <?php echo CHtml::textField('comment', $comment)?>
</div>
<div>
<?php echo CHtml::submitButton(Yii::t('wiki', 'Save'))?>
</div>
<?php echo CHtml::endForm()?>