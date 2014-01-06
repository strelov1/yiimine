<?php $this->pageTitle = 'Вход | ' . Yii::app()->name; ?>

    <h1><?php echo UserModule::t("Login"); ?></h1>

<?php if (Yii::app()->user->hasFlash('loginMessage')): ?>

    <div class="success">
        <?php echo Yii::app()->user->getFlash('loginMessage'); ?>
    </div>

<?php endif; ?>

    <div class="form">
        <?php /** @var BootActiveForm $form */
        $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
            'id' => 'login-form',
            'type' => 'horizontal',
        ));
        ?>

        <?php echo $form->errorSummary($model); ?>

        <?php echo $form->textFieldRow($model, 'username', array('class' => 'span4')); ?>
        <?php echo $form->passwordFieldRow($model, 'password', array('class' => 'span4')); ?>

        <div class="control-group">
            <div class="controls">
                <?php echo CHtml::link(UserModule::t("Register"), array('/user/registration')); ?>
                | <?php echo CHtml::link(UserModule::t("Lost Password?"), Yii::app()->getModule('user')->recoveryUrl); ?>
            </div>
        </div>

        <?php echo $form->checkBoxRow($model, 'rememberMe'); ?>

        <div class="control-group">
            <div class="controls">
                <?php echo CHtml::submitButton(UserModule::t("Login"), array('class' => 'btn')); ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
    <!-- form -->
<?php
$form = new CForm(array(
    'elements' => array(
        'username' => array(
            'type' => 'text',
            'maxlength' => 32,
        ),
        'password' => array(
            'type' => 'password',
            'maxlength' => 32,
        ),
        'rememberMe' => array(
            'type' => 'checkbox',
        )
    ),

    'buttons' => array(
        'login' => array(
            'type' => 'submit',
            'label' => 'Login',
        ),
    ),
), $model);
?>