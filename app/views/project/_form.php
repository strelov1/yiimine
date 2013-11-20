<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'project-form',
    'enableAjaxValidation'=>false,
    'type' => 'horizontal',
)); ?>

<fieldset>
    <legend><?= ($model->isNewRecord) ? 'Создание нового проекта' : 'Редактирование проекта: '.$model->title; ?></legend>
    <?php echo $form->errorSummary($model); ?>

    <?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>50)); ?>

    <?php echo $form->textFieldRow($model,'identifier',array('class'=>'span5','maxlength'=>10, 'hint' => 'Сокращенное название на латинице длиной от 3 до 10 символов')); ?>

    <?php echo $form->textAreaRow($model,'description',array('rows'=>6, 'class'=>'span5')); ?>

    <?php echo $form->checkBoxRow($model,'is_public'); ?>

    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>$model->isNewRecord ? 'Создать' : 'Сохранить',
        )); ?>
    </div>
</fieldset>

<?php $this->endWidget(); ?>