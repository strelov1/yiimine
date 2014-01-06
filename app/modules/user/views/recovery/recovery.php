<?php $this->pageTitle = 'Восстановление пароля | '.Yii::app()->name; ?>

    <h1><?php echo UserModule::t("Restore"); ?></h1>

<?php if (Yii::app()->user->hasFlash('recoveryMessage')): ?>
    <div class="success">
        <?php echo Yii::app()->user->getFlash('recoveryMessage'); ?>
    </div>
<?php else: ?>

    <div class="form">
        <?php /** @var BootActiveForm $form */
        $form2 = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'recovery-form',
            'type' => 'horizontal',
        ));
        ?>

        <?php echo $form2->errorSummary($form); ?>

        <?php echo $form2->textFieldRow($form, 'login_or_email', array('hint' => UserModule::t("Please enter your login or email addres."))); ?>

        <div class="control-group">
            <div class="controls">
                <?php echo CHtml::submitButton(UserModule::t("Restore"), array('class' => 'btn')); ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div><!-- form -->
<?php endif; ?>