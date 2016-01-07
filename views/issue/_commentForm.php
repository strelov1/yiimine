<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin([
    'layout' => 'horizontal',
]);

echo $form->field($model, 'text')->textarea(['rows' => 5]);
?>
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <?= Html::submitButton(\Yii::t('app', 'Send'), ['class' => 'btn btn-primary']); ?>
        </div>
    </div>
<?php ActiveForm::end();