<?php $this->pageTitle = 'Регистрация | ' . Yii::app()->name; ?>

    <h1><?php echo UserModule::t("Registration"); ?></h1>

<?php if (Yii::app()->user->hasFlash('registration')): ?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('registration'); ?>
    </div>
<?php else: ?>

    <div class="form">
        <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'registration-form',
            'enableAjaxValidation' => true,
            'type' => 'horizontal',
            'clientOptions' => array(
                'validateOnSubmit' => true,
            ),
            'htmlOptions' => array('enctype' => 'multipart/form-data'),
        )); ?>

        <?php echo $form->errorSummary($model); ?>

        <?php echo $form->textFieldRow($model, 'username', array('class' => 'span3')); ?>
        <?php echo $form->passwordFieldRow($model, 'password', array('hint' => UserModule::t("Minimal password length 4 symbols."), 'class' => 'span3')); ?>
        <?php echo $form->passwordFieldRow($model, 'verifyPassword', array('class' => 'span3')); ?>
        <?php echo $form->textFieldRow($model, 'email', array('class' => 'span3')); ?>

        <?php if (UserModule::doCaptcha('registration')): ?>
            <div class="control-group">
                <?php echo $form->labelEx($model, 'verifyCode', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php $this->widget('CCaptcha'); ?><br/>
                    <?php echo $form->textField($model, 'verifyCode'); ?>
                    <?php echo $form->error($model, 'verifyCode'); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="form-actions">
            <?php echo CHtml::submitButton(UserModule::t("Register"), array('class' => 'btn')); ?>
        </div>

        <?php $this->endWidget(); ?>
    </div><!-- form -->
<?php endif; ?>