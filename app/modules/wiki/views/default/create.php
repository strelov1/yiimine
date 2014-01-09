<?php
$this->breadcrumbs = array(
    $project->title => array('/project/view', 'url' => $project->identifier),
    'Wiki' => array('/wiki/default/pageIndex'),
    'Добавление записи'
);

$this->menu = array(
    array('label' => $project->title, 'itemOptions' => array('class' => 'nav-header')),
    array('label' => 'Обзор', 'url' => $this->createUrl('/project/view', array('url' => $project->identifier))),
    array('label' => 'Задачи', 'url' => $this->createUrl('/issue')),
    array('label' => 'Wiki', 'url' => $this->createUrl('/wiki/default/pageIndex')),
    array('label' => 'Файлы', 'url' => $this->createUrl('/file')),
    '---',
    array('label' => 'Создать запись', 'url' => $this->createUrl('create'), 'itemOptions' => array('class' => 'active')),
);
?>

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'create-wiki-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
    )
); ?>
<fieldset>
    <legend><?php echo Yii::t('wiki', 'Type wiki title'); ?></legend>
    <div class="control-group">
        <label class="control-label" for="wikiTitle"><?php echo Yii::t('wiki', 'Title'); ?></label>
        <div class="controls">
            <input type="text" id="wikiTitle" name="wikiTitle" />
        </div>
    </div>
    <div class="form-actions">
        <?php echo CHtml::submitButton(Yii::t('wiki', 'Save'), array('class' => 'btn btn-primary')); ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>