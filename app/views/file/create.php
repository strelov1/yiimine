<?php
$this->breadcrumbs = array(
    $project->title => array('/project/view', 'url' => $project->identifier),
    'Файлы' => array('/file'),
    'Добавить файл'
);

$this->menu = array(
    array('label' => $project->title, 'itemOptions' => array('class' => 'nav-header')),
    array('label' => 'Обзор', 'url' => $this->createUrl('/project/view', array('url' => $project->identifier))),
    array('label' => 'Задачи', 'url' => $this->createUrl('/issue')),
    array('label' => 'Wiki', 'url' => $this->createUrl('/wiki')),
    array('label' => 'Файлы', 'url' => $this->createUrl('/file')),
    '---',
    array('label' => 'Добавить файл', 'url' => $this->createUrl('create'), 'itemOptions' => array('class' => 'active')),
);

$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id' => 'file-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data'
    ),
));
?>
    <fieldset>
        <legend>Добавление файла</legend>
        <?php
        echo $form->errorSummary($model);
        echo $form->fileFieldRow($model, 'name');
        echo $form->textFieldRow($model, 'description', array('class' => 'span5', 'maxlength' => 255));
        ?>

        <div class="form-actions">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'buttonType' => 'submit',
                'type' => 'primary',
                'label' => $model->isNewRecord ? 'Добавить' : 'Сохранить',
            )); ?>
        </div>
    </fieldset>
<?php $this->endWidget();