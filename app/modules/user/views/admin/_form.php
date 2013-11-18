<div class="form">
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'user-form',
        'type' => 'horizontal',
        'enableAjaxValidation' => true,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
    ));?>

    <fieldset>
        <p class="note"><?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?></p>
        <?php echo $form->errorSummary($model); ?>

        <?php echo $form->textFieldRow($model, 'username', array('size' => 20, 'maxlength' => 20)); ?>
        <?php echo $form->passwordFieldRow($model, 'password', array('size' => 60, 'maxlength' => 128)); ?>
        <?php echo $form->textFieldRow($model, 'email', array('size' => 60, 'maxlength' => 128)); ?>
        <?php echo $form->dropDownListRow($model, 'superuser', User::itemAlias('AdminStatus')); ?>
        <?php echo $form->dropDownListRow($model, 'status', User::itemAlias('UserStatus')); ?>
    </fieldset>

    <div class="form-actions">
        <?php $this->widget('bootstrap.widgets.TbButton', array(
            'buttonType' => 'submit',
            'icon' => 'ok white',
            'type' => 'primary',
            'label' => $model->isNewRecord ? UserModule::t('Create') : UserModule::t('Save'),
        )); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->