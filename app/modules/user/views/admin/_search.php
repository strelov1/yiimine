<div class="wide form">

    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id'=>'horizontalForm',
        'type'=>'horizontal',
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));?>

    <fieldset>
        <legend>Расширенный поиск</legend>
        <?php echo $form->textFieldRow($model, 'id'); ?>
        <?php echo $form->textFieldRow($model, 'username', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->textFieldRow($model, 'email', array('size' => 60, 'maxlength' => 128)); ?>
        <?php echo $form->textFieldRow($model, 'activkey', array('size' => 60, 'maxlength' => 128)); ?>
        <?php echo $form->textFieldRow($model, 'create_at'); ?>
        <?php echo $form->textFieldRow($model, 'lastvisit_at'); ?>
        <?php echo $form->dropDownListRow($model, 'superuser', $model->itemAlias('AdminStatus')); ?>
        <?php echo $form->dropDownListRow($model, 'status', $model->itemAlias('UserStatus')); ?>
    </fieldset>

    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'icon' => 'ok white',
            'type' => 'primary',
            'label' => 'Найти',
        )); ?>
        <?php echo CHtml::link('Закрыть', '#', array('class' => 'btn closeBtn')); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->