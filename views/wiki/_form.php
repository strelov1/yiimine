<?php
/* @var $this yii\web\View */
/* @var $model app\models\Wiki */
/* @var $form yii\bootstrap\ActiveForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use vova07\imperavi\Widget;
use kartik\select2\Select2;

$form = ActiveForm::begin([
    'layout' => 'horizontal',
]);
?>

<?php
echo $form->field($model, 'title');
echo $form->field($model, 'text')->widget(Widget::classname(), [
    'settings' => [
        'lang' => 'ru',
        'minHeight' => 400,
        'pastePlainText' => true,
        'buttonSource' => true,
        'plugins' => [
            'clips',
            'fullscreen'
        ],
    ]
]);

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
            <?= Html::submitButton(($model->isNewRecord ? \Yii::t('app', 'Create') : \Yii::t('app', 'Save')), ['class' => 'btn btn-primary']); ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>