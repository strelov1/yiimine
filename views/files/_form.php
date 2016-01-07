<?php
/* @var $this yii\web\View */
/* @var $model app\models\Issue */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use kartik\select2\Select2;

$form = ActiveForm::begin([
    'layout' => 'inline',
    'options' => [
        'enctype' => 'multipart/form-data',
        'class' => 'm-b-10',
    ],
]);
echo $form->field($model, 'file[]')->fileInput(['multiple' => '']);
echo $form->field($model, 'tags')->widget(Select2::className(), [
    'options' => [
        'multiple' => true,
        'placeholder' => Yii::t('app', 'Choose tags'),
    ],
    'data' => \app\models\Tag::getOptions($project->id),
    'pluginOptions' => [
        'tags' => true,
        'maximumInputLength' => 254,
        'tokenSeparators' => [','],
    ],
]);
?>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <?= Html::submitButton(\Yii::t('app', 'Add'), ['class' => 'btn btn-primary']); ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>