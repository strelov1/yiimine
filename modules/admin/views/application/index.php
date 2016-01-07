<?php
use vova07\imperavi\Widget;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Settings */
/* @var $form yii\widgets\ActiveForm */

$this->title = \Yii::t('app', 'General Settings');
?>

<div class="clinic-share-form">

    <?php
    $form = ActiveForm::begin([
        'layout' => 'horizontal',
        'options' => [
            'enctype' => 'multipart/form-data',
        ],
    ]);
    ?>

    <?= $form->field($model, 'app_name')->textInput(); ?>
    <?php
    echo $form->field($model, 'app_logo')->fileInput();
    if ($model->app_logo) {
        echo "<div class='form-group'><div class='col-sm-offset-3 col-sm-9'>";
        echo Html::img('/uploads/settings/app_logo/'.$model->app_logo, ['class' => 'img-thumbnail', 'width' => 150]);
        echo "</div></div>";
    }
    ?>
    <?php
    echo $form->field($model, 'app_description')->widget(Widget::classname(), [
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
    ?>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <?= Html::submitButton(\Yii::t('app', 'Save'), ['class' => 'btn btn-primary']); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>