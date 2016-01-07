<?php
/* @var $this yii\web\View */
/* @var $model app\models\Milestone */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\jui\DatePicker;

$form = ActiveForm::begin([
    'layout' => 'horizontal',
]);
?>

<?php
echo $form->field($model, 'title');
echo $form->field($model, 'start_date')->widget(DatePicker::className(), [
    'dateFormat' => 'yyyy-MM-dd',
    'options' => [
        'class' => 'form-control'
    ],
]);
echo $form->field($model, 'end_date')->widget(DatePicker::className(), [
    'dateFormat' => 'yyyy-MM-dd',
    'options' => [
        'class' => 'form-control'
    ],
]);
?>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <?= Html::submitButton(($model->isNewRecord ? \Yii::t('app', 'Create') : \Yii::t('app', 'Save')), ['class' => 'btn btn-primary']); ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>