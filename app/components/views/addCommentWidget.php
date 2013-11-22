<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'issue-comment-form',
    'enableAjaxValidation'=>false,
    'type' => 'horizontal',
)); ?>

<?php echo $form->errorSummary($model); ?>

<?php echo $form->textAreaRow($model,'text',array('rows'=>6, 'cols'=>50, 'class'=>'span6')); ?>

    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType'=>'submit',
            'type'=>'primary',
            'label'=>$model->isNewRecord ? 'Добавить' : 'Сохранить',
        )); ?>
    </div>

<?php $this->endWidget(); ?>