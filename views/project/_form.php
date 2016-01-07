<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use vova07\imperavi\Widget;

/* @var $this yii\web\View */
/* @var $model app\models\Project */
/* @var $form yii\bootstrap\ActiveForm */

$form = ActiveForm::begin(['layout' => 'horizontal']);
?>

<?php
if (\Yii::$app->controller->id == 'settings') {
    echo $form->field($model, 'status_id')->dropDownList(\app\components\enums\ProjectStatusEnum::i()->getMap());
}

echo $form->field($model, 'title')->textInput(['maxlength' => 255]);
echo $form->field($model, 'description')->widget(Widget::classname(), [
    'settings' => [
        'lang' => 'ru',
        'minHeight' => 300,
        'pastePlainText' => true,
        'buttonSource' => true,
        'plugins' => [
            'clips',
            'fullscreen'
        ],
    ]
]);
echo $form->field($model, 'is_public')->checkbox()->hint(\Yii::t('app','Any user can access to this project'));
?>

<div class="form-group">
    <div class="col-sm-offset-3 col-sm-9">
        <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-primary']); ?>
    </div>
</div>

<?php ActiveForm::end(); ?>